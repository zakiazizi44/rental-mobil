<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use App\Models\Car;
use App\Services\BookingCsvService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Str;
use Illuminate\View\View;

class BookingController extends Controller
{
    /**
     * Menampilkan daftar riwayat booking milik customer.
     */
    public function index(): View
    {
        $bookings = Booking::with(['car', 'payment'])
            ->where('user_id', auth()->id())
            ->latest()
            ->get();

        return view('customer.bookings.index', compact('bookings'));
    }

    /**
     * Form pembuatan booking untuk mobil tertentu.
     */
    public function create(Request $request, Car $car): View
    {
        return view('customer.bookings.create', compact('car'));
    }

    /**
     * Menyimpan booking baru.
     *
     * Logic penting:
     * 1. Validasi tanggal (awal <= akhir, tidak di masa lalu).
     * 2. Pencegahan double booking di BACKEND dengan memeriksa
     *    booking aktif (confirmed/ongoing) yang bertabrakan tanggal.
     * 3. Perhitungan harga dilakukan ulang di backend
     *    (Total = Harga/hari x Jumlah hari), tidak mempercayai input frontend.
     * 4. Generate booking code unik.
     */
    public function store(Request $request, Car $car): RedirectResponse
    {
        $data = $request->validate([
            'start_date' => ['required', 'date', 'after_or_equal:today'],
            'end_date' => ['required', 'date', 'after_or_equal:start_date'],
            'phone' => ['required', 'string', 'max:20'],
            'notes' => ['nullable', 'string', 'max:1000'],
        ]);

        $startDate = Carbon::parse($data['start_date']);
        $endDate = Carbon::parse($data['end_date']);

        // Batasi durasi maksimal (misal 30 hari) agar tidak disalahgunakan
        if ($startDate->diffInDays($endDate) >= 30) {
            return back()->with('error', 'Durasi penyewaan maksimal 30 hari.');
        }

        // ============================================================
        // PENCEGAHAN DOUBLE BOOKING (dilakukan di BACKEND Laravel)
        // Cek apakah mobil sudah dibooking pada periode tanggal yang
        // bertabrakan oleh booking dengan status aktif (confirmed/ongoing).
        // ============================================================
        $isBooked = Booking::where('car_id', $car->id)
            ->whereIn('status', ['confirmed', 'ongoing'])
            ->where(function ($query) use ($startDate, $endDate) {
                // Booking lama dimulai di dalam rentang baru
                $query->whereBetween('start_date', [$startDate, $endDate])
                    // Booking lama berakhir di dalam rentang baru
                    ->orWhereBetween('end_date', [$startDate, $endDate])
                    // Booking lama mencakup seluruh rentang baru
                    ->orWhere(function ($q) use ($startDate, $endDate) {
                    $q->where('start_date', '<=', $startDate)
                        ->where('end_date', '>=', $endDate);
                });
            })
            ->exists();

        if ($isBooked) {
            return back()->with('error', 'Mobil tidak tersedia pada tanggal yang dipilih.');
        }

        // ============================================================
        // PERHITUNGAN HARGA (dilakukan di BACKEND)
        // Total Harga = Harga per Hari x Jumlah Hari (inklusif start-end)
        // ============================================================
        $totalDays = (int) round($startDate->diffInDays($endDate)) + 1;
        $pricePerDay = (int) round((float) $car->price_per_day);
        $totalPrice = $pricePerDay * $totalDays;

        // Generate booking code unik (BK-YYYYMMDD-XXXXXX)
        $bookingCode = $this->generateBookingCode($startDate);

        $booking = Booking::create([
            'booking_code' => $bookingCode,
            'user_id' => auth()->id(),
            'car_id' => $car->id,
            'phone' => $data['phone'],
            'start_date' => $startDate,
            'end_date' => $endDate,
            'total_days' => $totalDays,
            'price_per_day' => $pricePerDay,
            'total_price' => $totalPrice,
            'status' => 'waiting_payment',
            'notes' => $data['notes'] ?? null,
        ]);

        // Simpan data reservasi ke file CSV (append otomatis)
        try {
            app(BookingCsvService::class)->append($booking);
        } catch (\Throwable $e) {
            report($e);
        }

        return redirect()->route('customer.bookings.show', $booking)
            ->with('success', 'Booking berhasil dibuat. Silakan lakukan pembayaran.');
    }

    /**
     * Generate booking code unik.
     * Format: BK-<tanggal>-<6 karakter acak>.
     */
    protected function generateBookingCode(Carbon $date): string
    {
        do {
            $code = 'BK-' . $date->format('Ymd') . '-' . strtoupper(Str::random(6));
        } while (Booking::where('booking_code', $code)->exists());

        return $code;
    }

    /**
     * Menampilkan detail booking milik customer (status, pembayaran).
     */
    public function show(Booking $booking): View
    {
        // Pastikan customer hanya bisa melihat booking miliknya
        abort_unless($booking->user_id === auth()->id(), 403);

        $booking->load(['car.category', 'payment']);

        return view('customer.bookings.show', compact('booking'));
    }

    /**
     * Membatalkan booking (hanya jika masih menunggu pembayaran).
     */
    public function destroy(Booking $booking): RedirectResponse
    {
        abort_unless($booking->user_id === auth()->id(), 403);

        if (!in_array($booking->status, ['pending', 'waiting_payment'])) {
            return back()->with('error', 'Booking tidak dapat dibatalkan pada status saat ini.');
        }

        $booking->update(['status' => 'cancelled']);

        return redirect()->route('customer.bookings.index')
            ->with('success', 'Booking berhasil dibatalkan.');
    }
}
