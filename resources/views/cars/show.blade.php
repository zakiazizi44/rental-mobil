@extends('layouts.customer')

@section('title', $car->name)

@section('content')
    <section class="mx-auto max-w-7xl px-4 py-10 sm:px-6 lg:px-8">
        <nav class="mb-6 text-sm text-slate-500">
            <a href="{{ route('home') }}" class="hover:text-navy-700">Beranda</a>
            <span class="mx-2">/</span>
            <a href="{{ route('cars.index') }}" class="hover:text-navy-700">Mobil</a>
            <span class="mx-2">/</span>
            <span class="text-slate-700">{{ $car->name }}</span>
        </nav>

        <div class="grid gap-8 lg:grid-cols-2">
            <!-- Gambar -->
            <div class="card overflow-hidden">
                <img src="{{ $car->image_url }}" alt="{{ $car->name }}" class="h-80 w-full object-cover sm:h-96">
            </div>

            <!-- Info -->
            <div>
                <div class="flex items-center justify-between">
                    <span class="text-sm font-medium uppercase tracking-wide text-navy-600">{{ $car->category?->name }}</span>
                    @if ($car->status === 'available')
                        <span class="rounded-full bg-green-100 px-3 py-1 text-xs font-medium text-green-700">{{ $car->status_label }}</span>
                    @elseif ($car->status === 'rented')
                        <span class="rounded-full bg-yellow-100 px-3 py-1 text-xs font-medium text-yellow-700">{{ $car->status_label }}</span>
                    @else
                        <span class="rounded-full bg-red-100 px-3 py-1 text-xs font-medium text-red-700">{{ $car->status_label }}</span>
                    @endif
                </div>
                <h1 class="mt-2 text-3xl font-bold text-slate-900">{{ $car->brand }} {{ $car->model }}</h1>
                <p class="mt-1 text-slate-500">{{ $car->name }} • {{ $car->year }}</p>

                <div class="mt-4 flex items-baseline gap-1">
                    <span class="text-3xl font-bold text-navy-700">Rp{{ number_format($car->price_per_day, 0, ',', '.') }}</span>
                    <span class="text-slate-500">/ hari</span>
                </div>

                <div class="repeat-2 mt-6 grid gap-4 sm:grid-cols-2">
                    <div class="flex items-center gap-3 rounded-xl bg-slate-50 p-3">
                        <div class="flex h-10 w-10 items-center justify-center rounded-lg bg-navy-100 text-navy-700">
                            <i data-lucide="car" class="h-5 w-5"></i>
                        </div>
                        <div>
                            <p class="text-xs text-slate-500">Plat Nomor</p>
                            <p class="text-sm font-semibold text-slate-800">{{ $car->license_plate }}</p>
                        </div>
                    </div>
                    <div class="flex items-center gap-3 rounded-xl bg-slate-50 p-3">
                        <div class="flex h-10 w-10 items-center justify-center rounded-lg bg-navy-100 text-navy-700">
                            <i data-lucide="users" class="h-5 w-5"></i>
                        </div>
                        <div>
                            <p class="text-xs text-slate-500">Kapasitas</p>
                            <p class="text-sm font-semibold text-slate-800">{{ $car->capacity }} Kursi</p>
                        </div>
                    </div>
                    <div class="flex items-center gap-3 rounded-xl bg-slate-50 p-3">
                        <div class="flex h-10 w-10 items-center justify-center rounded-lg bg-navy-100 text-navy-700">
                            <i data-lucide="settings" class="h-5 w-5"></i>
                        </div>
                        <div>
                            <p class="text-xs text-slate-500">Transmisi</p>
                            <p class="text-sm font-semibold text-slate-800">{{ $car->transmission }}</p>
                        </div>
                    </div>
                    <div class="flex items-center gap-3 rounded-xl bg-slate-50 p-3">
                        <div class="flex h-10 w-10 items-center justify-center rounded-lg bg-navy-100 text-navy-700">
                            <i data-lucide="fuel" class="h-5 w-5"></i>
                        </div>
                        <div>
                            <p class="text-xs text-slate-500">Bahan Bakar</p>
                            <p class="text-sm font-semibold text-slate-800">{{ $car->fuel_type }}</p>
                        </div>
                    </div>
                    <div class="flex items-center gap-3 rounded-xl bg-slate-50 p-3">
                        <div class="flex h-10 w-10 items-center justify-center rounded-lg bg-navy-100 text-navy-700">
                            <i data-lucide="palette" class="h-5 w-5"></i>
                        </div>
                        <div>
                            <p class="text-xs text-slate-500">Warna</p>
                            <p class="text-sm font-semibold text-slate-800">{{ $car->color ?? '-' }}</p>
                        </div>
                    </div>
                    <div class="flex items-center gap-3 rounded-xl bg-slate-50 p-3">
                        <div class="flex h-10 w-10 items-center justify-center rounded-lg bg-navy-100 text-navy-700">
                            <i data-lucide="layers" class="h-5 w-5"></i>
                        </div>
                        <div>
                            <p class="text-xs text-slate-500">Tahun</p>
                            <p class="text-sm font-semibold text-slate-800">{{ $car->year }}</p>
                        </div>
                    </div>
                </div>

                <!-- Fasilitas -->
                @if ($car->facilities)
                    <div class="mt-6">
                        <h3 class="text-sm font-semibold text-slate-900">Fasilitas</h3>
                        <div class="mt-3 flex flex-wrap gap-2">
                            @foreach (explode(',', $car->facilities) as $facility)
                                <span class="inline-flex items-center gap-1 rounded-full bg-navy-50 px-3 py-1 text-xs font-medium text-navy-700">
                                    <i data-lucide="check-circle-2" class="h-3.5 w-3.5"></i>
                                    {{ trim($facility) }}
                                </span>
                            @endforeach
                        </div>
                    </div>
                @endif

                <!-- CTA -->
                <div class="mt-8">
                    <a href="{{ auth()->check() ? route('customer.bookings.create', $car) : route('customer.bookings.create', $car) }}" class="btn-primary w-full py-3.5 text-base">
                        <i data-lucide="calendar-check" class="h-5 w-5"></i>
                        Booking Sekarang
                    </a>
                </div>
            </div>
        </div>

        <!-- Deskripsi -->
        <div class="mt-10">
            <h2 class="text-xl font-bold text-slate-900">Deskripsi</h2>
            <p class="mt-3 leading-relaxed text-slate-600">{{ $car->description ?? 'Belum ada deskripsi untuk mobil ini.' }}</p>
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
