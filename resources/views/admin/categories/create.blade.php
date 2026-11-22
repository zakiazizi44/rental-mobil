@extends('layouts.admin')

@section('title', 'Tambah Kategori')

@section('content')
    <a href="{{ route('admin.categories.index') }}" class="inline-flex items-center gap-1 text-sm font-medium text-navy-700 hover:text-navy-800">
        <i data-lucide="arrow-left" class="h-4 w-4"></i> Kembali
    </a>

    <h1 class="mt-4 text-2xl font-bold text-slate-900">Tambah Kategori</h1>

    <div class="card mt-6 max-w-2xl p-6">
        <form method="POST" action="{{ route('admin.categories.store') }}">
            @csrf

            <div>
                <label class="block text-sm font-medium text-slate-700">Nama Kategori</label>
                <input type="text" name="name" value="{{ old('name') }}" class="input-field mt-1" placeholder="Contoh: City Car" required>
            </div>

            <div class="mt-4">
                <label class="block text-sm font-medium text-slate-700">Deskripsi</label>
                <textarea name="description" rows="4" class="input-field mt-1" placeholder="Deskripsi singkat kategori...">{{ old('description') }}</textarea>
            </div>

            <div class="mt-6 flex gap-3">
                <button type="submit" class="btn-primary">Simpan Kategori</button>
                <a href="{{ route('admin.categories.index') }}" class="btn-secondary">Batal</a>
            </div>
        </form>
    </div>
@endsection

@section('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function () { if (window.lucide) lucide.createIcons(); });
</script>
@endsection
