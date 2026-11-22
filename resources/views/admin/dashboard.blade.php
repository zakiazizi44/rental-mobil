@extends('layouts.admin')

@section('title', 'Dashboard')

@section('content')
    <div class="flex items-center justify-between">
        <div>
            <h1 class="text-2xl font-bold text-slate-900">Dashboard Admin</h1>
            <p class="mt-1 text-slate-500">Ringkasan aktivitas dan statistik sistem.</p>
        </div>
        <span class="rounded-full bg-navy-100 px-3 py-1 text-xs font-medium text-navy-700">
            {{ now()->format('l, d F Y') }}
        </span>
    </div>

    <!-- Stat Cards -->
    <div class="mt-6 grid gap-4 sm:grid-cols-2 lg:grid-cols-4">
        <div class="card p-5">
            <div class="flex items-center justify-between">
                <div class="flex h-11 w-11 items-center justify-center rounded-xl bg-navy-100 text-navy-700">
                    <i data-lucide="car" class="h-5 w-5"></i>
                </div>
            </div>
            <p class="mt-3 text-sm text-slate-500">Total Mobil</p>
            <p class="text-2xl font-bold text-slate-900">{{ $totalCars }}</p>
        </div>
        <div class="card p-5">
            <div class="flex items-center justify-between">
                <div class="flex h-11 w-11 items-center justify-center rounded-xl bg-green-100 text-green-700">
                    <i data-lucide="check-circle" class="h-5 w-5"></i>
                </div>
            </div>
            <p class="mt-3 text-sm text-slate-500">Mobil Tersedia</p>
            <p class="text-2xl font-bold text-slate-900">{{ $availableCars }}</p>
        </div>
        <div class="card p-5">
            <div class="flex items-center justify-between">
                <div class="flex h-11 w-11 items-center justify-center rounded-xl bg-yellow-100 text-yellow-700">
                    <i data-lucide="key-round" class="h-5 w-5"></i>
                </div>
            </div>
            <p class="mt-3 text-sm text-slate-500">Mobil Disewa</p>
            <p class="text-2xl font-bold text-slate-900">{{ $rentedCars }}</p>
        </div>
        <div class="card p-5">
            <div class="flex items-center justify-between">
                <div class="flex h-11 w-11 items-center justify-center rounded-xl bg-blue-100 text-blue-700">
                    <i data-lucide="users" class="h-5 w-5"></i>
                </div>
            </div>
            <p class="mt-3 text-sm text-slate-500">Total Customer</p>
            <p class="text-2xl font-bold text-slate-900">{{ $totalCustomers }}</p>
        </div>
    </div>

    <div class="mt-4 grid gap-4 sm:grid-cols-2 lg:grid-cols-4">
        <div class="card p-5">
            <div class="flex items-center justify-between">
                <div class="flex h-11 w-11 items-center justify-center rounded-xl bg-navy-100 text-navy-700">
                    <i data-lucide="calendar" class="h-5 w-5"></i>
                </div>
            </div>
            <p class="mt-3 text-sm text-slate-500">Total Booking</p>
            <p class="text-2xl font-bold text-slate-900">{{ $totalBookings }}</p>
        </div>
        <div class="card p-5">
            <div class="flex items-center justify-between">
                <div class="flex h-11 w-11 items-center justify-center rounded-xl bg-yellow-100 text-yellow-700">
                    <i data-lucide="wallet" class="h-5 w-5"></i>
                </div>
            </div>
            <p class="mt-3 text-sm text-slate-500">Menunggu Pembayaran</p>
            <p class="text-2xl font-bold text-slate-900">{{ $waitingPaymentBookings }}</p>
        </div>
        <div class="card p-5">
            <div class="flex items-center justify-between">
                <div class="flex h-11 w-11 items-center justify-center rounded-xl bg-green-100 text-green-700">
                    <i data-lucide="badge-check" class="h-5 w-5"></i>
                </div>
            </div>
            <p class="mt-3 text-sm text-slate-500">Confirmed Booking</p>
            <p class="text-2xl font-bold text-slate-900">{{ $confirmedBookings }}</p>
        </div>
        <div class="card p-5">
            <div class="flex items-center justify-between">
                <div class="flex h-11 w-11 items-center justify-center rounded-xl bg-slate-100 text-slate-600">
                    <i data-lucide="badge-check" class="h-5 w-5"></i>
                </div>
            </div>
            <p class="mt-3 text-sm text-slate-500">Completed Booking</p>
            <p class="text-2xl font-bold text-slate-900">{{ $completedBookings }}</p>
        </div>
    </div>

    <!-- Revenue Banner -->
    <div class="mt-4 bg-gradient-to-r from-navy-800 to-navy-700 rounded-2xl p-6 text-white flex items-center justify-between">
        <div>
            <p class="text-sm text-navy-200">Total Pendapatan</p>
            <p class="text-3xl font-bold">Rp{{ number_format($totalRevenue, 0, ',', '.') }}</p>
        </div>
        <div class="flex h-14 w-14 items-center justify-center rounded-2xl bg-white/10">
            <i data-lucide="wallet" class="h-7 w-7"></i>
        </div>
    </div>

    <!-- Recent Bookings -->
    <div class="card mt-6">
        <div class="flex items-center justify-between border-b border-slate-200 p-6">
            <h2 class="text-lg font-semibold text-slate-900">Booking Terbaru</h2>
            <a href="{{ route('admin.bookings.index') }}" class="text-sm font-medium text-navy-700 hover:underline">Lihat semua</a>
        </div>
        <div class="overflow-x-auto">
            <table class="w-full text-left text-sm">
                <thead class="bg-slate-50 text-xs uppercase tracking-wider text-slate-500">
                    <tr>
                        <th class="px-6 py-3">Kode</th>
                        <th class="px-6 py-3">Customer</th>
                        <th class="px-6 py-3">Mobil</th>
                        <th class="px-6 py-3">Tanggal</th>
                        <th class="px-6 py-3">Total</th>
                        <th class="px-6 py-3">Status</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @foreach ($recentBookings as $booking)
                        <tr>
                            <td class="px-6 py-4 text-xs font-medium text-slate-500">{{ $booking->booking_code }}</td>
                            <td class="px-6 py-4 text-slate-800">{{ $booking->user?->name }}</td>
                            <td class="px-6 py-4 text-slate-600">{{ $booking->car?->brand }} {{ $booking->car?->model }}</td>
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
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endsection
