<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="relative font-sans antialiased bg-game">
    <x-loading-overlay
        page="true"
        message="Cargando aplicación..."
    />

    <header class="absolute top-0 left-0 z-30 w-full py-2 px-5 lg:px-8 flex justify-between items-center">
        <div class="flex">
            @if (Auth::user())
                <div class="w-[230px] p-2 rounded-full border border-white flex justify-center gap-2">
                    <img src="{{ asset('storage/images/usuario.png') }}" class="w-[25px] h-[25px]">
                    <span class="font-semibold text-white uppercase text-center text-xl 2xl:text-2xl">
                            {{ Auth::user()->first_name . ' ' . Auth::user()->last_name }}
                        </span>
                </div>
            @endif
        </div>
        <div class="flex justify-between items-center gap-5">
            <img src="{{ asset('storage/images/logo_black_flag.png') }}" class="w-[46px] lg:w-[80px] 2xl:w-[132px]">
            <img src="{{ asset('storage/images/logo_rapid_repel.png') }}" class="w-[46px] lg:w-[80px] 2xl:w-[132px]">
        </div>
    </header>

    <div class="min-h-screen flex justify-center items-center">
        <div ></div>
        <div class="relative flex justify-center items-center p-5 md:p-8">
            {{ $slot }}
        </div>
    </div>

    @stack('scripts')
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</body>
</html>
