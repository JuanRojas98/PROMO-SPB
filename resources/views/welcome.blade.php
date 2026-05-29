<x-guest-layout>
    <div class="flex flex-col w-auto">
        <div class="flex flex-col gap-3">
            <div class="flex justify-center">
                <img src="{{ asset('storage/images/compra.png') }}"
                    class="w-[279px] md:w-[350px] 2xl:w-[467px]">
            </div>
            <div class="flex justify-center">
                <img src="{{ asset('storage/images/registra_tu_compra.png') }}"
                    class="w-[279px] md:w-[350px] 2xl:w-[467px]">
            </div>
            <div class="flex justify-center">
                <img src="{{ asset('storage/images/juega_y_gana.png') }}"
                     class="w-[279px] md:w-[350px] 2xl:w-[467px]">
            </div>
        </div>
        <div class="flex justify-center items-center gap-5 mt-2">
            <a href="{{ route('login') }}" class="w-[180px] 2xl:w-[250px] rounded-xl bg-yellow text-green-dark text-[30px] 2xl:text-[40px] text-center font-bold"
               wire:navigate>INICIAR SESIÓN</a>
            <a href="{{ route('register') }}" class="w-[180px] 2xl:w-[250px] rounded-xl bg-primary text-white text-[30px] 2xl:text-[40px] text-center font-bold"
               wire:navigate>REGISTRO</a>
        </div>
    </div>
</x-guest-layout>
