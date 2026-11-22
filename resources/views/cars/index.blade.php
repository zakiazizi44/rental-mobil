@extends('layouts.customer')

@section('title', 'Daftar Mobil')

@section('content')
    <!-- Header -->
    <!-- <section class="bg-gradient-to-br from-navy-800 to-navy-900 py-12 text-white">
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
            <h1 class="text-3xl font-bold">Daftar Mobil</h1>
            <p class="mt-2 text-navy-100">Temukan mobil yang sesuai dengan kebutuhan Anda.</p>
        </div>
    </section> -->

    <section class="mx-auto max-w-7xl px-4 py-4 sm:px-6 lg:px-8">
        <!-- Filter & Search -->
        <div class="card p-4">
            <form method="GET" action="{{ route('cars.index') }}">
                <div class="relative w-full">
                    <label class="sr-only">Cari</label>
                    <i data-lucide="search" class="pointer-events-none absolute left-3 top-1/2 h-4 w-4 -translate-y-1/2 text-slate-400"></i>
                    <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari nama, merek, atau model mobil..."
                        class="input-field py-2 pl-10 pr-4">
                </div>

                <!-- Filter Kategori (pills) -->
                <div class="mt-3 flex flex-wrap items-center gap-2 border-t border-slate-100 pt-3">
                    <span class="mr-1 text-xs font-medium text-slate-500">Kategori</span>
                    <a href="{{ route('cars.index', array_merge(request()->except('category'), ['category' => ''])) }}"
                        class="rounded-full px-3 py-1 text-xs font-medium transition-colors focus:outline-none focus-visible:ring-2 focus-visible:ring-navy-500 focus-visible:ring-offset-2 {{ request('category') ? 'bg-navy-100 text-navy-700 hover:bg-navy-200' : 'bg-navy-700 text-white' }}">
                        Semua
                    </a>
                    @foreach ($categories as $category)
                        <a href="{{ route('cars.index', array_merge(request()->except('category'), ['category' => $category->id])) }}"
                            class="rounded-full px-3 py-1 text-xs font-medium transition-colors focus:outline-none focus-visible:ring-2 focus-visible:ring-navy-500 focus-visible:ring-offset-2 {{ request('category') == $category->id ? 'bg-navy-700 text-white' : 'bg-navy-100 text-navy-700 hover:bg-navy-200' }}">
                            {{ $category->name }}
                        </a>
                    @endforeach
                </div>
            </form>
        </div>

        <!-- Daftar Mobil -->
        <div class="mt-5 grid gap-4 sm:grid-cols-2 lg:grid-cols-3">
            @forelse ($cars as $car)
                <a href="{{ route('cars.show', $car) }}" class="group card overflow-hidden transition-shadow hover:shadow-md">
                    <div class="aspect-[16/10] overflow-hidden bg-slate-100">
                        <img src="{{ $car->image_url }}" alt="{{ $car->name }}" class="h-full w-full object-cover transition-transform duration-300 group-hover:scale-105">
                    </div>
                    <div class="p-5">
                        <div class="flex items-center justify-between">
                            <span class="text-xs font-medium uppercase tracking-wide text-navy-600">{{ $car->category?->name }}</span>
                            @if ($car->status === 'available')
                                <span class="rounded-full bg-green-100 px-2.5 py-0.5 text-xs font-medium text-green-700">{{ $car->status_label }}</span>
                            @elseif ($car->status === 'rented')
                                <span class="rounded-full bg-yellow-100 px-2.5 py-0.5 text-xs font-medium text-yellow-700">{{ $car->status_label }}</span>
                            @else
                                <span class="rounded-full bg-red-100 px-2.5 py-0.5 text-xs font-medium text-red-700">{{ $car->status_label }}</span>
                            @endif
                        </div>
                        <h3 class="mt-2 text-lg font-semibold text-slate-900">{{ $car->brand }} {{ $car->model }} <span class="text-sm font-normal text-slate-500">{{ $car->year }}</span></h3>
                        <div class="mt-3 flex flex-wrap gap-x-4 gap-y-1 text-xs text-slate-500">
                            <span class="inline-flex items-center gap-1"><i data-lucide="users" class="h-3.5 w-3.5"></i>{{ $car->capacity }} Kursi</span>
                            <span class="inline-flex items-center gap-1"><i data-lucide="settings" class="h-3.5 w-3.5"></i>{{ $car->transmission }}</span>
                            <span class="inline-flex items-center gap-1"><i data-lucide="fuel" class="h-3.5 w-3.5"></i>{{ $car->fuel_type }}</span>
                        </div>
                        <div class="mt-4 border-t border-slate-100 pt-4">
                            <span class="text-xs text-slate-500">Harga per hari</span>
                            <p class="text-xl font-bold text-navy-700">Rp{{ number_format($car->price_per_day, 0, ',', '.') }}</p>
                        </div>
                    </div>
                </a>
            @empty
                <div class="col-span-full py-10 text-center">
                    <i data-lucide="search-x" class="mx-auto h-12 w-12 text-slate-300"></i>
                    <p class="mt-4 text-slate-500">Tidak ada mobil yang sesuai dengan pencarian Anda.</p>
                </div>
            @endforelse
        </div>

        <!-- Pagination -->
        <div class="mt-6">
            {{ $cars->links() }}
        </div>
    </section>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            if (window.lucide) {
                lucide.createIcons();
            }
        });
    </script>
@endsection
