@props([
    'target' => null,
    'message' => 'Cargando...',
    'page' => false
])

<div
    @if(!$page)
        @if($target)
            wire:loading.flex
    wire:target="{{ $target }}"
    @else
        wire:loading.flex
    @endif
    @endif

    {{
        $attributes->merge([
            'class' => '
                fixed inset-0 z-[9999]
                bg-black backdrop-blur-sm
                flex items-center justify-center
                transition-all duration-500 ease-out
                opacity-100 visible'
        ])
    }}

    @if($page)
        id="page-loader"
    @endif
>

    <div class="flex flex-col items-center gap-5">
        <div class="w-20 h-20 border-4 border-yellow border-t-transparent rounded-full animate-spin"></div>

        <p class="text-yellow text-4xl font-bold tracking-wider">
            {{ $message }}
        </p>
    </div>
</div>

@if($page)
    @once
        @push('scripts')
            <script>
                async function waitForImages() {

                    const images = Array.from(document.images)

                    const promises = images.map((img) => {

                        // Imagen ya cargada
                        if (img.complete) {
                            return Promise.resolve()
                        }

                        // Esperar carga
                        return new Promise((resolve) => {
                            img.onload = resolve
                            img.onerror = resolve
                        })
                    })

                    await Promise.all(promises)
                }

                async function hidePageLoader() {

                    const loader = document.getElementById('page-loader')

                    if (!loader) return

                    // Esperar imágenes
                    await waitForImages()

                    setTimeout(() => {

                        loader.classList.remove(
                            'opacity-100',
                            'visible'
                        )

                        loader.classList.add(
                            'opacity-0',
                            'invisible'
                        )

                        setTimeout(() => {
                            loader.remove()
                        }, 500)

                    }, 300)
                }

                // Primera carga
                window.addEventListener('load', hidePageLoader)

                // Navegación Livewire
                document.addEventListener(
                    'livewire:navigated',
                    hidePageLoader
                )
            </script>
        @endpush
    @endonce
@endif
