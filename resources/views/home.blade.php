@extends('layouts.customer')

@section('title', 'Beranda')

@section('content')
    <!-- ============ HERO ============ -->
    <section class="relative overflow-hidden bg-navy-950">
        <!-- Background photo + overlay -->
        <div class="absolute inset-0">
            <img src="{{ asset('images/cars/hero-car.jpg') }}" alt="Armada RentalMobil" class="h-full w-full object-cover object-center">
            <div class="absolute inset-0 bg-gradient-to-r from-navy-950 via-navy-900/90 to-navy-800/30"></div>
            <div class="absolute inset-0 bg-gradient-to-t from-navy-950 via-transparent to-navy-900/20"></div>
        </div>
        <div class="hero-grid-bg absolute inset-0 opacity-50"></div>

        <div class="relative mx-auto flex min-h-[640px] max-w-7xl flex-col justify-center px-4 pb-20 pt-24 sm:px-6 lg:px-8 lg:pb-24 lg:pt-28">
            <div class="max-w-2xl">
                <h1 class="hero-text-shadow animate-fade-up animate-delay-100 mt-0 text-5xl font-extrabold leading-[1.05] tracking-tight text-white sm:text-6xl lg:text-7xl">
                    Sewa Mobil untuk<br class="hidden sm:block">
                    <span class="bg-gradient-to-r from-white via-navy-100 to-navy-300 bg-clip-text text-transparent">Setiap Perjalanan</span> Anda
                </h1>

                <p class="hero-text-shadow animate-fade-up animate-delay-200 mt-6 max-w-xl text-lg leading-relaxed text-navy-100">
                    RentalMobil menyediakan berbagai pilihan kendaraan yang nyaman, aman,
                    dan siap menemani perjalanan Anda. Pilih mobil, tentukan tanggal,
                    dan lakukan booking dengan mudah secara online.
                </p>

                <div class="animate-fade-up animate-delay-300 mt-9 flex flex-wrap items-center gap-4">
                    <a href="{{ route('cars.index') }}" class="group inline-flex items-center gap-2 rounded-xl bg-white px-7 py-3.5 text-sm font-bold text-navy-800 shadow-xl shadow-navy-950/40 transition hover:-translate-y-0.5 hover:bg-navy-50">
                        Lihat Mobil
                        <i data-lucide="arrow-right" class="h-4 w-4 transition-transform group-hover:translate-x-0.5"></i>
                    </a>
                    <a href="#cara-booking" class="inline-flex items-center gap-2 rounded-xl border border-white/25 bg-white/5 px-7 py-3.5 text-sm font-bold text-white backdrop-blur transition hover:border-white/50 hover:bg-white/10">
                        <i data-lucide="calendar-check" class="h-4 w-4"></i>
                        Cara Booking
                    </a>
                </div>

                <div class="animate-fade-up animate-delay-300 mt-10 flex flex-wrap gap-x-7 gap-y-3 text-sm text-navy-100">
                    <span class="inline-flex items-center gap-2">
                        <i data-lucide="check-circle-2" class="h-4 w-4 text-navy-300"></i> Armada terawat &amp; bergaransi
                    </span>
                    <span class="inline-flex items-center gap-2">
                        <i data-lucide="check-circle-2" class="h-4 w-4 text-navy-300"></i> Booking online 24/7
                    </span>
                    <span class="inline-flex items-center gap-2">
                        <i data-lucide="check-circle-2" class="h-4 w-4 text-navy-300"></i> Harga transparan
                    </span>
                </div>
            </div>
        </div>
    </section>

    <!-- ============ KEUNGGULAN (Layanan) ============ -->
    <section id="layanan" class="scroll-mt-24 bg-slate-50 py-20">
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
            <div class="mx-auto max-w-2xl text-center">
                <span class="inline-flex items-center gap-2 rounded-full bg-navy-50 px-3 py-1 text-xs font-semibold uppercase tracking-wide text-navy-600">
                    <i data-lucide="award" class="h-3.5 w-3.5"></i> Mengapa kami
                </span>
                <h2 class="mt-4 text-3xl font-extrabold tracking-tight text-slate-900 sm:text-4xl">Mengapa Memilih RentalMobil?</h2>
                <p class="mt-3 text-slate-500">Kenikmatan berkendara dimulai dari memilih layanan sewa yang tepat.</p>
            </div>

            <div class="mt-14 grid gap-6 sm:grid-cols-2 lg:grid-cols-4">
                <div class="card-lift group rounded-2xl bg-white p-7 shadow-sm ring-1 ring-slate-100">
                    <div class="flex h-12 w-12 items-center justify-center rounded-xl bg-navy-700 text-white shadow-lg shadow-navy-900/20 transition-transform duration-300 group-hover:scale-110">
                        <i data-lucide="car-front" class="h-6 w-6"></i>
                    </div>
                    <h3 class="mt-5 text-lg font-bold text-slate-900">Pilihan Mobil Berkualitas</h3>
                    <p class="mt-2 text-sm leading-relaxed text-slate-500">Berbagai pilihan mobil yang sesuai dengan kebutuhan setiap perjalanan Anda.</p>
                </div>

                <div class="card-lift group rounded-2xl bg-white p-7 shadow-sm ring-1 ring-slate-100">
                    <div class="flex h-12 w-12 items-center justify-center rounded-xl bg-navy-700 text-white shadow-lg shadow-navy-900/20 transition-transform duration-300 group-hover:scale-110">
                        <i data-lucide="mouse-pointer-click" class="h-6 w-6"></i>
                    </div>
                    <h3 class="mt-5 text-lg font-bold text-slate-900">Booking Mudah</h3>
                    <p class="mt-2 text-sm leading-relaxed text-slate-500">Pesan mobil secara online dengan proses yang sederhana dan cepat.</p>
                </div>

                <div class="card-lift group rounded-2xl bg-white p-7 shadow-sm ring-1 ring-slate-100">
                    <div class="flex h-12 w-12 items-center justify-center rounded-xl bg-navy-700 text-white shadow-lg shadow-navy-900/20 transition-transform duration-300 group-hover:scale-110">
                        <i data-lucide="wallet" class="h-6 w-6"></i>
                    </div>
                    <h3 class="mt-5 text-lg font-bold text-slate-900">Harga Transparan</h3>
                    <p class="mt-2 text-sm leading-relaxed text-slate-500">Informasi harga rental jelas, tanpa biaya tersembunyi.</p>
                </div>

                <div class="card-lift group rounded-2xl bg-white p-7 shadow-sm ring-1 ring-slate-100">
                    <div class="flex h-12 w-12 items-center justify-center rounded-xl bg-navy-700 text-white shadow-lg shadow-navy-900/20 transition-transform duration-300 group-hover:scale-110">
                        <i data-lucide="shield-check" class="h-6 w-6"></i>
                    </div>
                    <h3 class="mt-5 text-lg font-bold text-slate-900">Aman &amp; Terpercaya</h3>
                    <p class="mt-2 text-sm leading-relaxed text-slate-500">Kendaraan terawat, bergaransi, dan siap dipakai kapan saja.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- ============ ARMADA PILIHAN ============ -->
    <section id="armada" class="bg-white py-20 lg:py-24">
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
            <!-- Judul -->
            <div class="mx-auto max-w-2xl text-center">
                <span class="inline-flex items-center gap-2 rounded-full bg-navy-50 px-3 py-1 text-xs font-semibold uppercase tracking-wide text-navy-600">
                    <i data-lucide="car" class="h-3.5 w-3.5"></i> Armada kami
                </span>
                <h2 class="mt-4 text-3xl font-extrabold tracking-tight text-slate-900 sm:text-4xl lg:text-5xl">Armada Pilihan Kami</h2>
                <p class="mt-4 text-slate-500">Temukan kendaraan yang sesuai untuk menemani setiap perjalanan Anda.</p>
            </div>

            <!-- Daftar Mobil Unggulan -->
            <div class="mt-14 grid gap-6 sm:grid-cols-2 lg:grid-cols-3">
                @forelse ($featuredCars as $car)
                    <a href="{{ route('cars.show', $car) }}" class="group card overflow-hidden transition-shadow hover:shadow-md">
                        <div class="aspect-[16/10] overflow-hidden bg-slate-100">
                            <img src="{{ $car->image_url }}" alt="{{ $car->name }}" class="h-full w-full object-cover transition-transform duration-300 group-hover:scale-105">
                        </div>
                        <div class="p-5">
                            <div class="flex items-center justify-between">
                                <span class="text-xs font-medium uppercase tracking-wide text-navy-600">{{ $car->category?->name }}</span>
                                @if ($car->status === 'available')
                                    <span class="rounded-full bg-green-100 px-2.5 py-0.5 text-xs font-medium text-green-700">{{ $car->status_label }}</span>
                                @elseif ($car->status === 'rented')
                                    <span class="rounded-full bg-yellow-100 px-2.5 py-0.5 text-xs font-medium text-yellow-700">{{ $car->status_label }}</span>
                                @else
                                    <span class="rounded-full bg-red-100 px-2.5 py-0.5 text-xs font-medium text-red-700">{{ $car->status_label }}</span>
                                @endif
                            </div>
                            <h3 class="mt-2 text-lg font-semibold text-slate-900">{{ $car->brand }} {{ $car->model }} <span class="text-sm font-normal text-slate-500">{{ $car->year }}</span></h3>
                            <div class="mt-3 flex flex-wrap gap-x-4 gap-y-1 text-xs text-slate-500">
                                <span class="inline-flex items-center gap-1"><i data-lucide="users" class="h-3.5 w-3.5"></i>{{ $car->capacity }} Kursi</span>
                                <span class="inline-flex items-center gap-1"><i data-lucide="settings" class="h-3.5 w-3.5"></i>{{ $car->transmission }}</span>
                                <span class="inline-flex items-center gap-1"><i data-lucide="fuel" class="h-3.5 w-3.5"></i>{{ $car->fuel_type }}</span>
                            </div>
                            <div class="mt-4 border-t border-slate-100 pt-4">
                                <span class="text-xs text-slate-500">Harga per hari</span>
                                <p class="text-xl font-bold text-navy-700">Rp{{ number_format($car->price_per_day, 0, ',', '.') }}</p>
                            </div>
                        </div>
                    </a>
                @empty
                    <div class="col-span-full py-16 text-center">
                        <i data-lucide="search-x" class="mx-auto h-12 w-12 text-slate-300"></i>
                        <p class="mt-4 text-slate-500">Belum ada mobil yang tersedia.</p>
                    </div>
                @endforelse
            </div>

            <!-- Lihat Semua -->
            <div class="mt-12 text-center">
                <a href="{{ route('cars.index') }}" class="group inline-flex items-center gap-2 rounded-xl bg-navy-700 px-7 py-3 text-sm font-bold text-white shadow-lg shadow-navy-900/25 transition hover:-translate-y-0.5 hover:bg-navy-800">
                    Lihat Semua Mobil
                    <i data-lucide="arrow-right" class="h-4 w-4 transition-transform group-hover:translate-x-1"></i>
                </a>
            </div>
        </div>
    </section>

    <!-- ============ CARA BOOKING ============ -->
    <section id="cara-booking" class="scroll-mt-24 bg-slate-50 py-20">
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
            <div class="mx-auto max-w-2xl text-center">
                <span class="inline-flex items-center gap-2 rounded-full bg-navy-50 px-3 py-1 text-xs font-semibold uppercase tracking-wide text-navy-600">
                    <i data-lucide="route" class="h-3.5 w-3.5"></i> Cara kerja
                </span>
                <h2 class="mt-4 text-3xl font-extrabold tracking-tight text-slate-900 sm:text-4xl">Booking Mobil dalam 4 Langkah Mudah</h2>
                <p class="mt-3 text-slate-500">Proses yang ringkas, jelas, dan tanpa kerumitan.</p>
            </div>

            <div class="mt-16 grid gap-10 sm:grid-cols-2 lg:grid-cols-4">
                @php
                    $steps = [
                        ['icon' => 'car-front', 'title' => 'Pilih Mobil', 'desc' => 'Telusuri armada dan pilih mobil yang sesuai kebutuhan Anda.'],
                        ['icon' => 'calendar-range', 'title' => 'Tentukan Tanggal', 'desc' => 'Atur tanggal mulai dan selesai masa sewa.'],
                        ['icon' => 'clipboard-check', 'title' => 'Lakukan Booking', 'desc' => 'Konfirmasi pemesanan dengan data yang lengkap.'],
                        ['icon' => 'credit-card', 'title' => 'Konfirmasi Pembayaran', 'desc' => 'Bayar dan unggah bukti, booking langsung diproses.'],
                    ];
                @endphp

                @foreach ($steps as $step)
                    <div class="relative text-center">
                        @if (!$loop->last)
                            <div class="absolute left-[60%] top-8 hidden h-px w-[80%] bg-navy-200 lg:block"></div>
                        @endif
                        <div class="relative inline-flex flex-col items-center">
                            <span class="text-6xl font-black leading-none text-navy-100 select-none">{{ str_pad($loop->index + 1, 2, '0', STR_PAD_LEFT) }}</span>
                            <div class="-mt-8 flex h-16 w-16 items-center justify-center rounded-2xl bg-gradient-to-br from-navy-600 to-navy-800 text-white shadow-xl shadow-navy-900/25">
                                <i data-lucide="{{ $step['icon'] }}" class="h-7 w-7"></i>
                            </div>
                        </div>
                        <h3 class="mt-5 text-lg font-bold text-slate-900">{{ $step['title'] }}</h3>
                        <p class="mx-auto mt-2 max-w-[220px] text-sm leading-relaxed text-slate-500">{{ $step['desc'] }}</p>
                    </div>
                @endforeach
            </div>
        </div>
    </section>

    <!-- ============ STATISTIK ============ -->
    <section class="relative overflow-hidden bg-navy-900 py-20">
        <div class="absolute inset-0 opacity-30" style="background-image: radial-gradient(circle at 15% 30%, rgba(255,255,255,.12) 0%, transparent 30%), radial-gradient(circle at 85% 75%, rgba(255,255,255,.08) 0%, transparent 28%);"></div>
        <div class="hero-grid-bg absolute inset-0 opacity-40"></div>

        <div class="relative mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
            <div class="mx-auto max-w-2xl text-center">
                <h2 class="text-3xl font-extrabold tracking-tight text-white sm:text-4xl">Dipercaya Ribuan Pelanggan</h2>
                <p class="mt-3 text-navy-200">Angka yang terus tumbuh dari setiap perjalanan yang kami layani.</p>
            </div>

            <div class="mt-14 grid gap-10 text-center sm:grid-cols-2 lg:grid-cols-4">
                <div>
                    <div class="mx-auto flex h-14 w-14 items-center justify-center rounded-2xl bg-white/10 text-navy-200 ring-1 ring-white/15">
                        <i data-lucide="car-front" class="h-7 w-7"></i>
                    </div>
                    <p class="mt-4 text-5xl font-extrabold tracking-tight text-white">{{ number_format($stats['cars']) }}+</p>
                    <p class="mt-1 text-sm font-medium uppercase tracking-wide text-navy-300">Mobil Tersedia</p>
                </div>
                <div>
                    <div class="mx-auto flex h-14 w-14 items-center justify-center rounded-2xl bg-white/10 text-navy-200 ring-1 ring-white/15">
                        <i data-lucide="users" class="h-7 w-7"></i>
                    </div>
                    <p class="mt-4 text-5xl font-extrabold tracking-tight text-white">{{ number_format($stats['customers']) }}+</p>
                    <p class="mt-1 text-sm font-medium uppercase tracking-wide text-navy-300">Customer Terdaftar</p>
                </div>
                <div>
                    <div class="mx-auto flex h-14 w-14 items-center justify-center rounded-2xl bg-white/10 text-navy-200 ring-1 ring-white/15">
                        <i data-lucide="calendar-check" class="h-7 w-7"></i>
                    </div>
                    <p class="mt-4 text-5xl font-extrabold tracking-tight text-white">{{ number_format($stats['bookings']) }}+</p>
                    <p class="mt-1 text-sm font-medium uppercase tracking-wide text-navy-300">Booking Berhasil</p>
                </div>
                <div>
                    <div class="mx-auto flex h-14 w-14 items-center justify-center rounded-2xl bg-white/10 text-navy-200 ring-1 ring-white/15">
                        <i data-lucide="headset" class="h-7 w-7"></i>
                    </div>
                    <p class="mt-4 text-5xl font-extrabold tracking-tight text-white">24/7</p>
                    <p class="mt-1 text-sm font-medium uppercase tracking-wide text-navy-300">Layanan Terpercaya</p>
                </div>
            </div>
        </div>
    </section>

    <!-- ============ CTA PRE-FOOTER ============ -->
    <section class="mx-auto max-w-7xl px-4 py-20 sm:px-6 lg:px-8">
        <div class="relative overflow-hidden rounded-3xl bg-gradient-to-r from-navy-800 via-navy-700 to-navy-800 px-6 py-16 text-center text-white sm:px-16">
            <div class="absolute inset-0 opacity-20" style="background-image: radial-gradient(circle at 20% 20%, white 0%, transparent 35%), radial-gradient(circle at 80% 80%, white 0%, transparent 30%);"></div>
            <div class="relative">
                <h2 class="text-3xl font-extrabold tracking-tight sm:text-4xl">Siap Memulai Perjalanan Anda?</h2>
                <p class="mx-auto mt-4 max-w-xl text-navy-100">
                    Temukan mobil yang sesuai dengan kebutuhan Anda dan lakukan booking dengan mudah.
                </p>
                <a href="{{ route('cars.index') }}" class="group mt-8 inline-flex items-center gap-2 rounded-xl bg-white px-8 py-4 text-sm font-bold text-navy-800 shadow-xl transition hover:-translate-y-0.5 hover:bg-slate-50">
                    Cari Mobil Sekarang
                    <i data-lucide="arrow-right" class="h-4 w-4 transition-transform group-hover:translate-x-1"></i>
                </a>
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