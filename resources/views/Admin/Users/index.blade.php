<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-3xl text-gray-800 leading-tight">
            {{ __('Usuarios') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6 bg-white rounded-3xl shadow-xl overflow-hidden">
            <livewire:admin.users.index />
            <livewire:admin.users.user-form />
        </div>
    </div>

    <script>
        window.addEventListener('user-saved', event => {
            Swal.fire({
                title: '¡Listo!',
                text: event.detail.message,
                icon: 'success',
                confirmButtonText: 'Continuar',
                allowOutsideClick: false
            });
        });
    </script>
</x-app-layout>
