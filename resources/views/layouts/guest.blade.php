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

        <header class="absolute top-0 left-0 z-30 w-full py-2 px-5 lg:px-8 flex justify-between items-center">
            <div class="flex">
                @if (Auth::user())
                    <div class="w-[160px] lg:w-[230px] p-2 rounded-full border border-white flex justify-center gap-2">
                        <img src="{{ asset('images/usuario.png') }}" class="w-[25px] h-[25px]">
                        <span class="font-semibold text-white uppercase text-center text-xl 2xl:text-2xl">
                            {{ Auth::user()->first_name . ' ' . Auth::user()->last_name }}
                        </span>
                    </div>
                @endif
            </div>
            <div class="flex justify-between items-center gap-5">
                <img src="{{ asset('images/logo_black_flag.png') }}" class="w-[46px] lg:w-[80px] 2xl:w-[132px]">
                <img src="{{ asset('images/logo_rapid_repel.png') }}" class="w-[46px] lg:w-[80px] 2xl:w-[132px]">
            </div>
        </header>

        <div class="lg:min-h-screen lg:grid gap-4 lg:grid-rows-1 lg:grid-cols-2">
            <div class="relative w-full h-[300px] md:h-[500px] lg:h-full overflow-hidden">
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
                {{ $slot }}

                <div class="mt-8 @if (!request()->routeIs('register')) lg:mt-0 lg:absolute lg:bottom-5 md:px-5 @endif">
                    <p class="text-xs text-white">
                        "Lea la etiqueta antes de usar el producto", "Ningún envase o empaque que haya contenido plaguicidas puede
                        usarse para contener alimentos o agua, para consumo humano y animal" y "Manténgase fuera del alcance de los
                        niños, alejado de animales y alimento". "Este(os) producto(s) no puede(n) aplicarse sobre las personas,
                        plantas ni animales, tampoco sobre los alimentos" y "Después de la aplicación debe esperar el tiempo recomendado
                        en la etiqueta antes de ingresar al lugar"
                    </p>
                </div>
            </div>
        </div>

        @stack('scripts')
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    </body>
</html>
