<x-guest-layout>
    <div class="flex flex-col w-auto">
        <div class="flex flex-col gap-3">
            <div class="flex justify-center">
                <img src="{{ asset('images/compra.png') }}"
                    class="w-[279px] md:w-[350px] 2xl:w-[467px]">
            </div>
            <div class="flex justify-center">
                <img src="{{ asset('images/registra_tu_compra.png') }}"
                    class="w-[279px] md:w-[350px] 2xl:w-[467px]">
            </div>
            <div class="flex justify-center">
                <img src="{{ asset('images/juega_y_gana.png') }}"
                     class="w-[279px] md:w-[350px] 2xl:w-[467px]">
            </div>
        </div>
        <div class="flex flex-col md:flex-row justify-center items-center gap-5 mt-2">
            <a href="{{ route('login') }}" class="w-[180px] 2xl:w-[250px] rounded-xl bg-yellow text-green-dark text-[30px] 2xl:text-[40px] text-center font-bold"
               wire:navigate>INICIAR SESIÓN</a>
            <a href="{{ route('register') }}" class="w-[180px] 2xl:w-[250px] rounded-xl bg-primary text-white text-[30px] 2xl:text-[40px] text-center font-bold"
               wire:navigate>REGISTRO</a>
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
</x-guest-layout>
