<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="h-full">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Rental Mobil') | Rental Mobil</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600,700&display=swap" rel="stylesheet">

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <!-- Lucide Icons -->
    <script src="https://unpkg.com/lucide@latest"></script>
</head>
<body class="h-full">
    <!-- Flash message via SweetAlert2 -->
    @if (session('success') || session('error'))
        <script>
            window.addEventListener('DOMContentLoaded', function () {
                Swal.fire({
                    icon: '{{ session('success') ? "success" : "error" }}',
                    title: '{{ session('success') ? "Berhasil" : "Informasi" }}',
                    text: '{{ session('success') ?? session('error') }}',
                    timer: 3000,
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

    <div class="min-h-screen flex flex-col">
        @include('layouts.partials.customer-navbar')

        <main class="flex-1">
            @yield('content')
        </main>

        @include('layouts.partials.customer-footer')
    </div>
</body>
</html>
