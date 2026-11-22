<footer class="bg-navy-950 text-slate-300">
    <div class="mx-auto max-w-7xl px-4 py-14 sm:px-6 lg:px-8">
        <div class="grid gap-10 md:grid-cols-2 lg:grid-cols-4">
            <!-- Brand -->
            <div>
                <a href="{{ route('home') }}" class="flex items-center gap-2.5">
                    <div class="flex h-10 w-10 items-center justify-center rounded-xl bg-gradient-to-br from-navy-600 to-navy-800 text-white">
                        <i data-lucide="car" class="h-5 w-5"></i>
                    </div>
                    <span class="text-xl font-extrabold tracking-tight text-white">Rental<span class="text-navy-300">Mobil</span></span>
                </a>
                <p class="mt-4 max-w-xs text-sm leading-relaxed text-slate-400">
                    Penyedia layanan sewa mobil modern dengan armada berkualitas,
                    harga transparan, dan proses booking online yang mudah.
                </p>
            </div>

            <!-- Navigasi -->
            <div>
                <h4 class="text-sm font-bold uppercase tracking-wider text-white">Navigasi</h4>
                <ul class="mt-5 space-y-3 text-sm">
                    <li><a href="{{ route('home') }}" class="inline-flex items-center gap-2 text-slate-400 transition hover:text-white"><i data-lucide="chevron-right" class="h-3.5 w-3.5"></i> Beranda</a></li>
                    <li><a href="{{ route('cars.index') }}" class="inline-flex items-center gap-2 text-slate-400 transition hover:text-white"><i data-lucide="chevron-right" class="h-3.5 w-3.5"></i> Daftar Mobil</a></li>
                    <li><a href="{{ route('dashboard') }}" class="inline-flex items-center gap-2 text-slate-400 transition hover:text-white"><i data-lucide="chevron-right" class="h-3.5 w-3.5"></i> Dashboard</a></li>
                </ul>
            </div>

            <!-- Layanan -->
            <div>
                <h4 class="text-sm font-bold uppercase tracking-wider text-white">Layanan</h4>
                <ul class="mt-5 space-y-3 text-sm">
                    <li><a href="{{ route('cars.index') }}" class="inline-flex items-center gap-2 text-slate-400 transition hover:text-white"><i data-lucide="chevron-right" class="h-3.5 w-3.5"></i> Rental Mobil</a></li>
                    <li><a href="{{ route('home') . '#cara-booking' }}" class="inline-flex items-center gap-2 text-slate-400 transition hover:text-white"><i data-lucide="chevron-right" class="h-3.5 w-3.5"></i> Booking Online</a></li>
                    <li><a href="{{ route('home') . '#cara-booking' }}" class="inline-flex items-center gap-2 text-slate-400 transition hover:text-white"><i data-lucide="chevron-right" class="h-3.5 w-3.5"></i> Pembayaran</a></li>
                </ul>
            </div>

            <!-- Kontak -->
            <div>
                <h4 class="text-sm font-bold uppercase tracking-wider text-white">Kontak</h4>
                <ul class="mt-5 space-y-3 text-sm">
                    <li class="flex items-center gap-2.5 text-slate-400">
                        <i data-lucide="mail" class="h-4 w-4 shrink-0 text-navy-300"></i> halo@rentalmobil.com
                    </li>
                    <li class="flex items-center gap-2.5 text-slate-400">
                        <i data-lucide="phone" class="h-4 w-4 shrink-0 text-navy-300"></i> +62 812-3456-7890
                    </li>
                    <li class="flex items-start gap-2.5 text-slate-400">
                        <i data-lucide="map-pin" class="mt-0.5 h-4 w-4 shrink-0 text-navy-300"></i> Jl. Merdeka No. 10, Jakarta
                    </li>
                </ul>
            </div>
        </div>

        <div class="mt-12 flex flex-col items-center justify-between gap-3 border-t border-navy-800 pt-6 text-xs text-slate-500 sm:flex-row">
            <p>&copy; {{ date('Y') }} RentalMobil. All rights reserved.</p>
            <p>Sistem Booking Rental Mobil &middot; Proyek Akhir / Ujikom</p>
        </div>
    </div>
</footer>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        if (window.lucide) {
            lucide.createIcons();
        }
    });
</script>