@extends('layouts.admin')

@section('title', 'Customer')

@section('content')
    <div>
        <h1 class="text-2xl font-bold text-slate-900">Data Customer</h1>
        <p class="mt-1 text-slate-500">Daftar seluruh customer yang terdaftar.</p>
    </div>

    <div class="card mt-6 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left text-sm">
                <thead class="bg-slate-50 text-xs uppercase tracking-wider text-slate-500">
                    <tr>
                        <th class="px-6 py-3">Nama</th>
                        <th class="px-6 py-3">Email</th>
                        <th class="px-6 py-3">No. HP</th>
                        <th class="px-6 py-3">Jumlah Booking</th>
                        <th class="px-6 py-3">Tergabung</th>
                        <th class="px-6 py-3 text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse ($customers as $customer)
                        <tr class="hover:bg-slate-50">
                            <td class="px-6 py-4">
                                <div class="flex items-center gap-3">
                                    <span class="flex h-9 w-9 items-center justify-center rounded-full bg-navy-700 text-white">
                                        <i data-lucide="user" class="h-4 w-4"></i>
                                    </span>
                                    <span class="font-semibold text-slate-800">{{ $customer->name }}</span>
                                </div>
                            </td>
                            <td class="px-6 py-4 text-slate-600">{{ $customer->email }}</td>
                            <td class="px-6 py-4 text-slate-600">{{ $customer->phone ?? '-' }}</td>
                            <td class="px-6 py-4"><span class="rounded-full bg-navy-100 px-2.5 py-0.5 text-xs font-medium text-navy-700">{{ $customer->bookings_count }}</span></td>
                            <td class="px-6 py-4 text-slate-600">{{ $customer->created_at->format('d M Y') }}</td>
                            <td class="px-6 py-4 text-right">
                                <a href="{{ route('admin.customers.show', $customer) }}" class="inline-flex items-center gap-1 rounded-lg bg-navy-100 px-3 py-1.5 text-xs font-medium text-navy-700 hover:bg-navy-200">
                                    <i data-lucide="eye" class="h-3.5 w-3.5"></i> Detail
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="px-6 py-12 text-center text-slate-500">Belum ada customer.</td>
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
