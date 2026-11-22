@extends('layouts.admin')

@section('title', 'Detail Customer')

@section('content')
    <a href="{{ route('admin.customers.index') }}" class="inline-flex items-center gap-1 text-sm font-medium text-navy-700 hover:text-navy-800">
        <i data-lucide="arrow-left" class="h-4 w-4"></i> Kembali
    </a>

    <div class="mt-4 flex items-center gap-4">
        <span class="flex h-14 w-14 items-center justify-center rounded-full bg-navy-700 text-white">
            <i data-lucide="user" class="h-7 w-7"></i>
        </span>
        <div>
            <h1 class="text-2xl font-bold text-slate-900">{{ $customer->name }}</h1>
            <p class="text-slate-500">{{ $customer->email }}</p>
            @if ($customer->phone)
                <p class="text-slate-500"><i data-lucide="phone" class="inline h-3.5 w-3.5"></i> {{ $customer->phone }}</p>
            @endif
        </div>
    </div>

    <div class="card mt-6">
        <div class="border-b border-slate-200 p-6">
            <h2 class="text-lg font-semibold text-slate-900">Riwayat Booking</h2>
        </div>
        <div class="overflow-x-auto">
            <table class="w-full text-left text-sm">
                <thead class="bg-slate-50 text-xs uppercase tracking-wider text-slate-500">
                    <tr>
                        <th class="px-6 py-3">Kode</th>
                        <th class="px-6 py-3">Mobil</th>
                        <th class="px-6 py-3">Tanggal</th>
                        <th class="px-6 py-3">Total</th>
                        <th class="px-6 py-3">Status</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse ($customer->bookings as $booking)
                        <tr>
                            <td class="px-6 py-4 text-xs font-medium text-slate-500">{{ $booking->booking_code }}</td>
                            <td class="px-6 py-4 text-slate-800">{{ $booking->car?->brand }} {{ $booking->car?->model }}</td>
                            <td class="px-6 py-4 text-slate-600">{{ $booking->start_date->format('d M Y') }} - {{ $booking->end_date->format('d M Y') }}</td>
                            <td class="px-6 py-4 font-semibold">Rp{{ number_format($booking->total_price, 0, ',', '.') }}</td>
                            <td class="px-6 py-4">
                                <a href="{{ route('admin.bookings.show', $booking) }}" class="text-navy-700 hover:underline">{{ $booking->status_label }}</a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-6 py-12 text-center text-slate-500">Customer ini belum memiliki booking.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
@endsection

@section('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function () { if (window.lucide) lucide.createIcons(); });
</script>
@endsection
