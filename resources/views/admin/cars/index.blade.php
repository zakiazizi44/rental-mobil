@extends('layouts.admin')

@section('title', 'Mobil')

@section('content')
    <div class="flex items-center justify-between">
        <div>
            <h1 class="text-2xl font-bold text-slate-900">Mobil</h1>
            <p class="mt-1 text-slate-500">Kelola daftar mobil yang tersedia untuk disewa.</p>
        </div>
        <a href="{{ route('admin.cars.create') }}" class="btn-primary">
            <i data-lucide="plus" class="h-4 w-4"></i>
            Tambah Mobil
        </a>
    </div>

    <div class="card mt-6 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left text-sm">
                <thead class="bg-slate-50 text-xs uppercase tracking-wider text-slate-500">
                    <tr>
                        <th class="px-6 py-3">Mobil</th>
                        <th class="px-6 py-3">Kategori</th>
                        <th class="px-6 py-3">Plat</th>
                        <th class="px-6 py-3">Harga/Hari</th>
                        <th class="px-6 py-3">Kapasitas</th>
                        <th class="px-6 py-3">Status</th>
                        <th class="px-6 py-3 text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse ($cars as $car)
                        <tr class="hover:bg-slate-50">
                            <td class="px-6 py-4">
                                <div class="flex items-center gap-3">
                                    <img src="{{ $car->image_url }}" alt="{{ $car->name }}" class="h-11 w-16 rounded-lg object-cover">
                                    <div>
                                        <p class="font-semibold text-slate-800">{{ $car->brand }} {{ $car->model }}</p>
                                        <p class="text-xs text-slate-500">{{ $car->name }} • {{ $car->year }}</p>
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-4 text-slate-600">{{ $car->category?->name }}</td>
                            <td class="px-6 py-4 text-slate-600">{{ $car->license_plate }}</td>
                            <td class="px-6 py-4 font-semibold text-slate-800">Rp{{ number_format($car->price_per_day, 0, ',', '.') }}</td>
                            <td class="px-6 py-4 text-slate-600">{{ $car->capacity }} kursi</td>
                            <td class="px-6 py-4">
                                @if ($car->status === 'available')
                                    <span class="rounded-full bg-green-100 px-2.5 py-0.5 text-xs font-medium text-green-700">{{ $car->status_label }}</span>
                                @elseif ($car->status === 'rented')
                                    <span class="rounded-full bg-yellow-100 px-2.5 py-0.5 text-xs font-medium text-yellow-700">{{ $car->status_label }}</span>
                                @else
                                    <span class="rounded-full bg-red-100 px-2.5 py-0.5 text-xs font-medium text-red-700">{{ $car->status_label }}</span>
                                @endif
                            </td>
                            <td class="px-6 py-4">
                                <div class="flex justify-end gap-2">
                                    <a href="{{ route('admin.cars.edit', $car) }}" class="inline-flex items-center gap-1 rounded-lg bg-navy-100 px-3 py-1.5 text-xs font-medium text-navy-700 hover:bg-navy-200">
                                        <i data-lucide="pencil" class="h-3.5 w-3.5"></i> Edit
                                    </a>
                                    <form method="POST" action="{{ route('admin.cars.destroy', $car) }}"
                                        onsubmit="event.preventDefault(); confirmDelete(this)">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="inline-flex items-center gap-1 rounded-lg bg-red-100 px-3 py-1.5 text-xs font-medium text-red-700 hover:bg-red-200">
                                            <i data-lucide="trash-2" class="h-3.5 w-3.5"></i> Hapus
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="px-6 py-12 text-center text-slate-500">Belum ada mobil.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
@endsection

@section('scripts')
<script>
    function confirmDelete(form) {
        Swal.fire({
            title: 'Hapus mobil?',
            text: 'Mobil beserta gambar dan data terkait akan dihapus permanen.',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#dc2626',
            cancelButtonColor: '#6b7280',
            confirmButtonText: 'Ya, hapus',
            cancelButtonText: 'Batal'
        }).then((result) => {
            if (result.isConfirmed) {
                form.submit();
            }
        });
    }
</script>
@endsection
