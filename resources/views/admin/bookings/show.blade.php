@extends('layouts.admin')

@section('title', 'Detail Booking')

@section('content')
    <a href="{{ route('admin.bookings.index') }}" class="inline-flex items-center gap-1 text-sm font-medium text-navy-700 hover:text-navy-800">
        <i data-lucide="arrow-left" class="h-4 w-4"></i> Kembali
    </a>

    <div class="mt-4 flex flex-wrap items-center justify-between gap-4">
        <div>
            <h1 class="text-2xl font-bold text-slate-900">Detail Booking</h1>
            <p class="mt-1 text-slate-500">{{ $booking->booking_code }}</p>
        </div>

        @php
            $colors = [
                'pending' => 'bg-slate-100 text-slate-700', 'waiting_payment' => 'bg-yellow-100 text-yellow-800',
                'payment_verification' => 'bg-blue-100 text-blue-700', 'confirmed' => 'bg-green-100 text-green-700',
                'ongoing' => 'bg-green-100 text-green-700', 'completed' => 'bg-slate-200 text-slate-700', 'cancelled' => 'bg-red-100 text-red-700',
            ];
        @endphp
        <span class="rounded-full px-3 py-1 text-sm font-semibold {{ $colors[$booking->status] ?? 'bg-slate-100' }}">{{ $booking->status_label }}</span>
    </div>

    <div class="mt-6 grid gap-6 lg:grid-cols-3">
        <!-- Info booking -->
        <div class="card overflow-hidden lg:col-span-2">
            <div class="p-6">
                <h2 class="text-lg font-semibold text-slate-900">Info Booking</h2>

                <div class="mt-4 flex items-center gap-4">
                    <img src="{{ $booking->car?->image_url }}" alt="{{ $booking->car?->name }}" class="h-20 w-32 rounded-lg object-cover">
                    <div>
                        <h3 class="text-xl font-semibold text-slate-900">{{ $booking->car?->brand }} {{ $booking->car?->model }}</h3>
                        <p class="text-sm text-slate-500">{{ $booking->car?->name }} • {{ $booking->car?->year }}</p>
                    </div>
                </div>

                <dl class="mt-6 grid gap-4 border-t border-slate-200 pt-6 sm:grid-cols-2">
                    <div>
                        <dt class="text-xs text-slate-500">Customer</dt>
                        <dd class="font-semibold text-slate-800">{{ $booking->user?->name }}</dd>
                        <dd class="text-sm text-slate-500">{{ $booking->user?->email }}</dd>
                        <dd class="text-sm text-slate-500">{{ $booking->phone ?? $booking->user?->phone ?? '-' }}</dd>
                    </div>
                    <div>
                        <dt class="text-xs text-slate-500">Tanggal</dt>
                        <dd class="font-semibold text-slate-800">{{ $booking->start_date->format('d M Y') }} – {{ $booking->end_date->format('d M Y') }}</dd>
                        <dd class="text-sm text-slate-500">{{ $booking->total_days }} hari</dd>
                    </div>
                    <div>
                        <dt class="text-xs text-slate-500">Harga per Hari</dt>
                        <dd class="font-semibold text-slate-800">Rp{{ number_format($booking->price_per_day, 0, ',', '.') }}</dd>
                    </div>
                    <div>
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

        <!-- Ubah status -->
        <div class="card h-fit p-6">
            <h2 class="text-lg font-semibold text-slate-900">Ubah Status</h2>
            <form method="POST" action="{{ route('admin.bookings.update-status', $booking) }}" class="mt-4">
                @csrf
                @method('PATCH')
                <select name="status" class="input-field">
                    @foreach (['pending', 'waiting_payment', 'payment_verification', 'confirmed', 'ongoing', 'completed', 'cancelled'] as $s)
                        <option value="{{ $s }}" {{ $booking->status == $s ? 'selected' : '' }}>{{ ucwords(str_replace('_', ' ', $s)) }}</option>
                    @endforeach
                </select>
                <button type="submit" class="btn-primary mt-3 w-full">
                    <i data-lucide="save" class="h-4 w-4"></i>
                    Simpan Status
                </button>
            </form>

            <!-- Info pembayaran -->
            <div class="mt-6 border-t border-slate-200 pt-6">
                <h3 class="text-sm font-semibold text-slate-900">Pembayaran</h3>
                @if ($booking->payment)
                    <dl class="mt-3 space-y-2 text-sm">
                        <div class="flex justify-between">
                            <dt class="text-slate-500">Metode</dt>
                            <dd>{{ $booking->payment->payment_type ?? '-' }}</dd>
                        </div>
                        <div class="flex justify-between">
                            <dt class="text-slate-500">Jumlah</dt>
                            <dd class="font-semibold">Rp{{ number_format($booking->payment->amount, 0, ',', '.') }}</dd>
                        </div>
                        <div class="flex justify-between">
                            <dt class="text-slate-500">Transaction ID</dt>
                            <dd class="font-mono text-xs">{{ $booking->payment->transaction_id ?? '-' }}</dd>
                        </div>
                        <div class="flex justify-between">
                            <dt class="text-slate-500">Status</dt>
                            <dd>
                                <span class="rounded-full px-2 py-0.5 text-xs font-medium
                                    {{ $booking->payment->status === 'verified' ? 'bg-green-100 text-green-700' : ($booking->payment->status === 'rejected' ? 'bg-red-100 text-red-700' : 'bg-yellow-100 text-yellow-700') }}">
                                    {{ $booking->payment->status_label }}
                                </span>
                            </dd>
                        </div>
                    </dl>
                @else
                    <p class="mt-2 text-sm text-slate-500">Belum ada pembayaran.</p>
                @endif
            </div>
        </div>
    </div>
@endsection

@section('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function () { if (window.lucide) lucide.createIcons(); });
</script>
@endsection
