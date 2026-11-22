@extends('layouts.admin')

@section('title', 'Edit Mobil')

@section('content')
    <a href="{{ route('admin.cars.index') }}" class="inline-flex items-center gap-1 text-sm font-medium text-navy-700 hover:text-navy-800">
        <i data-lucide="arrow-left" class="h-4 w-4"></i> Kembali
    </a>

    <h1 class="mt-4 text-2xl font-bold text-slate-900">Edit Mobil</h1>

    <div class="card mt-6 max-w-3xl p-6">
        <form method="POST" action="{{ route('admin.cars.update', $car) }}" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <div class="grid gap-4 sm:grid-cols-2">
                <div class="sm:col-span-2">
                    <label class="block text-sm font-medium text-slate-700">Nama Mobil</label>
                    <input type="text" name="name" value="{{ old('name', $car->name) }}" class="input-field mt-1" required>
                </div>

                <div>
                    <label class="block text-sm font-medium text-slate-700">Merek</label>
                    <input type="text" name="brand" value="{{ old('brand', $car->brand) }}" class="input-field mt-1" required>
                </div>
                <div>
                    <label class="block text-sm font-medium text-slate-700">Model</label>
                    <input type="text" name="model" value="{{ old('model', $car->model) }}" class="input-field mt-1" required>
                </div>

                <div>
                    <label class="block text-sm font-medium text-slate-700">Kategori</label>
                    <select name="category_id" class="input-field mt-1" required>
                        @foreach ($categories as $category)
                            <option value="{{ $category->id }}" {{ old('category_id', $car->category_id) == $category->id ? 'selected' : '' }}>{{ $category->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label class="block text-sm font-medium text-slate-700">Tahun</label>
                    <input type="number" name="year" value="{{ old('year', $car->year) }}" min="1990" max="{{ date('Y') + 1 }}" class="input-field mt-1" required>
                </div>

                <div>
                    <label class="block text-sm font-medium text-slate-700">Plat Nomor</label>
                    <input type="text" name="license_plate" value="{{ old('license_plate', $car->license_plate) }}" class="input-field mt-1" required>
                </div>
                <div>
                    <label class="block text-sm font-medium text-slate-700">Harga per Hari (Rp)</label>
                    <input type="number" name="price_per_day" value="{{ old('price_per_day', $car->price_per_day) }}" min="0" class="input-field mt-1" required>
                </div>

                <div>
                    <label class="block text-sm font-medium text-slate-700">Kapasitas (kursi)</label>
                    <input type="number" name="capacity" value="{{ old('capacity', $car->capacity) }}" min="1" class="input-field mt-1" required>
                </div>
                <div>
                    <label class="block text-sm font-medium text-slate-700">Transmisi</label>
                    <select name="transmission" class="input-field mt-1" required>
                        @foreach (['Automatic', 'Manual', 'Automatic (CVT)'] as $t)
                            <option value="{{ $t }}" {{ old('transmission', $car->transmission) == $t ? 'selected' : '' }}>{{ $t }}</option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <label class="block text-sm font-medium text-slate-700">Bahan Bakar</label>
                    <select name="fuel_type" class="input-field mt-1" required>
                        @foreach (['Bensin', 'Diesel', 'Listrik'] as $f)
                            <option value="{{ $f }}" {{ old('fuel_type', $car->fuel_type) == $f ? 'selected' : '' }}>{{ $f }}</option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label class="block text-sm font-medium text-slate-700">Warna</label>
                    <input type="text" name="color" value="{{ old('color', $car->color) }}" class="input-field mt-1">
                </div>

                <div>
                    <label class="block text-sm font-medium text-slate-700">Status</label>
                    <select name="status" class="input-field mt-1" required>
                        @foreach (['available', 'rented', 'maintenance'] as $s)
                            <option value="{{ $s }}" {{ old('status', $car->status) == $s ? 'selected' : '' }}>
                                {{ match($s) { 'available' => 'Tersedia', 'rented' => 'Disewa', 'maintenance' => 'Maintenance' } }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="sm:col-span-2">
                    <label class="block text-sm font-medium text-slate-700">Gambar Mobil</label>
                    <div class="mt-1 flex items-center gap-4">
                        <img src="{{ $car->image_url }}" alt="{{ $car->name }}" class="h-16 w-24 rounded-lg object-cover">
                        <div class="flex-1">
                            <input type="file" name="image" accept="image/*" class="input-field">
                            <p class="mt-1 text-xs text-slate-500">Kosongkan jika tidak ingin mengubah gambar.</p>
                        </div>
                    </div>
                </div>

                <div class="sm:col-span-2">
                    <label class="block text-sm font-medium text-slate-700">Fasilitas</label>
                    <input type="text" name="facilities" value="{{ old('facilities', $car->facilities) }}" class="input-field mt-1" placeholder="Dipisah koma: AC, Bluetooth, USB">
                </div>

                <div class="sm:col-span-2">
                    <label class="block text-sm font-medium text-slate-700">Deskripsi</label>
                    <textarea name="description" rows="4" class="input-field mt-1">{{ old('description', $car->description) }}</textarea>
                </div>
            </div>

            <div class="mt-6 flex gap-3">
                <button type="submit" class="btn-primary">Perbarui Mobil</button>
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
