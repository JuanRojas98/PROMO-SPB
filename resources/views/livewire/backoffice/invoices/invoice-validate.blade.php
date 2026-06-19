<x-modal name="invoice-validate" :show="false">
    <!-- Header with customizable icon -->
    <div class="px-8 pt-8 pb-4 flex items-start justify-between bg-white/5">
        <div class="flex items-center gap-4">
            <div class="flex size-12 items-center justify-center rounded-full bg-primary/10 text-primary">
                <span class="material-symbols-outlined text-2xl">
                    receipt
                </span>
            </div>
            <div>
                <h3 class="text-2xl font-bold text-gray-800 leading-tight">
                    Gestionar {{ $invoice_status == 'approved' ? 'aprobación' : 'rechazo' }} de factura
                </h3>
                <p class="text-xl text-gray-500">
                    Completa todos los datos para guardar la gestión.
                </p>
            </div>
        </div>
        <button class="text-gray-400 hover:text-gray-800  transition-colors"
                x-on:click="$dispatch('close')">
            <span class="material-symbols-outlined">close</span>
        </button>
    </div>

    <!-- Modal Body -->
    <div class="px-8 py-6 space-y-5 flex-grow h-[85vh] overflow-y-auto scrollbar-worldcup">
        <form wire:submit="save" id="invoice-form-submit">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                <div class="space-y-2 col-span-2">
                    <x-input-label for="points" class="block font-medium text-sm text-gray-700 text-xl text-gray-900"
                        :value="__('Puntos')" />
                    <div class="relative">
                        <x-text-input wire:model="points" type="number" id="points" name="points"
                            class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm w-full text-lg
                                disabled:bg-gray-100 disabled:text-gray-500 disabled:border-gray-200 disabled:cursor-not-allowed disabled:opacity-75"
                            required autofocus placeholder="Ej. 1" autocomplete="points"
                            :disabled="$invoice_status === 'rejected'" :required="$invoice_status === 'approved'"/>
                        <x-input-error class="mt-2 text-xl text-red-500" :messages="$errors->get('points')"/>
                    </div>
                </div>
                @if ($invoice_status == 'rejected')
                    <div class="space-y-2 col-span-2">
                        <x-input-label for="observations" class="block font-medium text-sm text-gray-700 text-xl text-gray-900"
                            :value="__('Observaciones')" />
                        <div class="relative">
                            <textarea wire:model="observations" id="observations" name="observations" rows="3"
                                class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm w-full text-lg"
                                placeholder="Ingresa las observaciones" required></textarea>
                            <x-input-error class="mt-2 text-xl text-red-500" :messages="$errors->get('observations')"/>
                        </div>
                    </div>
                @endif
            </div>
        </form>
    </div>

    <!-- Footer Actions -->
    <div class="flex justify-end items-center gap-3 p-6 bg-white/5 border-t border-white/10">
        <button
            class="w-auto inline-flex items-center gap-2 px-4 py-2 rounded-xl bg-red-700 text-white text-lg font-bold hover:bg-red-800 transition tracking-widest"
            x-on:click="$dispatch('close')">
            Cancelar
        </button>
        <x-primary-button type="button"
            class="w-auto inline-flex items-center gap-2 px-4 py-2 rounded-xl bg-green-700 text-white text-lg font-bold hover:bg-green-800 transition capitalize"
            x-on:click="confirmSaveInvoice()"
            wire:loading.class="opacity-75 pointer-events-none"
            wire:target="save"
        >
            <div wire:loading
                wire:target="save"
                class="w-4 h-4 border-4 border-white border-t-transparent mr-2 rounded-full animate-spin"></div>
            {{ __('Guardar') }}
        </x-primary-button>
    </div>
</x-modal>

@script
<script>
    window.confirmSaveInvoice = async function () {
        const form = document.getElementById('invoice-form-submit');

        if (!form.reportValidity()) {
            return;
        }

        const result = await Swal.fire({
            title: '¿Guardar gestión?',
            text: 'Esta acción registrará la gestión de la factura.',
            icon: 'question',
            showCancelButton: true,
            confirmButtonText: 'Guardar',
            cancelButtonText: 'Cancelar'
        });

        if (result.isConfirmed) {
            form.requestSubmit();
        }
    }
</script>
@endscript
