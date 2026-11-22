@extends('layouts.admin')

@section('title', 'Detail Pembayaran')

@section('content')
    <a href="{{ route('admin.payments.index') }}" class="inline-flex items-center gap-1 text-sm font-medium text-navy-700 hover:text-navy-800">
        <i data-lucide="arrow-left" class="h-4 w-4"></i> Kembali
    </a>

    <h1 class="mt-4 text-2xl font-bold text-slate-900">Detail Pembayaran</h1>

    <div class="mt-6 grid gap-6">
        <div class="card p-6">
            <h2 class="text-lg font-semibold text-slate-900">Detail Pembayaran</h2>
            <dl class="mt-4 space-y-3 text-sm">
                <div class="flex justify-between">
                    <dt class="text-slate-500">Booking</dt>
                    <dd class="font-semibold">{{ $payment->booking?->booking_code }}</dd>
                </div>
                <div class="flex justify-between">
                    <dt class="text-slate-500">Customer</dt>
                    <dd class="font-semibold">{{ $payment->booking?->user?->name }}</dd>
                </div>
                <div class="flex justify-between">
                    <dt class="text-slate-500">Mobil</dt>
                    <dd>{{ $payment->booking?->car?->brand }} {{ $payment->booking?->car?->model }}</dd>
                </div>
                <div class="flex justify-between">
                    <dt class="text-slate-500">Jumlah</dt>
                    <dd class="text-lg font-bold text-navy-700">Rp{{ number_format($payment->amount, 0, ',', '.') }}</dd>
                </div>
                <div class="flex justify-between">
                    <dt class="text-slate-500">Status</dt>
                    <dd>
                        <span class="rounded-full px-2 py-0.5 text-xs font-medium
                            {{ $payment->status === 'verified' ? 'bg-green-100 text-green-700' : ($payment->status === 'rejected' ? 'bg-red-100 text-red-700' : 'bg-yellow-100 text-yellow-700') }}">
                            {{ $payment->status_label }}
                        </span>
                    </dd>
                </div>
            </dl>
        </div>

        <div class="card p-6">
            <h2 class="text-lg font-semibold text-slate-900">Informasi Transaksi Midtrans</h2>
            <dl class="mt-4 space-y-3 text-sm">
                <div class="flex justify-between">
                    <dt class="text-slate-500">Transaction ID</dt>
                    <dd class="font-mono font-semibold">{{ $payment->transaction_id ?? '-' }}</dd>
                </div>
                <div class="flex justify-between">
                    <dt class="text-slate-500">Metode Pembayaran</dt>
                    <dd>{{ $payment->payment_type ?? '-' }}</dd>
                </div>
                <div class="flex justify-between">
                    <dt class="text-slate-500">Dibayar pada</dt>
                    <dd>{{ $payment->verified_at ? $payment->verified_at->format('d M Y H:i') : '-' }}</dd>
                </div>
            </dl>
        </div>
    </div>
@endsection

@section('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function () { if (window.lucide) lucide.createIcons(); });
</script>
@endsection
