@extends('layouts.customer')

@section('title', 'Riwayat Booking')

@section('content')
    <section class="mx-auto max-w-5xl px-4 py-10 sm:px-6 lg:px-8">
        <div class="flex items-center justify-between">
            <div>
                <h1 class="text-3xl font-bold text-slate-900">Riwayat Booking</h1>
                <p class="mt-2 text-slate-500">Semua pemesanan mobil yang pernah Anda lakukan.</p>
            </div>
            <a href="{{ route('cars.index') }}" class="btn-primary">
                <i data-lucide="plus" class="h-4 w-4"></i>
                Booking Baru
            </a>
        </div>

        <div class="mt-8 space-y-4">
            @forelse ($bookings as $booking)
                <div class="card overflow-hidden">
                    <div class="flex flex-col gap-4 p-5 sm:flex-row sm:items-center sm:justify-between">
                        <div class="flex items-center gap-4">
                            <img src="{{ $booking->car?->image_url }}" alt="{{ $booking->car?->name }}" class="h-16 w-24 rounded-lg object-cover">
                            <div>
                                <p class="text-xs font-medium text-slate-500">{{ $booking->booking_code }}</p>
                                <h3 class="font-semibold text-slate-900">{{ $booking->car?->brand }} {{ $booking->car?->model }}</h3>
                                <p class="text-sm text-slate-500">
                                    {{ $booking->start_date->format('d M Y') }} – {{ $booking->end_date->format('d M Y') }}
                                </p>
                                <p class="mt-1 text-sm font-bold text-navy-700">Rp{{ number_format($booking->total_price, 0, ',', '.') }}</p>
                            </div>
                        </div>

                        <div class="flex items-center gap-3">
                            @php
                                $statusColors = [
                                    'pending' => 'bg-slate-100 text-slate-700',
                                    'waiting_payment' => 'bg-yellow-100 text-yellow-800',
                                    'payment_verification' => 'bg-blue-100 text-blue-700',
                                    'confirmed' => 'bg-green-100 text-green-700',
                                    'ongoing' => 'bg-green-100 text-green-700',
                                    'completed' => 'bg-slate-200 text-slate-700',
                                    'cancelled' => 'bg-red-100 text-red-700',
                                ];
                            @endphp
                            <span class="rounded-full px-3 py-1 text-xs font-medium {{ $statusColors[$booking->status] ?? 'bg-slate-100' }}">
                                {{ $booking->status_label }}
                            </span>
                            <a href="{{ route('customer.bookings.show', $booking) }}" class="btn-secondary">
                                Detail
                            </a>
                        </div>
                    </div>
                </div>
            @empty
                <div class="card py-16 text-center">
                    <i data-lucide="calendar-x" class="mx-auto h-12 w-12 text-slate-300"></i>
                    <p class="mt-4 text-slate-500">Anda belum memiliki booking.</p>
                    <a href="{{ route('cars.index') }}" class="btn-primary mt-4">Mulai Booking</a>
                </div>
            @endforelse
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
