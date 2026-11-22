<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use App\Models\Payment;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\View\View;
use Midtrans\Config as MidtransConfig;
use Midtrans\Snap as MidtransSnap;

class PaymentController extends Controller
{
    /**
     * Menginisialisasi konfigurasi Midtrans dari config/services.php.
     */
    protected function configureMidtrans(): void
    {
        MidtransConfig::$serverKey = config('services.midtrans.server_key');
        MidtransConfig::$clientKey = config('services.midtrans.client_key');
        MidtransConfig::$isProduction = config('services.midtrans.is_production', false);
        MidtransConfig::$isSanitized = config('services.midtrans.is_sanitized', true);
        MidtransConfig::$is3ds = config('services.midtrans.is_3ds', true);
    }

    /**
     * Menampilkan halaman pembayaran dengan Snap token dari Midtrans.
     */
    public function create(Booking $booking): View
    {
        abort_unless($booking->user_id === auth()->id(), 403);

        if (! in_array($booking->status, ['waiting_payment', 'payment_verification'])) {
            abort(403, 'Booking tidak dalam status menunggu pembayaran.');
        }

        $booking->load(['car', 'payment']);

        $this->configureMidtrans();

        // Jika snap token sudah pernah dibuat, pakai kembali.
        $payment = $booking->payment;
        $snapToken = $payment->snap_token ?? null;

        if (! $snapToken) {
            $transactionDetails = [
                'order_id'     => $booking->booking_code,
                'gross_amount' => (int) round((float) $booking->total_price),
            ];

            $itemDetails = [
                [
                    'id'       => $booking->car->id,
                    'price'    => (int) round((float) $booking->car->price_per_day),
                    'quantity' => $booking->total_days,
                    'name'     => $booking->car->name,
                ],
            ];

            $customerDetails = [
                'first_name' => $booking->user->name,
                'email'      => $booking->user->email,
                'phone'      => $booking->phone ?? $booking->user->phone ?? '',
            ];

            $params = [
                'transaction_details' => $transactionDetails,
                'item_details'        => $itemDetails,
                'customer_details'    => $customerDetails,
            ];

            $snapToken = MidtransSnap::getSnapToken($params);

            $booking->payment()->updateOrCreate(
                ['booking_id' => $booking->id],
                [
                    'amount'     => $booking->total_price,
                    'status'     => 'pending',
                    'snap_token' => $snapToken,
                ]
            );
        }

        return view('customer.payments.create', [
            'booking'    => $booking,
            'snapToken'  => $snapToken,
            'clientKey'  => config('services.midtrans.client_key'),
            'isSandbox'  => ! config('services.midtrans.is_production'),
        ]);
    }

    /**
     * Menerima hasil dari popup Snap setelah customer selesai berinteraksi.
     * Data transaksi dicatat, namun status final hanya ditentukan oleh webhook
     * (notificationHandler) ketika Midtrans mengirim transaction_status=settlement.
     */
    public function store(Request $request, Booking $booking): RedirectResponse
    {
        abort_unless($booking->user_id === auth()->id(), 403);

        $data = $request->validate([
            'order_id'        => ['required', 'string'],
            'transaction_id'  => ['nullable', 'string'],
            'payment_type'    => ['nullable', 'string'],
            'transaction_status' => ['nullable', 'string'],
        ]);

        $payment = $booking->payment()->firstOrCreate(
            ['booking_id' => $booking->id],
            [
                'amount' => $booking->total_price,
                'status' => 'pending',
            ]
        );

        $payment->update([
            'transaction_id' => $data['transaction_id'] ?? $payment->transaction_id,
            'payment_type'   => $data['payment_type'] ?? $payment->payment_type,
            'paid_at'        => in_array($data['transaction_status'] ?? '', ['capture', 'settlement']) ? Carbon::now() : $payment->paid_at,
        ]);

        // Status booking hanya menunggu konfirmasi pembayaran, bukan otomatis
        // "terbayar". Finalisasi (confirmed/rented) dilakukan lewat webhook.
        $booking->update(['status' => 'payment_verification']);

        return redirect()->route('customer.bookings.show', $booking)
            ->with('success', 'Instruksi pembayaran telah dibuat. Menunggu konfirmasi pembayaran dari sistem.');
    }

    /**
     * Webhook notification dari Midtrans untuk finalisasi status pembayaran.
     * Endpoint ini bersifat publik (tanpa middleware CSRF).
     */
    public function notificationHandler(Request $request): JsonResponse
    {
        $this->configureMidtrans();

        // Baca payload notifikasi langsung dari request (JSON) agar dapat
        // diuji dengan simulasi manual maupun dipakai untuk webhook asli Midtrans.
        $payload = $request->all();

        $transactionStatus = $payload['transaction_status'] ?? null;
        $orderId = $payload['order_id'] ?? null;
        $transactionId = $payload['transaction_id'] ?? null;
        $paymentType = $payload['payment_type'] ?? null;
        $fraudStatus = $payload['fraud_status'] ?? '';

        if (! $orderId) {
            return response()->json(['status' => 'order_id required'], 422);
        }

        $booking = Booking::where('booking_code', $orderId)->first();

        if (! $booking) {
            return response()->json(['status' => 'order not found'], 404);
        }

        $payment = $booking->payment()->firstOrCreate(
            ['booking_id' => $booking->id],
            [
                'amount' => $booking->total_price,
                'status' => 'pending',
            ]
        );

        $payment->update([
            'transaction_id' => $transactionId ?? $payment->transaction_id,
            'payment_type'   => $paymentType ?? $payment->payment_type,
        ]);

        // Mapping status Midtrans ke status aplikasi.
        $finalStatus = $payment->status;
        $bookingStatus = $booking->status;

        switch ($transactionStatus) {
            case 'capture':
                if ($fraudStatus === 'accept') {
                    $finalStatus = 'verified';
                    $bookingStatus = 'confirmed';
                } elseif ($fraudStatus === 'challenge') {
                    $finalStatus = 'pending';
                    $bookingStatus = 'payment_verification';
                }
                break;
            case 'settlement':
                $finalStatus = 'verified';
                $bookingStatus = 'confirmed';
                break;
            case 'pending':
                $finalStatus = 'pending';
                $bookingStatus = 'payment_verification';
                break;
            case 'deny':
            case 'cancel':
            case 'expire':
                $finalStatus = 'rejected';
                $bookingStatus = 'waiting_payment';
                break;
            default:
                $finalStatus = 'pending';
                $bookingStatus = 'waiting_payment';
        }

        $payment->update([
            'status'      => $finalStatus,
            'verified_at' => in_array($finalStatus, ['verified']) ? Carbon::now() : $payment->verified_at,
        ]);

        $booking->update(['status' => $bookingStatus]);

        // Sinkronkan status mobil.
        $car = $booking->car;
        if ($car) {
            if (in_array($bookingStatus, ['ongoing', 'confirmed'])) {
                $car->update(['status' => 'rented']);
            } elseif (in_array($bookingStatus, ['completed', 'cancelled', 'waiting_payment'])) {
                $car->update(['status' => 'available']);
            }
        }

        return response()->json(['status' => 'ok']);
    }
}
