@extends('layouts.admin')

@section('title', 'Pembayaran')

@section('content')
    <div class="flex items-center justify-between">
        <div>
            <h1 class="text-2xl font-bold text-slate-900">Daftar Pembayaran</h1>
            <p class="mt-1 text-slate-500">Riwayat pembayaran (status diperbarui otomatis oleh Midtrans).</p>
        </div>
        <div x-data="{ open: false }" class="relative">
            <button @click="open = !open" @keydown.escape="open = false" class="btn-secondary">
                <i data-lucide="download" class="h-4 w-4"></i> Export
                <i data-lucide="chevron-down" class="h-4 w-4"></i>
            </button>
            <div x-show="open" @click.away="open = false" x-transition
                 class="absolute right-0 z-50 mt-2 w-44 rounded-2xl border border-slate-100 bg-white p-1.5 shadow-xl">
                <button form="filterForm" formaction="{{ route('admin.payments.export-pdf') }}" formmethod="get"
                        class="flex w-full items-center gap-2 rounded-xl px-3 py-2.5 text-sm font-medium text-slate-700 transition hover:bg-slate-50">
                    <i data-lucide="file-text" class="h-4 w-4 text-red-500"></i> Export PDF
                </button>
                <button form="filterForm" formaction="{{ route('admin.payments.export') }}" formmethod="get"
                        class="flex w-full items-center gap-2 rounded-xl px-3 py-2.5 text-sm font-medium text-slate-700 transition hover:bg-slate-50">
                    <i data-lucide="file-type" class="h-4 w-4 text-green-600"></i> Export CSV
                </button>
            </div>
        </div>
    </div>

    <!-- Filter periode -->
    <div class="card mt-6 p-4">
        <form id="filterForm" method="GET" action="{{ route('admin.payments.index') }}">
            <input type="hidden" name="range" id="rangeInput" value="{{ request('range') }}">
            <div class="grid gap-4 lg:grid-cols-2">
                <div class="grid gap-4 sm:grid-cols-2">
                    <div>
                        <label class="mb-1 block text-xs font-medium text-slate-500">Tanggal Mulai</label>
                        <input type="date" name="start" id="startDate"
                               value="{{ request('start') ?? $start ?? '' }}" class="input-field">
                    </div>
                    <div>
                        <label class="mb-1 block text-xs font-medium text-slate-500">Tanggal Selesai</label>
                        <input type="date" name="end" id="endDate"
                               value="{{ request('end') ?? $end ?? '' }}" class="input-field">
                    </div>
                </div>
                <div class="flex flex-wrap items-end gap-2">
                    <div class="flex flex-wrap gap-2">
                        <button type="button" data-range="today" class="preset-btn btn-secondary">Hari Ini</button>
                        <button type="button" data-range="week" class="preset-btn btn-secondary">Minggu Ini</button>
                        <button type="button" data-range="month" class="preset-btn btn-secondary">Bulan Ini</button>
                        <button type="button" data-range="year" class="preset-btn btn-secondary">Tahun Ini</button>
                    </div>
                    <button type="submit" class="btn-primary ml-auto"><i data-lucide="filter" class="h-4 w-4"></i> Terapkan</button>
                </div>
            </div>
            <div class="mt-3 flex flex-wrap items-center gap-3">
                <div class="flex flex-wrap gap-2">
                    <select name="status" class="input-field">
                        <option value="">Semua Status</option>
                        @foreach (['pending', 'verified', 'rejected'] as $s)
                            <option value="{{ $s }}" {{ request('status') == $s ? 'selected' : '' }}>{{ ucfirst($s) }}</option>
                        @endforeach
                    </select>
                    <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari kode booking..." class="input-field">
                </div>
            </div>
        </form>
    </div>

    @if ($start && $end)
        <p class="mt-3 text-sm text-slate-600">
            Menampilkan pembayaran periode <strong>{{ \Carbon\Carbon::parse($start)->format('d M Y') }}</strong> –
            <strong>{{ \Carbon\Carbon::parse($end)->format('d M Y') }}</strong> (berdasarkan tanggal mulai booking).
            <a href="{{ route('admin.payments.index') }}" class="text-navy-700 underline">Reset</a>
        </p>
    @endif

    <div class="card mt-4 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left text-sm">
                <thead class="bg-slate-50 text-xs uppercase tracking-wider text-slate-500">
                    <tr>
                        <th class="px-6 py-3">Booking</th>
                        <th class="px-6 py-3">Customer</th>
                        <th class="px-6 py-3">Mobil</th>
                        <th class="px-6 py-3">Metode</th>
                        <th class="px-6 py-3">Jumlah</th>
                        <th class="px-6 py-3">Status</th>
                        <th class="px-6 py-3 text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse ($payments as $payment)
                        <tr class="hover:bg-slate-50">
                            <td class="px-6 py-4 text-xs font-medium text-slate-500">{{ $payment->booking?->booking_code }}</td>
                            <td class="px-6 py-4 text-slate-800">{{ $payment->booking?->user?->name }}</td>
                            <td class="px-6 py-4 text-slate-600">{{ $payment->booking?->car?->brand }} {{ $payment->booking?->car?->model }}</td>
                            <td class="px-6 py-4 text-slate-600">{{ $payment->payment_type ?? '-' }}</td>
                            <td class="px-6 py-4 font-semibold text-slate-800">Rp{{ number_format($payment->amount, 0, ',', '.') }}</td>
                            <td class="px-6 py-4">
                                <span class="rounded-full px-2 py-0.5 text-xs font-medium
                                    {{ $payment->status === 'verified' ? 'bg-green-100 text-green-700' : ($payment->status === 'rejected' ? 'bg-red-100 text-red-700' : 'bg-yellow-100 text-yellow-700') }}">
                                    {{ $payment->status_label }}
                                </span>
                            </td>
                            <td class="px-6 py-4 text-right">
                                <a href="{{ route('admin.payments.show', $payment) }}" class="inline-flex items-center gap-1 rounded-lg bg-navy-100 px-3 py-1.5 text-xs font-medium text-navy-700 hover:bg-navy-200">
                                    <i data-lucide="eye" class="h-3.5 w-3.5"></i> Detail
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="px-6 py-12 text-center text-slate-500">Tidak ada pembayaran.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <div class="mt-4">{{ $payments->links() }}</div>
@endsection

@section('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function () {
        if (window.lucide) lucide.createIcons();

        const rangeInput = document.getElementById('rangeInput');
        const startDate = document.getElementById('startDate');
        const endDate = document.getElementById('endDate');

        document.querySelectorAll('.preset-btn').forEach(function (btn) {
            btn.addEventListener('click', function () {
                rangeInput.value = btn.dataset.range;
                startDate.value = '';
                endDate.value = '';
                document.getElementById('filterForm').submit();
            });
        });

        startDate.addEventListener('change', function () { rangeInput.value = ''; });
        endDate.addEventListener('change', function () { rangeInput.value = ''; });
    });
</script>
@endsection
