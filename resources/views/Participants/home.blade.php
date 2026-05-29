<x-guest-layout>
    <div class="md:w-[500px] flex flex-col justify-center items-center">
        <div class="flex flex-col justify-center items-center gap-5">
            <a href="{{ route('participants.invoices.upload') }}" class="w-[180px] xl:w-[400px] rounded-xl bg-yellow text-green-dark text-[30px] xl:text-[40px] text-center font-bold border border-white mb-3"
                wire:navigate>
                CARGA TU FACTURA
            </a>
            <a href="{{ route('participants.ranking') }}" class="w-[180px] xl:w-[400px] rounded-xl bg-yellow text-green-dark text-[30px] xl:text-[40px] text-center font-bold border border-white"
                wire:navigate>
                RANKING
            </a>
        </div>
    </div>
</x-guest-layout>
