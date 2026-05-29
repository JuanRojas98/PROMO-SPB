<x-slot name="header">
    <h2 class="font-semibold text-3xl text-gray-800 leading-tight">
        {{ __('Facturas') }}
    </h2>
</x-slot>

<div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6 bg-white rounded-3xl shadow-xl overflow-hidden">
        <!-- Header -->
        <div class="flex items-center justify-between px-6 py-5">
            <div>
                <p class="text-gray-600 text-xl mt-1">
                    Revisa y aprueba las facturas de los participantes.
                </p>
            </div>

            <div class="px-4 py-2 rounded-xl text-primary font-bold text-xl">
                {{ $invoices->count() }} pendientes
            </div>
        </div>

        <div class="px-6" style="margin-top: 0 !important;">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-5">
                <div class="space-y-2">
                    <x-input-label for="document" :value="__('Cédula')"
                        class="text-xl text-gray-900"/>
                    <x-text-input wire:model.live="document" type="text" id="document" name="document"
                        class="w-full text-lg" placeholder="Ej. 123456789" />
                </div>
                <div class="space-y-2">
                    <x-input-label for="department_id" :value="__('Departamento')"
                        class="text-xl text-gray-900"/>
                    <select wire:model.live="department_id" id="department_id" name="department_id"
                        class="w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm text-lg">
                        <option value>--Seleccione--</option>
                        @foreach ($departments as $department)
                            <option value="{{ $department->id }}">
                                {{ $department->name }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="space-y-2">
                    <x-input-label for="city_id" :value="__('Ciudad')"
                        class="text-xl text-gray-900"/>
                    <select wire:model.live="city_id" id="city_id" name="city_id"
                        class="w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm text-lg">
                        <option value>--Seleccione--</option>
                        @foreach ($cities as $city)
                            <option value="{{ $city->id }}">
                                {{ $city->name }}
                            </option>
                        @endforeach
                    </select>
                </div>
            </div>
        </div>

        <!-- Tabla -->
        <div class="overflow-x-auto pb-5">
            <table class="w-full">
                <thead class="bg-[#F5F5F5] border-b border-gray-200">
                    <tr>
                        <th class="px-6 py-4 text-left text-lg font-black uppercase text-gray-600">
                            #
                        </th>
                        <th class="px-6 py-4 text-left text-lg font-black uppercase text-gray-600">
                            Usuario
                        </th>
                        <th class="px-6 py-4 text-left text-lg font-black uppercase text-gray-600">
                            Cédula
                        </th>
                        <th class="px-6 py-4 text-left text-lg font-black uppercase text-gray-600">
                            Teléfono
                        </th>
                        <th class="px-6 py-4 text-left text-lg font-black uppercase text-gray-600">
                            Departamento / Ciudad
                        </th>
                        <th class="px-6 py-4 text-left text-lg font-black uppercase text-gray-600">
                            Código
                        </th>
                        <th class="px-6 py-4 text-left text-lg font-black uppercase text-gray-600">
                            Archivo
                        </th>
                        <th class="px-6 py-4 text-left text-lg font-black uppercase text-gray-600">
                            Fecha
                        </th>
                        <th class="px-6 py-4 text-center text-lg font-black uppercase text-gray-600">
                            Acciones
                        </th>
                    </tr>
                </thead>

                <tbody class="divide-y divide-gray-100">
                    @forelse($invoices as $invoice)
                        <tr class="hover:bg-gray-50 transition-colors duration-200 text-lg">
                            <!-- ID -->
                            <td class="px-6 py-5 font-bold text-gray-900">
                                {{ $invoice->id }}
                            </td>

                            <!-- Usuario -->
                            <td class="px-6 py-5">
                                <div class="flex flex-col">
                                    <span class="font-bold text-gray-900">
                                        {{ $invoice->user->first_name . ' ' . $invoice->user->last_name }}
                                    </span>

                                    <span class="text-sm text-gray-500">
                                        {{ $invoice->user->email }}
                                    </span>
                                </div>
                            </td>

                            <!-- Cédula -->
                            <td class="px-6 py-5 text-gray-600 font-medium">
                                {{ $invoice->user->document }}
                            </td>

                            <!-- Teléfono -->
                            <td class="px-6 py-5 text-gray-600 font-medium">
                                {{ $invoice->user->phone }}
                            </td>

                            <!-- Departamento / Ciudad -->
                            <td class="px-6 py-5">
                                <div class="flex flex-col">
                                    <span class="font-bold text-gray-900">
                                        {{ $invoice->user->city->department->name }}
                                    </span>

                                    <span class="text-sm text-gray-500">
                                        {{ $invoice->user->city->name }}
                                    </span>
                                </div>
                            </td>

                            <!-- Código -->
                            <td class="px-6 py-5">
                                <span class="px-3 py-1 rounded-lg bg-gray-100 text-gray-700 font-bold tracking-wider">
                                    {{ $invoice->invoice_code }}
                                </span>
                            </td>

                            <!-- Archivo -->
                            <td class="px-6 py-5">
                                <a
                                    href="{{ Storage::url($invoice->invoice_file) }}"
                                    target="_blank"
                                    class="inline-flex items-center gap-2 px-4 py-2 rounded-xl bg-blue-100 text-blue-700 font-bold hover:bg-blue-200 transition"
                                >
                                    Ver factura
                                </a>
                            </td>

                            <!-- Fecha -->
                            <td class="px-6 py-5 text-gray-600 font-medium">
                                {{ $invoice->created_at->format('d/m/Y h:i A') }}
                            </td>

                            <!-- Acciones -->
                            <td class="px-6 py-5">
                                <div class="flex items-center justify-center gap-3">
                                    <!-- Aprobar -->
                                    <button
                                        wire:click="approve({{ $invoice->id }})"
                                        wire:loading.class="opacity-75 pointer-events-none"
                                        class="px-4 py-2 rounded-xl bg-blue-200 text-blue-700 font-bold hover:bg-blue-300 transition"
                                    >
                                        <div wire:loading wire:target="approve"
                                             class="w-4 h-4 border-4 border-white border-t-transparent mr-2 rounded-full animate-spin"></div>
                                        Aprobar
                                    </button>

                                    <!-- Rechazar -->
                                    <button
                                        wire:click="reject({{ $invoice->id }})"
                                        wire:loading.class="opacity-75 pointer-events-none"
                                        class="px-4 py-2 rounded-xl bg-red-200 text-red-700 font-bold hover:bg-red-300 transition"
                                    >
                                        <div wire:loading wire:target="reject"
                                             class="w-4 h-4 border-4 border-white border-t-transparent mr-2 rounded-full animate-spin"></div>
                                        Rechazar
                                    </button>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="9" class="px-6 py-10 text-center">
                                <div class="flex flex-col items-center">

                                    <p class="text-2xl font-black text-gray-400 uppercase">
                                        No hay facturas pendientes
                                    </p>

                                    <p class="text-gray-500 mt-2">
                                        Todas las facturas ya fueron revisadas
                                    </p>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

@script
    <script>
        $wire.on('invoice-approved', (event) => {
            Swal.fire({
                title: '¡Listo!',
                text: event.message,
                icon: 'success',
                confirmButtonText: 'Continuar',
                allowOutsideClick: false
            });
        });

        $wire.on('invoice-rejected', (event) => {
            Swal.fire({
                title: '¡Listo!',
                text: event.message,
                icon: 'warning',
                confirmButtonText: 'Continuar',
                allowOutsideClick: false
            });
        });
    </script>
@endscript
