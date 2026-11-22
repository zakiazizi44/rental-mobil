@extends('layouts.customer')

@section('title', 'Booking ' . $car->name)

@section('content')
    <section class="mx-auto max-w-5xl px-4 py-10 sm:px-6 lg:px-8">
        <a href="{{ route('cars.show', $car) }}" class="inline-flex items-center gap-1 text-sm font-medium text-navy-700 hover:text-navy-800">
            <i data-lucide="arrow-left" class="h-4 w-4"></i> Kembali ke detail mobil
        </a>

        <h1 class="mt-4 text-3xl font-bold text-slate-900">Booking Mobil</h1>

        <div class="mt-8 grid gap-8 lg:grid-cols-3">
            <!-- Form booking -->
            <div class="lg:col-span-2">
                <form method="POST" action="{{ route('customer.bookings.store', $car) }}" class="card p-6">
                    @csrf

                    <div class="flex items-center gap-4">
                        <img src="{{ $car->image_url }}" alt="{{ $car->name }}" class="h-16 w-24 rounded-lg object-cover">
                        <div>
                            <h2 class="font-semibold text-slate-900">{{ $car->brand }} {{ $car->model }}</h2>
                            <p class="text-sm text-slate-500">{{ $car->name }} • {{ $car->year }}</p>
                        </div>
                    </div>

                    <div class="mt-6 grid gap-4 sm:grid-cols-2">
                        <div>
                            <label class="block text-sm font-medium text-slate-700">Tanggal Mulai</label>
                            <input type="date" name="start_date" id="start_date" value="{{ old('start_date') }}" min="{{ date('Y-m-d') }}"
                                class="input-field mt-1" required>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-slate-700">Tanggal Selesai</label>
                            <input type="date" name="end_date" id="end_date" value="{{ old('end_date') }}" min="{{ date('Y-m-d') }}"
                                class="input-field mt-1" required>
                        </div>
                    </div>

                    <div class="mt-4">
                        <label class="block text-sm font-medium text-slate-700">No. HP</label>
                        <input type="tel" name="phone" value="{{ old('phone', auth()->user()->phone) }}" placeholder="08xxxxxxxxxx"
                            class="input-field mt-1" required>
                    </div>

                    <div class="mt-4">
                        <label class="block text-sm font-medium text-slate-700">Catatan (opsional)</label>
                        <textarea name="notes" rows="3" class="input-field mt-1" placeholder="Contoh: butuh kursi bayi, antar ke alamat tertentu...">{{ old('notes') }}</textarea>
                    </div>

                    <div class="mt-6">
                        <button type="submit" id="submitBtn" class="btn-primary w-full py-3 text-base">
                            <i data-lucide="check-circle" class="h-5 w-5"></i>
                            Konfirmasi Booking
                        </button>
                    </div>
                </form>
            </div>

            <!-- Ringkasan -->
            <div class="card h-fit p-6">
                <h3 class="text-lg font-semibold text-slate-900">Ringkasan Sewa</h3>
                <dl class="mt-4 space-y-3 text-sm">
                    <div class="flex justify-between">
                        <dt class="text-slate-500">Harga per hari</dt>
                        <dd class="font-semibold">Rp{{ number_format($car->price_per_day, 0, ',', '.') }}</dd>
                    </div>
                    <div class="flex justify-between">
                        <dt class="text-slate-500">Jumlah hari</dt>
                        <dd class="font-semibold"><span id="totalDays">0</span> hari</dd>
                    </div>
                    <div class="flex justify-between border-t border-slate-200 pt-3">
                        <dt class="font-medium text-slate-900">Total Harga</dt>
                        <dd class="text-xl font-bold text-navy-700" id="totalPrice">Rp0</dd>
                    </div>
                </dl>
                <p class="mt-4 rounded-lg bg-navy-50 p-3 text-xs text-navy-700">
                    Total harga dihitung ulang pada sistem. Pastikan tanggal sewa sudah benar.
                </p>
            </div>
        </div>
    </section>

    <script>
        const pricePerDay = {{ (int) round((float) $car->price_per_day) }};

        function calculate() {
            const start = document.getElementById('start_date').value;
            const end = document.getElementById('end_date').value;

            if (start && end) {
                const startDate = new Date(start);
                const endDate = new Date(end);
                const diff = Math.round((endDate - startDate) / (1000 * 60 * 60 * 24)) + 1;

                if (diff > 0) {
                    document.getElementById('totalDays').textContent = diff;
                    document.getElementById('totalPrice').textContent = 'Rp' + (pricePerDay * diff).toLocaleString('id-ID');
                }
            }
        }

        document.getElementById('start_date').addEventListener('change', calculate);
        document.getElementById('end_date').addEventListener('change', calculate);
    </script>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            if (window.lucide) {
                lucide.createIcons();
            }
        });
    </script>
@endsection
