<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="h-full">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Dashboard') | Admin Rental Mobil</title>

    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600,700&display=swap" rel="stylesheet">

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <!-- Lucide Icons -->
    <script src="https://unpkg.com/lucide@latest"></script>
</head>
<body class="h-full">
    @if (session('success') || session('error'))
        <script>
            window.addEventListener('DOMContentLoaded', function () {
                Swal.fire({
                    icon: '{{ session('success') ? "success" : "error" }}',
                    title: '{{ session('success') ? "Berhasil" : "Informasi" }}',
                    text: '{{ session('success') ?? session('error') }}',
                    timer: 2500,
                    showConfirmButton: false,
                });
            });
        </script>
    @endif

    @if ($errors->any())
        <script>
            window.addEventListener('DOMContentLoaded', function () {
                let msg = '';
                @foreach ($errors->all() as $error)
                    msg += '{{ $error }}\n';
                @endforeach
                Swal.fire({ icon: 'error', title: 'Terjadi kesalahan', text: msg });
            });
        </script>
    @endif

    <div x-data="{ sidebarOpen: false }" class="flex min-h-screen">
        <!-- Sidebar -->
        @include('layouts.partials.admin-sidebar')

        <!-- Mobile overlay -->
        <div x-show="sidebarOpen" x-transition @click="sidebarOpen = false" class="fixed inset-0 z-30 bg-black/40 md:hidden"></div>

        <div class="flex w-full flex-col md:pl-64">
            <!-- Topbar -->
            @include('layouts.partials.admin-topbar')

            <main class="flex-1 p-4 sm:p-6 lg:p-8">
                @yield('content')
            </main>
        </div>
    </div>

    @yield('scripts')
</body>
</html>
