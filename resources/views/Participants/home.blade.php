<x-guest-layout>
    <div class="md:w-[500px] flex flex-col justify-center items-center">
        <img src="{{ asset('images/juega_y_gana_w.png') }}" class="w-[200px] md:w-[250px] lg:w-[300px] mt-5 mb-5"/>
        <div class="flex flex-col justify-center items-center gap-5">
            <a href="{{ route('participants.invoices.upload') }}" class="w-[180px] xl:w-[300px] 2xl-w-[350px] rounded-xl bg-yellow text-green-dark text-[30px] xl:text-[35px] text-center font-bold border border-white mb-3"
                wire:navigate>
                CARGA TU FACTURA
            </a>
            <a href="{{ route('participants.ranking') }}" class="w-[180px] xl:w-[300px] 2xl-w-[350px] rounded-xl bg-yellow text-green-dark text-[30px] xl:text-[35px] text-center font-bold border border-white"
                wire:navigate>
                RANKING
            </a>
        </div>
    </div>
</x-guest-layout>
