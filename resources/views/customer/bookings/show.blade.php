@extends('layouts.customer')

@section('title', 'Detail Booking')

@section('content')
    <section class="mx-auto max-w-4xl px-4 py-10 sm:px-6 lg:px-8">
        <a href="{{ route('customer.bookings.index') }}" class="inline-flex items-center gap-1 text-sm font-medium text-navy-700 hover:text-navy-800">
            <i data-lucide="arrow-left" class="h-4 w-4"></i> Kembali ke riwayat
        </a>

        <div class="mt-4 flex flex-wrap items-center justify-between gap-4">
            <div>
                <h1 class="text-3xl font-bold text-slate-900">Detail Booking</h1>
                <p class="mt-1 text-slate-500">{{ $booking->booking_code }}</p>
            </div>

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
            <span class="rounded-full px-3 py-1 text-sm font-semibold {{ $statusColors[$booking->status] ?? 'bg-slate-100' }}">
                {{ $booking->status_label }}
            </span>
        </div>

        <div class="mt-8 grid gap-8 md:grid-cols-3">
            <!-- Info mobil -->
            <div class="card overflow-hidden md:col-span-2">
                <div class="p-6">
                    <h2 class="text-lg font-semibold text-slate-900">Info Mobil</h2>
                    <div class="mt-4 flex items-center gap-4">
                        <img src="{{ $booking->car?->image_url }}" alt="{{ $booking->car?->name }}" class="h-20 w-32 rounded-lg object-cover">
                        <div>
                            <h3 class="text-xl font-semibold text-slate-900">{{ $booking->car?->brand }} {{ $booking->car?->model }}</h3>
                            <p class="text-sm text-slate-500">{{ $booking->car?->name }} • {{ $booking->car?->year }}</p>
                            <p class="mt-1 text-sm text-slate-500">
                                <i data-lucide="map-pin" class="inline h-3.5 w-3.5"></i> {{ $booking->car?->license_plate }}
                            </p>
                        </div>
                    </div>

                    <dl class="mt-6 grid gap-4 border-t border-slate-200 pt-6 sm:grid-cols-2">
                        <div>
                            <dt class="text-xs text-slate-500">Tanggal Mulai</dt>
                            <dd class="font-semibold text-slate-800">{{ $booking->start_date->format('d F Y') }}</dd>
                        </div>
                        <div>
                            <dt class="text-xs text-slate-500">Tanggal Selesai</dt>
                            <dd class="font-semibold text-slate-800">{{ $booking->end_date->format('d F Y') }}</dd>
                        </div>
                        <div>
                            <dt class="text-xs text-slate-500">No. HP</dt>
                            <dd class="font-semibold text-slate-800">{{ $booking->phone ?? auth()->user()->phone ?? '-' }}</dd>
                        </div>
                        <div>
                            <dt class="text-xs text-slate-500">Jumlah Hari</dt>
                            <dd class="font-semibold text-slate-800">{{ $booking->total_days }} hari</dd>
                        </div>
                        <div>
                            <dt class="text-xs text-slate-500">Harga per Hari</dt>
                            <dd class="font-semibold text-slate-800">Rp{{ number_format($booking->price_per_day, 0, ',', '.') }}</dd>
                        </div>
                        <div class="sm:col-span-2">
                            <dt class="text-xs text-slate-500">Total Harga</dt>
                            <dd class="text-2xl font-bold text-navy-700">Rp{{ number_format($booking->total_price, 0, ',', '.') }}</dd>
                        </div>
                        @if ($booking->notes)
                            <div class="sm:col-span-2">
                                <dt class="text-xs text-slate-500">Catatan</dt>
                                <dd class="text-slate-700">{{ $booking->notes }}</dd>
                            </div>
                        @endif
                    </dl>
                </div>
            </div>

            <!-- Aksi -->
            <div class="card h-fit p-6">
                <h2 class="text-lg font-semibold text-slate-900">Status & Aksi</h2>

                <!-- Status timeline sederhana -->
                <div class="mt-4 space-y-3">
                    @php
                        $statusFlow = ['waiting_payment', 'payment_verification', 'confirmed', 'ongoing', 'completed'];
                        $currentIndex = array_search($booking->status, $statusFlow);
                    @endphp
                    @foreach ($statusFlow as $index => $step)
                        @php
                            $labels = [
                                'waiting_payment' => 'Menunggu Pembayaran',
                                'payment_verification' => 'Menunggu Verifikasi',
                                'confirmed' => 'Dikonfirmasi',
                                'ongoing' => 'Rental Berlangsung',
                                'completed' => 'Selesai',
                            ];
                            $done = $currentIndex !== false && $index <= $currentIndex;
                        @endphp
                        <div class="flex items-center gap-3">
                            <div class="flex h-6 w-6 items-center justify-center rounded-full {{ $done ? 'bg-navy-700 text-white' : 'bg-slate-200 text-slate-400' }}">
                                @if ($done)
                                    <i data-lucide="check" class="h-4 w-4"></i>
                                @else
                                    <span class="text-xs">{{ $index + 1 }}</span>
                                @endif
                            </div>
                            <span class="text-sm {{ $done ? 'font-medium text-slate-800' : 'text-slate-400' }}">{{ $labels[$step] }}</span>
                        </div>
                    @endforeach
                </div>

                <div class="mt-6 space-y-3 border-t border-slate-200 pt-6">
                    @if (in_array($booking->status, ['pending', 'waiting_payment']))
                        <a href="{{ route('customer.payments.create', $booking) }}" class="btn-primary w-full py-3">
                            <i data-lucide="credit-card" class="h-4 w-4"></i>
                            Bayar Sekarang
                        </a>
                    @endif

                    @if (in_array($booking->status, ['pending', 'waiting_payment']))
                        <form method="POST" action="{{ route('customer.bookings.destroy', $booking) }}"
                            onsubmit="event.preventDefault(); confirmCancel(this)">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn-danger w-full">
                                <i data-lucide="x-circle" class="h-4 w-4"></i>
                                Batalkan Booking
                            </button>
                        </form>
                    @endif
                </div>
            </div>
        </div>
    </section>

    <script>
        function confirmCancel(form) {
            Swal.fire({
                title: 'Batalkan booking?',
                text: 'Booking yang dibatalkan tidak dapat dibatalkan lagi.',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#dc2626',
                cancelButtonColor: '#6b7280',
                confirmButtonText: 'Ya, batalkan',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) {
                    form.submit();
                }
            });
        }
    </script>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            if (window.lucide) {
                lucide.createIcons();
            }
        });
    </script>
@endsection
