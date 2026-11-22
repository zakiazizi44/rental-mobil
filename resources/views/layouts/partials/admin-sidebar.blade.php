<aside class="fixed inset-y-0 left-0 z-40 flex w-64 -translate-x-full flex-col bg-navy-900 text-slate-300 transition-transform md:translate-x-0" :class="sidebarOpen ? 'translate-x-0' : ''">
    <!-- Logo -->
    <div class="flex h-16 items-center gap-2 border-b border-navy-800 px-6">
        <div class="flex h-9 w-9 items-center justify-center rounded-lg bg-gradient-to-br from-navy-500 to-navy-700 text-white">
            <i data-lucide="car" class="h-5 w-5"></i>
        </div>
        <div>
            <p class="text-sm font-bold text-white">Rental Mobil</p>
            <p class="text-xs text-navy-300">Admin Panel</p>
        </div>
    </div>

    <!-- Menu -->
    <nav class="flex-1 space-y-1 overflow-y-auto p-4">
        <a href="{{ route('admin.dashboard') }}" class="group flex items-center gap-3 rounded-lg px-3 py-2.5 text-sm font-medium transition-colors {{ request()->routeIs('admin.dashboard') ? 'bg-navy-700 text-white' : 'text-slate-300 hover:bg-navy-800 hover:text-white' }}">
            <i data-lucide="layout-dashboard" class="h-5 w-5"></i>
            Dashboard
        </a>

        <p class="px-3 pt-4 text-xs font-semibold uppercase tracking-wider text-navy-400">Manajemen</p>

        <a href="{{ route('admin.cars.index') }}" class="group flex items-center gap-3 rounded-lg px-3 py-2.5 text-sm font-medium transition-colors {{ request()->routeIs('admin.cars.*') ? 'bg-navy-700 text-white' : 'text-slate-300 hover:bg-navy-800 hover:text-white' }}">
            <i data-lucide="car-front" class="h-5 w-5"></i>
            Mobil
        </a>

        <a href="{{ route('admin.categories.index') }}" class="group flex items-center gap-3 rounded-lg px-3 py-2.5 text-sm font-medium transition-colors {{ request()->routeIs('admin.categories.*') ? 'bg-navy-700 text-white' : 'text-slate-300 hover:bg-navy-800 hover:text-white' }}">
            <i data-lucide="tags" class="h-5 w-5"></i>
            Kategori
        </a>

        <a href="{{ route('admin.customers.index') }}" class="group flex items-center gap-3 rounded-lg px-3 py-2.5 text-sm font-medium transition-colors {{ request()->routeIs('admin.customers.*') ? 'bg-navy-700 text-white' : 'text-slate-300 hover:bg-navy-800 hover:text-white' }}">
            <i data-lucide="users" class="h-5 w-5"></i>
            Customer
        </a>

        <p class="px-3 pt-4 text-xs font-semibold uppercase tracking-wider text-navy-400">Transaksi</p>

        <a href="{{ route('admin.bookings.index') }}" class="group flex items-center gap-3 rounded-lg px-3 py-2.5 text-sm font-medium transition-colors {{ request()->routeIs('admin.bookings.*') ? 'bg-navy-700 text-white' : 'text-slate-300 hover:bg-navy-800 hover:text-white' }}">
            <i data-lucide="calendar-check" class="h-5 w-5"></i>
            Booking
        </a>

        <a href="{{ route('admin.payments.index') }}" class="group flex items-center gap-3 rounded-lg px-3 py-2.5 text-sm font-medium transition-colors {{ request()->routeIs('admin.payments.*') ? 'bg-navy-700 text-white' : 'text-slate-300 hover:bg-navy-800 hover:text-white' }}">
            <i data-lucide="credit-card" class="h-5 w-5"></i>
            Verifikasi Pembayaran
        </a>
    </nav>

    <!-- Footer -->
    <div class="border-t border-navy-800 p-4">
        <a href="{{ route('home') }}" class="flex items-center gap-3 rounded-lg px-3 py-2 text-sm text-slate-300 hover:bg-navy-800 hover:text-white">
            <i data-lucide="globe" class="h-5 w-5"></i>
            Lihat Website
        </a>
    </div>
</aside>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        if (window.lucide) {
            lucide.createIcons();
        }
    });
</script>
