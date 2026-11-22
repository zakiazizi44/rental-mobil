@extends('layouts.admin')

@section('title', 'Tambah Mobil')

@section('content')
    <a href="{{ route('admin.cars.index') }}" class="inline-flex items-center gap-1 text-sm font-medium text-navy-700 hover:text-navy-800">
        <i data-lucide="arrow-left" class="h-4 w-4"></i> Kembali
    </a>

    <h1 class="mt-4 text-2xl font-bold text-slate-900">Tambah Mobil</h1>

    <div class="card mt-6 max-w-3xl p-6">
        <form method="POST" action="{{ route('admin.cars.store') }}" enctype="multipart/form-data">
            @csrf

            <div class="grid gap-4 sm:grid-cols-2">
                <div class="sm:col-span-2">
                    <label class="block text-sm font-medium text-slate-700">Nama Mobil</label>
                    <input type="text" name="name" value="{{ old('name') }}" class="input-field mt-1" placeholder="Contoh: Toyota Avanza 1.5L" required>
                </div>

                <div>
                    <label class="block text-sm font-medium text-slate-700">Merek</label>
                    <input type="text" name="brand" value="{{ old('brand') }}" class="input-field mt-1" required>
                </div>
                <div>
                    <label class="block text-sm font-medium text-slate-700">Model</label>
                    <input type="text" name="model" value="{{ old('model') }}" class="input-field mt-1" required>
                </div>

                <div>
                    <label class="block text-sm font-medium text-slate-700">Kategori</label>
                    <select name="category_id" class="input-field mt-1" required>
                        <option value="">-- Pilih Kategori --</option>
                        @foreach ($categories as $category)
                            <option value="{{ $category->id }}" {{ old('category_id') == $category->id ? 'selected' : '' }}>{{ $category->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label class="block text-sm font-medium text-slate-700">Tahun</label>
                    <input type="number" name="year" value="{{ old('year', date('Y')) }}" min="1990" max="{{ date('Y') + 1 }}" class="input-field mt-1" required>
                </div>

                <div>
                    <label class="block text-sm font-medium text-slate-700">Plat Nomor</label>
                    <input type="text" name="license_plate" value="{{ old('license_plate') }}" class="input-field mt-1" placeholder="Contoh: B 1234 XYZ" required>
                </div>
                <div>
                    <label class="block text-sm font-medium text-slate-700">Harga per Hari (Rp)</label>
                    <input type="number" name="price_per_day" value="{{ old('price_per_day') }}" min="0" class="input-field mt-1" required>
                </div>

                <div>
                    <label class="block text-sm font-medium text-slate-700">Kapasitas (kursi)</label>
                    <input type="number" name="capacity" value="{{ old('capacity') }}" min="1" class="input-field mt-1" required>
                </div>
                <div>
                    <label class="block text-sm font-medium text-slate-700">Transmisi</label>
                    <select name="transmission" class="input-field mt-1" required>
                        <option value="Automatic" {{ old('transmission') == 'Automatic' ? 'selected' : '' }}>Automatic</option>
                        <option value="Manual" {{ old('transmission') == 'Manual' ? 'selected' : '' }}>Manual</option>
                        <option value="Automatic (CVT)" {{ old('transmission') == 'Automatic (CVT)' ? 'selected' : '' }}>Automatic (CVT)</option>
                    </select>
                </div>

                <div>
                    <label class="block text-sm font-medium text-slate-700">Bahan Bakar</label>
                    <select name="fuel_type" class="input-field mt-1" required>
                        <option value="Bensin" {{ old('fuel_type') == 'Bensin' ? 'selected' : '' }}>Bensin</option>
                        <option value="Diesel" {{ old('fuel_type') == 'Diesel' ? 'selected' : '' }}>Diesel</option>
                        <option value="Listrik" {{ old('fuel_type') == 'Listrik' ? 'selected' : '' }}>Listrik</option>
                    </select>
                </div>
                <div>
                    <label class="block text-sm font-medium text-slate-700">Warna</label>
                    <input type="text" name="color" value="{{ old('color') }}" class="input-field mt-1">
                </div>

                <div>
                    <label class="block text-sm font-medium text-slate-700">Status</label>
                    <select name="status" class="input-field mt-1" required>
                        <option value="available" {{ old('status') == 'available' ? 'selected' : '' }}>Tersedia</option>
                        <option value="rented" {{ old('status') == 'rented' ? 'selected' : '' }}>Disewa</option>
                        <option value="maintenance" {{ old('status') == 'maintenance' ? 'selected' : '' }}>Maintenance</option>
                    </select>
                </div>
                <div>
                    <label class="block text-sm font-medium text-slate-700">Gambar Mobil</label>
                    <input type="file" name="image" accept="image/*" class="input-field mt-1">
                    <p class="mt-1 text-xs text-slate-500">JPG, PNG, WEBP. Maks 2MB. Kosongkan untuk placeholder.</p>
                </div>

                <div class="sm:col-span-2">
                    <label class="block text-sm font-medium text-slate-700">Fasilitas</label>
                    <input type="text" name="facilities" value="{{ old('facilities') }}" class="input-field mt-1" placeholder="Dipisah koma: AC, Bluetooth, USB, Airbag">
                </div>

                <div class="sm:col-span-2">
                    <label class="block text-sm font-medium text-slate-700">Deskripsi</label>
                    <textarea name="description" rows="4" class="input-field mt-1">{{ old('description') }}</textarea>
                </div>
            </div>

            <div class="mt-6 flex gap-3">
                <button type="submit" class="btn-primary">Simpan Mobil</button>
                <a href="{{ route('admin.cars.index') }}" class="btn-secondary">Batal</a>
            </div>
        </form>
    </div>
@endsection

@section('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function () { if (window.lucide) lucide.createIcons(); });
</script>
@endsection
