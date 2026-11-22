<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <title>Laporan Data Booking</title>
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
    </style>
</head>
<body>
    <h1>Laporan Data Booking</h1>
    <p class="meta">Dicetak pada: {{ now()->format('d M Y H:i') }} &mdash; Total: {{ count($bookings) }} booking</p>
    @if (! empty($startDate) && ! empty($endDate))
        <p class="meta">Periode: {{ $startDate->format('d M Y') }} &ndash; {{ $endDate->format('d M Y') }} (berdasarkan tanggal mulai)</p>
    @else
        <p class="meta">Periode: Semua data</p>
    @endif

    <table>
        <thead>
            <tr>
                <th class="text-center">No</th>
                <th>Kode Booking</th>
                <th>Nama Customer</th>
                <th>Email Customer</th>
                <th>No. HP</th>
                <th>Nama Mobil</th>
                <th>Tanggal Mulai</th>
                <th>Tanggal Selesai</th>
                <th class="text-center">Jumlah Hari</th>
                <th class="text-right">Harga/Hari</th>
                <th class="text-right">Total Harga</th>
                <th class="text-center">Status</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($bookings as $i => $booking)
                <tr>
                    <td class="text-center">{{ $i + 1 }}</td>
                    <td>{{ $booking->booking_code }}</td>
                    <td>{{ $booking->user?->name ?? '-' }}</td>
                    <td>{{ $booking->user?->email ?? '-' }}</td>
                    <td>{{ $booking->phone ?? $booking->user?->phone ?? '-' }}</td>
                    <td>{{ $booking->car?->name ?? '-' }}</td>
                    <td>{{ $booking->start_date instanceof \DateTimeInterface ? $booking->start_date->format('d M Y') : $booking->start_date }}</td>
                    <td>{{ $booking->end_date instanceof \DateTimeInterface ? $booking->end_date->format('d M Y') : $booking->end_date }}</td>
                    <td class="text-center">{{ $booking->total_days }}</td>
                    <td class="text-right">Rp{{ number_format($booking->price_per_day, 0, ',', '.') }}</td>
                    <td class="text-right">Rp{{ number_format($booking->total_price, 0, ',', '.') }}</td>
                    <td class="text-center">{{ $booking->status_label }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="12" class="text-center">Tidak ada data booking.</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</body>
</html>
