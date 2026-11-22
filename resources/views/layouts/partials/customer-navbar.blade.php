<nav x-data="{ open: false, userOpen: false }" class="sticky top-0 z-40 border-b border-slate-200/70 bg-white/95 shadow-sm backdrop-blur">
    <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
        <div class="flex h-16 items-center justify-between">
            <!-- Logo -->
            <a href="{{ route('home') }}" class="flex shrink-0 items-center gap-2.5">
                <div class="flex h-10 w-10 items-center justify-center rounded-xl bg-gradient-to-br from-navy-600 to-navy-900 text-white shadow-md shadow-navy-900/20">
                    <i data-lucide="car" class="h-5 w-5"></i>
                </div>
                <span class="text-xl font-extrabold tracking-tight text-navy-800">Rental<span class="text-navy-500">Mobil</span></span>
            </a>

            <!-- Navbar desktop (tengah) -->
            <div class="hidden items-center gap-1 md:flex">
                <a href="{{ route('home') }}"
                   class="rounded-lg px-4 py-2 text-sm font-semibold transition {{ request()->routeIs('home') ? 'bg-navy-50 text-navy-800' : 'text-slate-600 hover:bg-slate-100 hover:text-navy-700' }}">
                    Beranda
                </a>
                <a href="{{ route('cars.index') }}"
                   class="rounded-lg px-4 py-2 text-sm font-semibold transition {{ request()->routeIs('cars.*') ? 'bg-navy-50 text-navy-800' : 'text-slate-600 hover:bg-slate-100 hover:text-navy-700' }}">
                    Daftar Mobil
                </a>
                <a href="{{ route('home') . '#layanan' }}"
                   class="rounded-lg px-4 py-2 text-sm font-semibold text-slate-600 transition hover:bg-slate-100 hover:text-navy-700">
                    Layanan
                </a>
            </div>

            <!-- Auth actions desktop (kanan) -->
            <div class="hidden items-center gap-3 md:flex">
                @auth
                    <div class="relative">
                        <button @click="userOpen = !userOpen" class="flex items-center gap-2.5 rounded-full border border-slate-200 bg-white py-1.5 pl-1.5 pr-3.5 text-sm font-semibold text-slate-700 shadow-sm transition hover:border-navy-200 hover:bg-navy-50/50">
                            <span class="flex h-8 w-8 items-center justify-center rounded-full bg-gradient-to-br from-navy-600 to-navy-800 text-white">
                                {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                            </span>
                            <span class="max-w-[120px] truncate">{{ auth()->user()->name }}</span>
                            <i data-lucide="chevron-down" class="h-4 w-4 text-slate-400"></i>
                        </button>

                        <div x-show="userOpen" @click.away="userOpen = false" x-transition
                             class="absolute right-0 z-50 mt-2 w-56 rounded-2xl border border-slate-100 bg-white p-1.5 shadow-xl shadow-navy-900/10">
                            <a href="{{ auth()->user()->isAdmin() ? route('admin.dashboard') : route('customer.dashboard') }}" class="flex items-center gap-2.5 rounded-xl px-3 py-2.5 text-sm font-medium text-slate-700 transition hover:bg-slate-50">
                                <i data-lucide="layout-dashboard" class="h-4 w-4 text-navy-500"></i> Dashboard
                            </a>
                            @unless (auth()->user()->isAdmin())
                                <a href="{{ route('customer.bookings.index') }}" class="flex items-center gap-2.5 rounded-xl px-3 py-2.5 text-sm font-medium text-slate-700 transition hover:bg-slate-50">
                                    <i data-lucide="calendar-check" class="h-4 w-4 text-navy-500"></i> Riwayat Booking
                                </a>
                            @endunless
                            <a href="{{ route('profile.edit') }}" class="flex items-center gap-2.5 rounded-xl px-3 py-2.5 text-sm font-medium text-slate-700 transition hover:bg-slate-50">
                                <i data-lucide="settings" class="h-4 w-4 text-navy-500"></i> Profil
                            </a>
                            <div class="my-1 border-t border-slate-100"></div>
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button type="submit" class="flex w-full items-center gap-2.5 rounded-xl px-3 py-2.5 text-sm font-medium text-red-600 transition hover:bg-red-50">
                                    <i data-lucide="log-out" class="h-4 w-4"></i> Logout
                                </button>
                            </form>
                        </div>
                    </div>
                @else
                    <a href="{{ route('login') }}" class="rounded-lg px-3 py-2 text-sm font-semibold text-slate-600 transition hover:text-navy-700">Masuk</a>
                    <a href="{{ route('register') }}" class="btn-primary rounded-xl px-5 py-2.5">Daftar</a>
                @endauth
            </div>

            <!-- Mobile menu button -->
            <button @click="open = !open" class="rounded-lg p-2 text-slate-600 transition hover:bg-slate-100 md:hidden" aria-label="Menu">
                <i data-lucide="menu" class="h-6 w-6"></i>
            </button>
        </div>
    </div>

    <!-- Mobile menu -->
    <div x-show="open" @click.away="open = false" x-transition class="border-t border-slate-100 bg-white p-3 md:hidden">
        <div class="flex flex-col gap-1">
            <a href="{{ route('home') }}" class="rounded-lg px-3 py-2.5 text-sm font-semibold text-slate-700 transition hover:bg-slate-50">Beranda</a>
            <a href="{{ route('cars.index') }}" class="rounded-lg px-3 py-2.5 text-sm font-semibold text-slate-700 transition hover:bg-slate-50">Daftar Mobil</a>
            <a href="{{ route('home') . '#layanan' }}" class="rounded-lg px-3 py-2.5 text-sm font-semibold text-slate-700 transition hover:bg-slate-50">Layanan</a>

            <div class="my-1 border-t border-slate-100"></div>

            @auth
                <a href="{{ auth()->user()->isAdmin() ? route('admin.dashboard') : route('customer.dashboard') }}" class="rounded-lg px-3 py-2.5 text-sm font-semibold text-slate-700 transition hover:bg-slate-50">Dashboard</a>
                @unless (auth()->user()->isAdmin())
                    <a href="{{ route('customer.bookings.index') }}" class="rounded-lg px-3 py-2.5 text-sm font-semibold text-slate-700 transition hover:bg-slate-50">Riwayat Booking</a>
                @endunless
                <a href="{{ route('profile.edit') }}" class="rounded-lg px-3 py-2.5 text-sm font-semibold text-slate-700 transition hover:bg-slate-50">Profil</a>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="w-full rounded-lg px-3 py-2.5 text-left text-sm font-semibold text-red-600 transition hover:bg-red-50">Logout</button>
                </form>
            @else
                <a href="{{ route('login') }}" class="rounded-lg px-3 py-2.5 text-sm font-semibold text-slate-700 transition hover:bg-slate-50">Masuk</a>
                <a href="{{ route('register') }}" class="btn-primary mt-1">Daftar</a>
            @endauth
        </div>
    </div>
</nav>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        if (window.lucide) {
            lucide.createIcons();
        }
    });
</script>