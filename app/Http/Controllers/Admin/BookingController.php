<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use App\Services\BookingCsvService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\View\View;
use Barryvdh\DomPDF\Facade\Pdf;
use Symfony\Component\HttpFoundation\StreamedResponse;

class BookingController extends Controller
{
    /**
     * Menampilkan daftar semua booking dengan filter status & periode.
     */
    public function index(Request $request): View
    {
        [$start, $end] = $this->resolveRange($request);

        $query = Booking::with(['user', 'car', 'payment']);

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('booking_code', 'like', "%{$search}%")
                  ->orWhereHas('user', fn ($u) => $u->where('name', 'like', "%{$search}%"))
                  ->orWhereHas('car', fn ($c) => $c->where('name', 'like', "%{$search}%"));
            });
        }

        if ($start && $end) {
            $query->whereBetween('start_date', [$start, $end]);
        }

        $bookings = $query->latest()->paginate(15)->withQueryString();

        return view('admin.bookings.index', compact('bookings', 'start', 'end'));
    }

    /**
     * Mengunduh data booking periode tertentu sebagai file CSV.
     */
    public function export(Request $request, BookingCsvService $csv): StreamedResponse
    {
        [$start, $end] = $this->resolveRange($request);

        $bookings = $this->filteredQuery($request, $start, $end)->get();

        $filename = 'bookings-' . now()->format('Y-m-d-His') . '.csv';

        return response()->streamDownload(function () use ($csv, $bookings) {
            echo $csv->buildCsv($bookings);
        }, $filename, [
            'Content-Type' => 'text/csv; charset=UTF-8',
        ]);
    }

    /**
     * Mengunduh data booking periode tertentu sebagai file PDF.
     */
    public function exportPdf(Request $request)
    {
        [$start, $end] = $this->resolveRange($request);

        $bookings = $this->filteredQuery($request, $start, $end)->get();

        $startDate = $start ? Carbon::parse($start) : null;
        $endDate = $end ? Carbon::parse($end) : null;

        $pdf = Pdf::loadView('admin.bookings.export-pdf', compact('bookings', 'startDate', 'endDate'))
            ->setPaper('a4', 'landscape');

        return $pdf->download('bookings-' . now()->format('Y-m-d-His') . '.pdf');
    }

    /**
     * Query booking yang sudah difilter (periode + status + search).
     */
    protected function filteredQuery(Request $request, ?string $start, ?string $end)
    {
        $query = Booking::with(['user', 'car', 'payment']);

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('booking_code', 'like', "%{$search}%")
                  ->orWhereHas('user', fn ($u) => $u->where('name', 'like', "%{$search}%"))
                  ->orWhereHas('car', fn ($c) => $c->where('name', 'like', "%{$search}%"));
            });
        }

        if ($start && $end) {
            $query->whereBetween('start_date', [$start, $end]);
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
     * Menampilkan detail satu booking.
     */
    public function show(Booking $booking): View
    {
        $booking->load(['user', 'car.category', 'payment']);
        return view('admin.bookings.show', compact('booking'));
    }

    /**
     * Mengubah status booking oleh admin.
     */
    public function updateStatus(Request $request, Booking $booking): RedirectResponse
    {
        $request->validate([
            'status' => ['required', 'in:pending,waiting_payment,payment_verification,confirmed,ongoing,completed,cancelled'],
        ]);

        $booking->update([
            'status' => $request->status,
        ]);

        // Jika booking selesai / dibatalkan / menunggu, pastikan status mobil konsisten
        $car = $booking->car;

        if ($car) {
            if (in_array($request->status, ['ongoing', 'confirmed'])) {
                $car->update(['status' => 'rented']);
            } elseif (in_array($request->status, ['completed', 'cancelled'])) {
                $car->update(['status' => 'available']);
            }
        }

        return redirect()->route('admin.bookings.show', $booking)
            ->with('success', 'Status booking berhasil diperbarui.');
    }
}
