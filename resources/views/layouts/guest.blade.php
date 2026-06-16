@php use Illuminate\Support\Facades\Auth; @endphp
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
    <body class="relative font-sans antialiased bg-app">
        <x-loading-overlay
            page="true"
            message="Cargando aplicación..."
        />

        <livewire:layout.navigation-guest/>

        <div class="lg:min-h-screen lg:grid gap-4 lg:grid-rows-1 lg:grid-cols-2">
            <div class="relative w-full h-[300px] md:h-[500px] lg:h-full">
                <!-- Imagen fondo Movil -->
                <img src="{{ asset('images/Joven_movil.png') }}"
                     class="absolute inset-0 w-full h-full lg:hidden">

                <!-- Imagen fondo Escritorio -->
                <img src="{{ asset('images/Joven.png') }}"
                    class="absolute inset-0 w-full h-full hidden lg:block">

                <!-- Logo fijo -->
                <div class="absolute bottom-0 lg:bottom-16 left-1/2 -translate-x-1/2 z-50">
                    <img src="{{ asset('images/logo.png') }}"
                        class="block lg:hidden max-w-none w-[240px] md:w-[340px] lg:w-[480px] object-contain drop-shadow-[0_10px_30px_rgba(0,0,0,0.5)] z-50">
                </div>
            </div>
            <div class="relative flex flex-col @if (!request()->routeIs('register')) lg:flex-row @endif
                justify-center items-center py-5 px-5 md:px-0">
                @if (Auth::user())
                    @if (!request()->routeIs('participants.home'))
                        <div class="absolute top-20 left-7 lg:-left-10 z-50">
                            <a href="{{ route('participants.home') }}" class="cursor-pointer" wire:navigate>
                                <img src="{{ asset('images/arrow-left.png') }}" class="w-[20px]">
                            </a>
                        </div>
                    @endif
                @endif
                {{ $slot }}

                @hasSection('footer')
                    <div class="mt-8 @if (!request()->routeIs('register')) lg:mt-0 lg:absolute lg:bottom-5 md:px-5 @endif">
                        @yield('footer')
                    </div>
                @endif
            </div>
        </div>

        @stack('scripts')
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    </body>
</html>
