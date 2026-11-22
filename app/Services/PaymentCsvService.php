<?php

namespace App\Services;

use App\Models\Payment;
use Illuminate\Database\Eloquent\Collection;

class PaymentCsvService
{
    public const BOM = "\xEF\xBB\xBF";

    protected function headers(): array
    {
        return [
            'No',
            'Kode Booking',
            'Nama Customer',
            'Email Customer',
            'No. HP',
            'Nama Mobil',
            'Tanggal Mulai',
            'Tanggal Selesai',
            'Jumlah Hari',
            'Total Harga',
            'Metode Pembayaran',
            'Transaction ID',
            'Status Pembayaran',
            'Dibayar Pada',
        ];
    }

    public function buildCsv($payments): string
    {
        $handle = fopen('php://temp', 'r+');
        fwrite($handle, self::BOM);

        fputcsv($handle, $this->headers());

        /** @var Payment $payment */
        foreach ($payments as $i => $payment) {
            fputcsv($handle, $this->formatRow($payment, $i + 1));
        }

        rewind($handle);
        $content = stream_get_contents($handle);
        fclose($handle);

        return $content;
    }

    protected function formatRow(Payment $payment, int $index): array
    {
        $booking = $payment->booking;
        $car = $booking?->car;
        $user = $booking?->user;

        return [
            $index,
            $booking?->booking_code ?? '',
            $user?->name ?? '',
            $user?->email ?? '',
            $booking?->phone ?? $user?->phone ?? '',
            $car?->name ?? '',
            $booking && $booking->start_date instanceof \DateTimeInterface
                ? $booking->start_date->format('Y-m-d')
                : ($booking?->start_date ?? ''),
            $booking && $booking->end_date instanceof \DateTimeInterface
                ? $booking->end_date->format('Y-m-d')
                : ($booking?->end_date ?? ''),
            $booking?->total_days ?? '',
            $payment->amount,
            $payment->payment_type ?? '',
            $payment->transaction_id ?? '',
            $payment->status_label,
            $payment->verified_at instanceof \DateTimeInterface
                ? $payment->verified_at->format('Y-m-d H:i:s')
                : '',
        ];
    }
}
