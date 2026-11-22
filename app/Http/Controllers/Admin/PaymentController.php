<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Payment;
use App\Services\PaymentCsvService;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\View\View;
use Barryvdh\DomPDF\Facade\Pdf;
use Symfony\Component\HttpFoundation\StreamedResponse;

class PaymentController extends Controller
{
    /**
     * Menampilkan daftar pembayaran.
     */
    public function index(Request $request): View
    {
        [$start, $end] = $this->resolveRange($request);

        $query = Payment::with(['booking.user', 'booking.car']);

        if ($request->filled('search')) {
            $search = $request->search;
            $query->whereHas('booking', fn ($b) => $b->where('booking_code', 'like', "%{$search}%"));
        }

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if ($start && $end) {
            $query->whereHas('booking', fn ($b) => $b->whereBetween('start_date', [$start, $end]));
        }

        $payments = $query->latest()->paginate(15)->withQueryString();

        return view('admin.payments.index', compact('payments', 'start', 'end'));
    }

    /**
     * Mengunduh pembayaran dalam periode tertentu sebagai file CSV.
     */
    public function export(Request $request, PaymentCsvService $csv): StreamedResponse
    {
        [$start, $end] = $this->resolveRange($request);

        $payments = $this->filterQuery($request, $start, $end)->get();

        $filename = 'payments-' . now()->format('Y-m-d-His') . '.csv';

        return response()->streamDownload(function () use ($csv, $payments) {
            echo $csv->buildCsv($payments);
        }, $filename, [
            'Content-Type' => 'text/csv; charset=UTF-8',
        ]);
    }

    /**
     * Mengunduh pembayaran dalam periode tertentu sebagai file PDF.
     */
    public function exportPdf(Request $request)
    {
        [$start, $end] = $this->resolveRange($request);

        $payments = $this->filterQuery($request, $start, $end)->get();

        $startDate = $start ? Carbon::parse($start) : null;
        $endDate = $end ? Carbon::parse($end) : null;

        $pdf = Pdf::loadView('admin.payments.export-pdf', compact('payments', 'startDate', 'endDate'))
            ->setPaper('a4', 'landscape');

        return $pdf->download('payments-' . now()->format('Y-m-d-His') . '.pdf');
    }

    /**
     * Query pembayaran yang sudah difilter (period + status + search).
     */
    protected function filterQuery(Request $request, ?string $start, ?string $end)
    {
        $query = Payment::with(['booking.user', 'booking.car']);

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if ($start && $end) {
            $query->whereHas('booking', fn ($b) => $b->whereBetween('start_date', [$start, $end]));
        }

        return $query;
    }

    /**
     * Menentukan rentang tanggal dari request (preset atau custom).
     *
     * @return array{0: ?string, 1: ?string} [start, end]
     */
    protected function resolveRange(Request $request): array
    {
        if ($request->filled('start') && $request->filled('end')) {
            return [$request->start, $request->end];
        }

        $range = $request->range;
        $now = Carbon::now();

        return match ($range) {
            'today' => [$now->copy()->startOfDay()->toDateString(), $now->copy()->endOfDay()->toDateString()],
            'week'  => [$now->copy()->startOfWeek()->toDateString(), $now->copy()->endOfWeek()->toDateString()],
            'month' => [$now->copy()->startOfMonth()->toDateString(), $now->copy()->endOfMonth()->toDateString()],
            'year'  => [$now->copy()->startOfYear()->toDateString(), $now->copy()->endOfYear()->toDateString()],
            default => [null, null],
        };
    }

    /**
     * Menampilkan detail pembayaran.
     */
    public function show(Payment $payment): View
    {
        $payment->load(['booking.user', 'booking.car']);
        return view('admin.payments.show', compact('payment'));
    }
}
