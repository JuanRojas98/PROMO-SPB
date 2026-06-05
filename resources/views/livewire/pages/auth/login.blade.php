<?php

use App\Livewire\Forms\LoginForm;
use App\Providers\RouteServiceProvider;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Livewire\Attributes\Layout;
use Livewire\Volt\Component;

new #[Layout('layouts.guest')]
class extends Component {
    public LoginForm $form;

    /**
     * Handle an incoming authentication request.
     */
    public function login(): void
    {
        $this->validate();

        $this->form->authenticate();

        Session::regenerate();

        if (Auth::user()->role_id == 1) {
            $this->redirect(route('admin.users'), navigate: true);
        } elseif (Auth::user()->role_id == 2) {
            $this->redirect(route('backoffice.invoices'), navigate: true);
        } elseif (Auth::user()->role_id == 3) {
            $this->redirect(route('participants.home'), navigate: true);
        }
    }
}; ?>

<div class="md:w-[500px] flex flex-col justify-center items-center">
    <h2 class="relative font-bold text-[48px] md:text-[70px] 2xl:text-[80px] text-center title-stroke tracking-wider mb-7
        after:absolute after:content-[''] after:left-[10%] after:-bottom-2 after:w-4/5 after:h-[2px] after:bg-yellow">
        INICIAR SESIÓN
    </h2>

    <x-auth-session-status class="mb-4" :status="session('status')"/>

    <form wire:submit="login" class="md:w-[400px]">
        <div class="flex flex-col mb-3">
            <label for="email"
                   class="font-bold text-[24px] text-white ml-5 mb-2">Correo</label>
            <input type="email" id="email" name="email" wire:model="form.email"
                   class="py-2 px-5 bg-white rounded-full text-xl" placeholder="correo@correo.com" required autofocus>
            <x-input-error :messages="$errors->get('form.email')" class="mt-2"/>
        </div>
        <div class="flex flex-col">
            <label for="password"
                   class="font-bold text-[24px] text-white ml-5 mb-2">Contraseña</label>
            <input type="password" id="password" name="password" wire:model="form.password"
                   class="py-2 px-5 bg-white rounded-full text-xl" placeholder="*******" required>
            <x-input-error :messages="$errors->get('form.password')" class="mt-2"/>
        </div>

        <div class="flex justify-center items-center mt-10 mb-5">
            <button type="submit"
                    class="w-[180px] 2xl:w-[250px] rounded-xl bg-yellow text-green-dark text-[30px] 2xl:text-[40px] text-center font-bold"
                    wire:target="login"
                    wire:loading.class="opacity-75 pointer-events-none">
                <div wire:loading wire:target="login"
                     class="w-4 h-4 border-4 border-white border-t-transparent mr-2 rounded-full animate-spin"></div>
                ACEPTAR
            </button>
        </div>

        <div class="flex justify-center items-center">
            <a href="{{ route('password.request') }}" class="font-bold text-xl text-yellow cursor-pointer"
                wire:navigate>
                ¿Olvidaste tú contraseña?
            </a>
        </div>
    </form>
</div>
