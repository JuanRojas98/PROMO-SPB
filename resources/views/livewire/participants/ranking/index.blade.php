<div class="w-full px-5 md:px-0 lg:w-[700px] 2xl:w-[800px]">
    <p class="font-semibold text-[28px] md:text-[48px] text-center text-white mb-0">
        <span class="text-green-400">{{ number_format($currentUserPoints) }} PTS (Aprobados)</span>
        | <br class="md:hidden"/>
        <span class="text-yellow">{{ number_format($currentUserPointsPending) }} PTS (En validación)</span>
    </p>
    <h2 class="relative font-bold text-[48px] md:text-[70px] 2xl:text-[80px] text-center title-stroke tracking-wider mb-3">
        CLASIFICACIÓN:
        <span class="title-stroke-white">{{ $currentUserPosition }}</span>
    </h2>
    <p class="font-black text-[25px] md:text-[40px] text-center text-black mb-8 flex flex-col md:flex-row justify-center items-center">
        TERMINA EN
        <span class="block px-3 bg-yellow text-green-dark rounded-full md:ml-3">
            <span id="days">0</span> día(s)
            y
            <span id="hours">0</span> hora(s)
        </span>
    </p>

    <div class="w-full max-w-3xl bg-[#ECECEC] rounded-2xl shadow-lg p-6">
        <!-- Scroll -->
        <div class="max-h-[500px] overflow-y-auto pr-2">
            <div class="space-y-3">
                @foreach ($ranking as $key => $item)
                    <div class="flex items-center text-[#1D1D1D] font-extrabold uppercase italic">
                        <!-- Posición -->
                        <span class="w-8 text-[#0A6B4A] text-lg">
                            {{ $key+1 }}
                        </span>

                        <!-- Nombre -->
                        <span class="whitespace-nowrap text-lg">
                            {{ $item->first_name . ' ' . $item->last_name }}
                        </span>

                        <!-- Línea -->
                        <div class="flex-1 border-b border-dashed border-gray-500 mx-3 mt-3"></div>

                        <!-- Puntaje -->
                        <span class="whitespace-nowrap text-lg">
                            {{ number_format($item->total_points) }}
                        </span>

                        <!-- PTS -->
                        <span class="ml-3 text-lg">
                            PTS
                        </span>
                    </div>
                @endforeach
            </div>
        </div>
    </div>

    @section('footer')
        <p class="text-sm text-white text-center">

            "Lea la etiqueta antes de usar el producto", "Ningún envase o empaque que haya contenido plaguicidas puede
            usarse para contener alimentos o agua, para consumo humano y animal" y "Manténgase fuera del alcance de los
            niños, alejado de animales y alimento". "Este(os) producto(s) no puede(n) aplicarse sobre las personas,
            plantas ni animales, tampoco sobre los alimentos" y "Después de la aplicación debe esperar el tiempo recomendado
            en la etiqueta antes de ingresar al lugar".
            <br><br>

            Oferta válida del 15 de Junio de 2026 al 15 de Julio de 2026.<br>
            <a href="#" class="text-yellow underline">Consulta términos y condiciones</a> en activatupasion.com <br>
            © 2026 Rapid Repel & Black Flag. Todos los derechos reservados.
        </p>
    @endsection

    <script>
        document.addEventListener('DOMContentLoaded', () => {
            // Fecha inicial: 15 de junio
            const startDate = new Date('2026-06-15T00:00:00');
            // Fecha final: 15 de julio
            const endDate = new Date('2026-07-15T23:59:59');

            function updateCountdown() {
                const now = new Date();

                // Antes del inicio
                if (now < startDate) {
                    document.getElementById('days').textContent = '0';
                    document.getElementById('hours').textContent = '0';
                    return;
                }

                // Después de finalizar
                if (now > endDate) {
                    document.getElementById('days').textContent = '0';
                    document.getElementById('hours').textContent = '0';
                    return;
                }

                const diff = endDate - now;

                const days = Math.floor(diff / (1000 * 60 * 60 * 24));
                const hours = Math.floor((diff / (1000 * 60 * 60)) % 24);

                document.getElementById('days').textContent = days;
                document.getElementById('hours').textContent = hours
            }

            updateCountdown();
            setInterval(updateCountdown, 1000);
        });
    </script>
</div>
