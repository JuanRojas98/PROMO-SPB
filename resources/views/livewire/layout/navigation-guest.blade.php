<?php
use App\Livewire\Actions\Logout;
use Illuminate\Support\Facades\Auth;
use Livewire\Volt\Component;

new class extends Component {
    /**
    * Log the current user out of the application.
    */
    public function logout(Logout $logout): void
    {
        $logout();

        $this->redirect('/', navigate: true);
    }
};
?>

<header class="absolute top-0 left-0 z-30 w-full py-2 px-5 lg:px-8 flex justify-between items-center">
    @if (Auth::user())
        <x-dropdown align="left" width="full" content-classes="bg-primary">
            <x-slot name="trigger">
                <div class="flex">
                    <a class="w-[160px] lg:w-[230px] p-2 rounded-full border border-white flex justify-center gap-2 cursor-pointer">
                        <img src="{{ asset('images/usuario.png') }}" class="w-[25px] h-[25px]">
                        <span class="font-semibold text-white uppercase text-center text-xl 2xl:text-2xl">
                            {{ Auth::user()->first_name . ' ' . Auth::user()->last_name }}
                        </span>
                    </a>
                </div>
            </x-slot>
            <x-slot name="content" class="start-0">
                <!-- Authentication -->
                <button wire:click="logout" class="w-full text-start">
                    <x-dropdown-link class="text-yellow md:text-2xl md:text-center font-bold">
                        {{ __('Cerrar sesión') }}
                    </x-dropdown-link>
                </button>
            </x-slot>
        </x-dropdown>
    @else
        <div class="flex"></div>
    @endif
    <div class="flex justify-between items-center gap-5">
        <img src="{{ asset('images/logo_black_flag.png') }}" class="w-[46px] lg:w-[80px] 2xl:w-[132px]">
        <img src="{{ asset('images/logo_rapid_repel.png') }}" class="w-[46px] lg:w-[80px] 2xl:w-[132px]">
    </div>
</header>
