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

    <link rel="icon" href="{{ asset('images/spb.ico') }}"/>

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="relative font-sans antialiased bg-game">
    <x-loading-overlay
        page="true"
        message="Cargando aplicación..."
    />

    @if (!request()->routeIs('participants.game'))
        <livewire:layout.navigation-guest/>
    @endif

    <div class="min-h-screen flex justify-center items-center">
        <div ></div>
        <div class="relative flex justify-center items-center">
            <div class="absolute top-7 md:top-20 left-3 md:-left-10 z-50">
                <a href="{{ route('participants.home') }}" class="cursor-pointer" wire:navigate>
                    <img src="{{ asset('images/arrow-left.png') }}" class="w-[20px]">
                </a>
            </div>

            {{ $slot }}
        </div>
    </div>

    <a href="#" target="_blank" class="fixed bottom-5 right-5 rounded-full bg-[#25d366] p-3">
        <img src="{{ asset('images/whatsapp.svg') }}" class="w-[25px] h-[25px] "/>
    </a>

    @stack('scripts')
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</body>
</html>
