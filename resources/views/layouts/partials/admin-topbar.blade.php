<header class="sticky top-0 z-20 flex h-16 items-center justify-between border-b border-slate-200 bg-white px-4 sm:px-6">
    <!-- Hamburger (mobile) -->
    <button @click="sidebarOpen = !sidebarOpen" class="rounded-lg p-2 text-slate-600 hover:bg-slate-100 md:hidden">
        <i data-lucide="menu" class="h-6 w-6"></i>
    </button>

    <div class="hidden md:flex md:items-center md:gap-2">
        <i data-lucide="shield-check" class="h-5 w-5 text-navy-700"></i>
        <span class="text-sm font-semibold text-slate-700">Halaman Admin</span>
    </div>

    <div class="flex items-center gap-3">
        <a href="{{ route('home') }}" class="rounded-lg p-2 text-slate-500 hover:bg-slate-100" title="Lihat website">
            <i data-lucide="external-link" class="h-5 w-5"></i>
        </a>
        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button type="submit" class="inline-flex items-center gap-2 rounded-lg bg-slate-100 px-3 py-2 text-sm font-medium text-slate-700 hover:bg-slate-200">
                <i data-lucide="log-out" class="h-4 w-4"></i>
                <span class="hidden sm:inline">Logout</span>
            </button>
        </form>
        <a href="{{ route('profile.edit') }}" class="flex h-9 w-9 items-center justify-center rounded-full bg-navy-700 text-white">
            <i data-lucide="user" class="h-5 w-5"></i>
        </a>
    </div>
</header>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        if (window.lucide) {
            lucide.createIcons();
        }
    });
</script>
