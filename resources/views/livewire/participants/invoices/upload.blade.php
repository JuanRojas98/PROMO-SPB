<div class="md:w-[500px] flex flex-col justify-center items-center">
    <h2 class="relative font-bold text-[48px] md:text-[70px] 2xl:text-[80px] text-center title-stroke tracking-wider mb-7
        after:absolute after:content-[''] after:left-[20%] after:-bottom-2 after:w-3/5 after:h-[2px] after:bg-yellow">
        CARGA TU FACTURA
    </h2>

    <form wire:submit.prevent="saveInvoice" class="md:w-[400px]">
        <div class="flex flex-col gap-5">
            <div class="flex flex-col mb-2">
                <label for="invoice_code"
                       class="font-bold text-[24px] text-white text-center ml-2 mb-2">
                    Registra el código de factura
                </label>
                <input type="text" id="invoice_code" name="invoice_code" wire:model="invoice_code"
                       class="py-2 px-5 bg-white rounded-xl text-2xl text-center" placeholder="XXXX - XXXX -XXXX"
                       required autofocus>
                <x-input-error :messages="$errors->get('invoice_code')" class="mt-2 text-xl text-red-500"/>
            </div>
            <div class="flex flex-col justify-center items-center p-5 border border-dashed border-white rounded-2xl">

                <label for="invoice_file" class="w-full cursor-pointer flex flex-col items-center">
                    <span class="font-black text-[24px] text-white text-center mb-2">
                        SUBE TU FACTURA
                    </span>

                    @if ($invoice_file)
                        <img src="{{ $invoice_file->temporaryUrl() }}" class="w-[85px] h-[85px]">
                    @else
                        <img src="{{ asset('storage/images/upload_icon.png') }}" class="w-[85px] h-[85px] opacity-30">
                    @endif
                </label>

                <input
                    type="file"
                    id="invoice_file"
                    wire:model="invoice_file"
                    class="hidden"
                    accept=".jpg, .jpeg, .png, .pdf, image/jpeg, image/png, application/pdf"
                >

                <x-input-error
                    class="mt-2 text-xl text-red-500"
                    :messages="$errors->get('invoice_file')"
                />
            </div>
        </div>

        <div class="flex justify-center items-center mt-7">
            <button type="submit"
                    class="w-[180px] 2xl:w-[250px] rounded-xl bg-yellow text-green-dark text-[30px] 2xl:text-[40px] text-center font-bold border border-white"
                    wire:target="saveInvoice"
                    wire:loading.class="opacity-75 pointer-events-none">
                <div wire:loading wire:target="saveInvoice"
                     class="w-4 h-4 border-4 border-white border-t-transparent mr-2 rounded-full animate-spin"></div>
                ENVIAR
            </button>
        </div>
    </form>
</div>

@script
<script>
    $wire.on('invoice-saved', (event) => {

        Swal.fire({
            title: '¡Factura registrada!',
            text: 'Ahora podrás participar en el juego.',
            icon: 'success',
            confirmButtonText: 'Continuar',
            allowOutsideClick: false
        }).then(() => {
            window.location.href = event.url;
        });
    });
</script>
@endscript
