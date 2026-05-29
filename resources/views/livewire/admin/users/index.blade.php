<div>
    <!-- Header -->
    <div class="flex items-center justify-between px-6 py-5">
        <div>
            <p class="text-gray-600 text-xl mt-1">
                Gestiona los usuarios del sistema.
            </p>
        </div>

        <button href="#" target="_blank" x-data x-on:click="$dispatch('create-user')"
            class="inline-flex items-center gap-2 px-4 py-2 rounded-xl bg-green-200 text-green-700 text-xl font-bold hover:bg-green-300 transition">
            Nuevo usuario
        </button>
    </div>

    <div class="px-6 mb-5" style="margin-top: 0 !important;">
        <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
            <div class="space-y-2">
                <x-input-label for="document" :value="__('Cédula')"
                    class="text-xl text-gray-900"/>
                <x-text-input wire:model.live="document" type="text" id="document" name="document"
                    class="w-full text-lg" placeholder="Ej. 123456789"/>
            </div>
            <div class="space-y-2">
                <x-input-label for="role_id" :value="__('Rol')"
                    class="text-xl text-gray-900"/>
                <select wire:model.live="role_id" id="role_id" name="role_id"
                    class="w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm text-lg">
                    <option value>--Seleccione--</option>
                    @foreach ($roles as $role)
                        <option value="{{ $role->id }}">
                            {{ $role->name }}
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
                        Rol
                    </th>
                    <th class="px-6 py-4 text-center text-lg font-black uppercase text-gray-600">
                        Acciones
                    </th>
                </tr>
            </thead>

            <tbody class="divide-y divide-gray-100">
                @forelse ($users as $user)
                    <tr class="hover:bg-gray-50 transition-colors duration-200 text-lg">
                        <!-- ID -->
                        <td class="px-6 py-5 font-bold text-gray-900">
                            {{ $user->id }}
                        </td>

                        <!-- Usuario -->
                        <td class="px-6 py-5">
                            <div class="flex flex-col">
                                <span class="font-bold text-gray-900">
                                    {{ $user->first_name . ' ' . $user->last_name }}
                                </span>

                                <span class="text-sm text-gray-500">
                                    {{ $user->email }}
                                </span>
                            </div>
                        </td>

                        <!-- Cédula -->
                        <td class="px-6 py-5 text-gray-600 font-medium">
                            {{ $user->document }}
                        </td>

                        <!-- Teléfono -->
                        <td class="px-6 py-5 text-gray-600 font-medium">
                            {{ $user->phone }}
                        </td>

                        <!-- Departamento / Ciudad -->
                        <td class="px-6 py-5">
                            <div class="flex flex-col">
                                <span class="font-bold text-gray-900">
                                    {{ $user->city->department->name }}
                                </span>

                                <span class="text-sm text-gray-500">
                                    {{ $user->city->name }}
                                </span>
                            </div>
                        </td>

                        <!-- Rol -->
                        <td class="px-6 py-5">
                            <span class="px-3 py-1 rounded-lg @if ($user->role_id == 1) bg-blue-100 text-blue-700 @elseif ($user->role_id == 2) bg-orange-100 text-orange-700 @else bg-green-100 text-green-700 @endif font-bold tracking-wider">
                                {{ $user->role->name }}
                            </span>
                        </td>

                        <!-- Acciones -->
                        <td class="px-6 py-5">
                            <div class="flex items-center justify-center gap-3">
                                <!-- Aprobar -->
                                <button
                                    wire:click="$dispatch('edit-user', { id: {{ $user->id }} })"
                                    wire:loading.class="opacity-75 pointer-events-none"
                                    class="px-4 py-2 rounded-xl bg-blue-200 text-blue-700 font-bold hover:bg-blue-300 transition">
                                    <div wire:loading wire:target="approve"
                                         class="w-4 h-4 border-4 border-white border-t-transparent mr-2 rounded-full animate-spin"></div>
                                    Editar
                                </button>

                                <!-- Rechazar -->
                                <button
                                    wire:click="reject({{ $user->id }})"
                                    wire:loading.class="opacity-75 pointer-events-none"
                                    class="px-4 py-2 rounded-xl bg-red-200 text-red-700 font-bold hover:bg-red-300 transition">
                                    <div wire:loading wire:target="reject"
                                         class="w-4 h-4 border-4 border-white border-t-transparent mr-2 rounded-full animate-spin"></div>
                                    Eliminar
                                </button>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7" class="px-6 py-10 text-center">
                            <div class="flex flex-col items-center">

                                <p class="text-2xl font-black text-gray-400 uppercase">
                                    No hay usuarios registrados
                                </p>

                                <p class="text-gray-500 mt-2">
                                    Sin usuarios en el sistema.
                                </p>
                            </div>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
