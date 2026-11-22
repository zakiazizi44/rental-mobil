<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <title>Laporan Data Pembayaran</title>
    <style>
        body {
            font-family: sans-serif;
            font-size: 12px;
            color: #1e293b;
            margin: 30px;
        }
        h1 {
            font-size: 20px;
            margin-bottom: 4px;
        }
        .meta {
            font-size: 11px;
            color: #64748b;
            margin-bottom: 6px;
        }
        .range {
            font-size: 11px;
            font-weight: 600;
            color: #0f172a;
            margin-bottom: 20px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
        }
        th, td {
            border: 1px solid #cbd5e1;
            padding: 7px 8px;
            text-align: left;
            font-size: 11px;
        }
        th {
            background-color: #0f172a;
            color: #ffffff;
            font-weight: 600;
            text-transform: uppercase;
            font-size: 10px;
            letter-spacing: 0.5px;
        }
        tr:nth-child(even) {
            background-color: #f8fafc;
        }
        .text-right {
            text-align: right;
        }
        .text-center {
            text-align: center;
        }
        .total-row td {
            font-weight: 700;
            background-color: #e2e8f0;
        }
    </style>
</head>
<body>
    <h1>Laporan Data Pembayaran</h1>
    <p class="meta">Dicetak pada: {{ now()->format('d M Y H:i') }} &mdash; Total: {{ count($payments) }} pembayaran</p>
    @if ($startDate && $endDate)
        <p class="range">Periode: {{ $startDate->format('d M Y') }} &ndash; {{ $endDate->format('d M Y') }} (berdasarkan tanggal mulai booking)</p>
    @else
        <p class="range">Periode: Semua data</p>
    @endif

    @php
        $grandTotal = 0;
    @endphp

    <table>
        <thead>
            <tr>
                <th class="text-center">No</th>
                <th>Kode Booking</th>
                <th>Nama Customer</th>
                <th>No. HP</th>
                <th>Nama Mobil</th>
                <th>Tanggal Mulai</th>
                <th>Tanggal Selesai</th>
                <th class="text-center">Jumlah Hari</th>
                <th class="text-right">Total Harga</th>
                <th>Metode</th>
                <th>Transaction ID</th>
                <th class="text-center">Status</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($payments as $i => $payment)
                @php $grandTotal += (float) $payment->amount; @endphp
                <tr>
                    <td class="text-center">{{ $i + 1 }}</td>
                    <td>{{ $payment->booking?->booking_code ?? '-' }}</td>
                    <td>{{ $payment->booking?->user?->name ?? '-' }}</td>
                    <td>{{ $payment->booking?->phone ?? $payment->booking?->user?->phone ?? '-' }}</td>
                    <td>{{ $payment->booking?->car?->name ?? '-' }}</td>
                    <td>{{ $payment->booking && $payment->booking->start_date instanceof \DateTimeInterface ? $payment->booking->start_date->format('d M Y') : '-' }}</td>
                    <td>{{ $payment->booking && $payment->booking->end_date instanceof \DateTimeInterface ? $payment->booking->end_date->format('d M Y') : '-' }}</td>
                    <td class="text-center">{{ $payment->booking?->total_days ?? '-' }}</td>
                    <td class="text-right">Rp{{ number_format($payment->amount, 0, ',', '.') }}</td>
                    <td>{{ $payment->payment_type ?? '-' }}</td>
                    <td>{{ $payment->transaction_id ?? '-' }}</td>
                    <td class="text-center">{{ $payment->status_label }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="12" class="text-center">Tidak ada data pembayaran.</td>
                </tr>
            @endforelse
            @if (count($payments))
                <tr class="total-row">
                    <td colspan="8" class="text-right">Total</td>
                    <td class="text-right">Rp{{ number_format($grandTotal, 0, ',', '.') }}</td>
                    <td colspan="3"></td>
                </tr>
            @endif
        </tbody>
    </table>
</body>
</html>
