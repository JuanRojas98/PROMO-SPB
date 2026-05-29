<x-modal name="user-form" :show="false">
    <!-- Header with customizable icon -->
    <div class="px-8 pt-8 pb-4 flex items-start justify-between bg-white/5">
        <div class="flex items-center gap-4">
            <div class="flex size-12 items-center justify-center rounded-full bg-primary/10 text-primary">
                <span class="material-symbols-outlined text-2xl">
                    {{ $user_id ? 'person_edit' : 'person_add' }}
                </span>
            </div>
            <div>
                <h3 class="text-2xl font-bold text-gray-800 leading-tight">
                    {{ $user_id ? 'Editar Usuario' : 'Crear Usuario' }}
                </h3>
                <p class="text-xl text-gray-500">
                    Completa todos los datos para {{ $user_id ? 'editar' : 'crear' }} el usuario.
                </p>
            </div>
        </div>
        <button class="text-gray-400 hover:text-gray-800  transition-colors"
                x-on:click="$dispatch('close')">
            <span class="material-symbols-outlined">close</span>
        </button>
    </div>

    <!-- Modal Body -->
    <div class="px-8 py-6 space-y-5 flex-grow h-[85vh] overflow-y-auto">
        <form wire:submit="save" id="user-form-submit">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                <div class="space-y-2">
                    <x-input-label for="first_name" class="block font-medium text-sm text-gray-700 text-xl text-gray-900"
                        :value="__('Nombres')" />
                    <div class="relative">
                        <x-text-input wire:model="first_name" type="text" id="first_name" name="first_name" required autofocus
                            class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm w-full text-lg"
                            placeholder="Ej. Juan" autocomplete="first_name" />
                    </div>
                </div>
                <div class="space-y-2">
                    <x-input-label for="last_name" class="block font-medium text-sm text-gray-700 text-xl text-gray-900"
                        :value="__('Apellidos')" />
                    <div class="relative">
                        <x-text-input wire:model="last_name" type="text" id="last_name" name="last_name" required
                            class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm w-full text-lg"
                            placeholder="Ej. Perez" autocomplete="last_name" />
                    </div>
                </div>

                <div class="space-y-2">
                    <x-input-label for="document" class="block font-medium text-sm text-gray-700 text-xl text-gray-900"
                        :value="__('Documento')" />
                    <div class="relative">
                        <x-text-input wire:model="document" type="text" id="document" name="document" required
                            class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm w-full text-lg"
                            placeholder="Ej. 123456789" autocomplete="document" />
                    </div>
                </div>
                <div class="space-y-2">
                    <x-input-label for="email" class="block font-medium text-sm text-gray-700 text-xl text-gray-900"
                        :value="__('Correo')" />
                    <div class="relative">
                        <x-text-input wire:model="email" type="email" id="email" name="email" required
                        class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm w-full text-lg"
                        placeholder="Ej. 123456789" autocomplete="email" />
                    </div>
                </div>

                <div class="col-span-2 space-y-2">
                    <x-input-label for="phone" class="block font-medium text-sm text-gray-700 text-xl text-gray-900"
                        :value="__('Teléfono')" />
                    <div class="relative">
                        <x-text-input wire:model="phone" type="text" id="phone" name="phone" required
                            class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm w-full text-lg"
                            placeholder="Ej. 123456789" autocomplete="phone" />
                    </div>
                </div>

                <div class="space-y-2">
                    <x-input-label for="department_id" class="block font-medium text-sm text-gray-700 text-xl text-gray-900"
                        :value="__('Departamento')" />
                    <div class="relative">
                        <select wire:model.live="department_id" id="department_id" name="department_id" required
                            class="w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm text-lg">
                            <option value>--Seleccione--</option>
                            @foreach ($departments as $department)
                                <option value="{{ $department->id }}">
                                    {{ $department->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="space-y-2">
                    <x-input-label for="city_id" class="block font-medium text-sm text-gray-700 text-xl text-gray-900"
                        :value="__('Ciudad')" />
                    <div class="relative">
                        <select wire:model="city_id" id="city_id" name="city_id" required
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

                <div class="space-y-2">
                    <x-input-label for="role_id" class="block font-medium text-sm text-gray-700 text-xl text-gray-900"
                        :value="__('Rol')" />
                    <div class="relative">
                        <select wire:model="role_id" id="role_id" name="role_id" required
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
                <div class="space-y-2">
                    <x-input-label for="password" class="block font-medium text-sm text-gray-700 text-xl text-gray-900"
                        :value="__('Contraseña')" />
                    <div class="relative">
                        <x-text-input wire:model="password" type="password" id="password" name="password" required
                            class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm w-full text-lg"
                            placeholder="Ej. **********" autocomplete="password" />
                    </div>
                </div>
            </div>
        </form>
    </div>

    <!-- Footer Actions -->
    <div class="flex justify-end items-center gap-3 p-6 bg-white/5 border-t border-white/10">
        <button
            class="w-auto inline-flex items-center gap-2 px-4 py-2 rounded-xl bg-red-700 text-white text-lg font-bold hover:bg-red-800 transition"
            x-on:click="$dispatch('close')">
            Cancelar
        </button>
        <x-primary-button
            type="submit"
            form="user-form-submit"
            class="w-auto inline-flex items-center gap-2 px-4 py-2 rounded-xl bg-green-700 text-white text-lg font-bold hover:bg-green-800 transition"
            wire:loading.class="opacity-75 pointer-events-none">
            <div wire:loading class="w-4 h-4 border-4 border-white border-t-transparent mr-2 rounded-full animate-spin"></div>
            {{ __('Guardar') }}
        </x-primary-button>
    </div>
</x-modal>
