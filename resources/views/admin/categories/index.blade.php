@extends('layouts.admin')

@section('title', 'Kategori')

@section('content')
    <div class="flex items-center justify-between">
        <div>
            <h1 class="text-2xl font-bold text-slate-900">Kategori Mobil</h1>
            <p class="mt-1 text-slate-500">Kelola kategori mobil untuk katalog.</p>
        </div>
        <a href="{{ route('admin.categories.create') }}" class="btn-primary">
            <i data-lucide="plus" class="h-4 w-4"></i>
            Tambah Kategori
        </a>
    </div>

    <div class="card mt-6 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left text-sm">
                <thead class="bg-slate-50 text-xs uppercase tracking-wider text-slate-500">
                    <tr>
                        <th class="px-6 py-3">Nama</th>
                        <th class="px-6 py-3">Deskripsi</th>
                        <th class="px-6 py-3">Jumlah Mobil</th>
                        <th class="px-6 py-3 text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse ($categories as $category)
                        <tr class="hover:bg-slate-50">
                            <td class="px-6 py-4 font-semibold text-slate-800">{{ $category->name }}</td>
                            <td class="max-w-xs px-6 py-4 text-slate-600">{{ $category->description ?? '-' }}</td>
                            <td class="px-6 py-4"><span class="rounded-full bg-navy-100 px-2.5 py-0.5 text-xs font-medium text-navy-700">{{ $category->cars_count }}</span></td>
                            <td class="px-6 py-4">
                                <div class="flex justify-end gap-2">
                                    <a href="{{ route('admin.categories.edit', $category) }}" class="inline-flex items-center gap-1 rounded-lg bg-navy-100 px-3 py-1.5 text-xs font-medium text-navy-700 hover:bg-navy-200">
                                        <i data-lucide="pencil" class="h-3.5 w-3.5"></i> Edit
                                    </a>
                                    @if ($category->cars_count === 0)
                                        <form method="POST" action="{{ route('admin.categories.destroy', $category) }}"
                                            onsubmit="event.preventDefault(); confirmDelete(this, 'Kategori ini akan dihapus permanen.')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="inline-flex items-center gap-1 rounded-lg bg-red-100 px-3 py-1.5 text-xs font-medium text-red-700 hover:bg-red-200">
                                                <i data-lucide="trash-2" class="h-3.5 w-3.5"></i> Hapus
                                            </button>
                                        </form>
                                    @endif
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="px-6 py-12 text-center text-slate-500">Belum ada kategori.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
@endsection

@section('scripts')
<script>
    function confirmDelete(form, msg) {
        Swal.fire({
            title: 'Hapus data?',
            text: msg,
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
