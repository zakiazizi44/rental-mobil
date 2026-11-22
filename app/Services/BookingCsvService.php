<?php

namespace App\Services;

use App\Models\Booking;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;

class BookingCsvService
{
    public const BOM = "\xEF\xBB\xBF";

    public const DIRECTORY = 'exports';

    public const FILENAME = 'bookings.csv';

    protected function headers(): array
    {
        return [
            'Kode Booking',
            'Nama Customer',
            'Email Customer',
            'No. HP',
            'Nama Mobil',
            'Tanggal Mulai',
            'Tanggal Selesai',
            'Jumlah Hari',
            'Harga per Hari',
            'Total Harga',
            'Status',
            'Catatan',
            'Dibuat Pada',
        ];
    }

    public function path(): string
    {
        return self::DIRECTORY . '/' . self::FILENAME;
    }

    public function absolutePath(): string
    {
        return Storage::disk('local')->path($this->path());
    }

    public function exists(): bool
    {
        $disk = Storage::disk('local');
        return $disk->exists($this->path()) && $disk->size($this->path()) > 0;
    }

    public function append(Booking $booking): void
    {
        $booking->load(['user', 'car']);

        $disk = Storage::disk('local');
        $absolute = $disk->path($this->path());

        $this->ensureDirectory();

        $handle = fopen($absolute, 'a');
        flock($handle, LOCK_EX);

        if (! $this->exists()) {
            fwrite($handle, self::BOM);
            fputcsv($handle, $this->headers());
        }

        fputcsv($handle, $this->formatRow($booking));

        flock($handle, LOCK_UN);
        fclose($handle);
    }

    public function writeAll(): void
    {
        $disk = Storage::disk('local');

        $this->ensureDirectory();

        $handle = fopen($disk->path($this->path()), 'w');
        flock($handle, LOCK_EX);

        fwrite($handle, self::BOM);
        $this->streamAll($handle);

        flock($handle, LOCK_UN);
        fclose($handle);
    }

    public function buildCsv($bookings = null): string
    {
        $bookings = $bookings ?? Booking::with(['user', 'car'])->get();

        $handle = fopen('php://temp', 'r+');
        fwrite($handle, self::BOM);

        $this->streamAll($handle, $bookings);

        rewind($handle);
        $content = stream_get_contents($handle);
        fclose($handle);

        return $content;
    }

    protected function ensureDirectory(): void
    {
        $dir = Storage::disk('local')->path(self::DIRECTORY);
        if (! file_exists($dir)) {
            File::makeDirectory($dir, 0775, true);
        }
    }

    protected function streamAll($handle, $bookings): void
    {
        fputcsv($handle, $this->headers());

        foreach ($bookings as $booking) {
            fputcsv($handle, $this->formatRow($booking));
        }
    }

    protected function formatRow(Booking $booking): array
    {
        return [
            $booking->booking_code,
            $booking->user?->name ?? '',
            $booking->user?->email ?? '',
            $booking->phone ?? $booking->user?->phone ?? '',
            $booking->car?->name ?? '',
            $booking->start_date instanceof \DateTimeInterface ? $booking->start_date->format('Y-m-d') : $booking->start_date,
            $booking->end_date instanceof \DateTimeInterface ? $booking->end_date->format('Y-m-d') : $booking->end_date,
            $booking->total_days,
            $booking->price_per_day,
            $booking->total_price,
            $booking->getStatusLabelAttribute(),
            $booking->notes ?? '',
            $booking->created_at instanceof \DateTimeInterface ? $booking->created_at->format('Y-m-d H:i:s') : $booking->created_at,
        ];
    }
}