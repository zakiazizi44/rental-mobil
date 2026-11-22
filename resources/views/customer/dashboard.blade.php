@extends('layouts.customer')

@section('title', 'Dashboard')

@section('content')
    <section class="mx-auto max-w-6xl px-4 py-10 sm:px-6 lg:px-8">
        <div class="flex items-center justify-between">
            <div>
                <h1 class="text-3xl font-bold text-slate-900">Halo, {{ auth()->user()->name }}!</h1>
                <p class="mt-2 text-slate-500">Kelola pemesanan mobil Anda di sini.</p>
            </div>
            <a href="{{ route('cars.index') }}" class="btn-primary">
                <i data-lucide="car" class="h-4 w-4"></i>
                Sewa Mobil
            </a>
        </div>

        <!-- Statistik -->
        <div class="mt-8 grid gap-4 sm:grid-cols-3">
            <div class="card p-5">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm text-slate-500">Total Booking</p>
                        <p class="mt-1 text-3xl font-bold text-slate-900">{{ $totalBookings }}</p>
                    </div>
                    <div class="flex h-12 w-12 items-center justify-center rounded-xl bg-navy-100 text-navy-700">
                        <i data-lucide="calendar-check" class="h-6 w-6"></i>
                    </div>
                </div>
            </div>
            <div class="card p-5">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm text-slate-500">Booking Aktif</p>
                        <p class="mt-1 text-3xl font-bold text-slate-900">{{ $activeBookings }}</p>
                    </div>
                    <div class="flex h-12 w-12 items-center justify-center rounded-xl bg-green-100 text-green-700">
                        <i data-lucide="activity" class="h-6 w-6"></i>
                    </div>
                </div>
            </div>
            <div class="card p-5">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm text-slate-500">Selesai</p>
                        <p class="mt-1 text-3xl font-bold text-slate-900">{{ $completedBookings }}</p>
                    </div>
                    <div class="flex h-12 w-12 items-center justify-center rounded-xl bg-slate-100 text-slate-600">
                        <i data-lucide="badge-check" class="h-6 w-6"></i>
                    </div>
                </div>
            </div>
        </div>

        <!-- Booking aktif -->
        @if ($activeBooking)
            <div class="card mt-8 overflow-hidden">
                <div class="bg-gradient-to-r from-navy-800 to-navy-700 p-6 text-white">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-xs uppercase tracking-wider text-navy-200">Booking Aktif</p>
                            <h2 class="mt-1 text-xl font-bold">{{ $activeBooking->car?->brand }} {{ $activeBooking->car?->model }}</h2>
                            <p class="text-sm text-navy-100">
                                {{ $activeBooking->start_date->format('d M Y') }} – {{ $activeBooking->end_date->format('d M Y') }}
                            </p>
                        </div>
                        <span class="rounded-full bg-white/20 px-3 py-1 text-sm font-medium">{{ $activeBooking->status_label }}</span>
                    </div>
                    <a href="{{ route('customer.bookings.show', $activeBooking) }}" class="mt-4 inline-flex items-center gap-1 text-sm font-medium text-white hover:underline">
                        Lihat detail
                        <i data-lucide="arrow-right" class="h-4 w-4"></i>
                    </a>
                </div>
            </div>
        @endif

        <!-- Booking terbaru -->
        <div class="card mt-8">
            <div class="flex items-center justify-between border-b border-slate-200 p-6">
                <h2 class="text-lg font-semibold text-slate-900">Booking Terbaru</h2>
                <a href="{{ route('customer.bookings.index') }}" class="text-sm font-medium text-navy-700 hover:underline">Lihat semua</a>
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
                            <th class="px-6 py-3"></th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100">
                        @foreach ($recentBookings as $booking)
                            <tr>
                                <td class="px-6 py-4 text-xs font-medium text-slate-500">{{ $booking->booking_code }}</td>
                                <td class="px-6 py-4 font-medium text-slate-800">{{ $booking->car?->brand }} {{ $booking->car?->model }}</td>
                                <td class="px-6 py-4 text-slate-600">{{ $booking->start_date->format('d M') }}-{{ $booking->end_date->format('d M Y') }}</td>
                                <td class="px-6 py-4 font-semibold text-slate-800">Rp{{ number_format($booking->total_price, 0, ',', '.') }}</td>
                                <td class="px-6 py-4">
                                    @php
                                        $colors = [
                                            'pending' => 'bg-slate-100 text-slate-700', 'waiting_payment' => 'bg-yellow-100 text-yellow-800',
                                            'payment_verification' => 'bg-blue-100 text-blue-700', 'confirmed' => 'bg-green-100 text-green-700',
                                            'ongoing' => 'bg-green-100 text-green-700', 'completed' => 'bg-slate-200 text-slate-700', 'cancelled' => 'bg-red-100 text-red-700',
                                        ];
                                    @endphp
                                    <span class="rounded-full px-2.5 py-0.5 text-xs font-medium {{ $colors[$booking->status] ?? 'bg-slate-100' }}">{{ $booking->status_label }}</span>
                                </td>
                                <td class="px-6 py-4">
                                    <a href="{{ route('customer.bookings.show', $booking) }}" class="text-navy-700 hover:underline">Detail</a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </section>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            if (window.lucide) {
                lucide.createIcons();
            }
        });
    </script>
@endsection
