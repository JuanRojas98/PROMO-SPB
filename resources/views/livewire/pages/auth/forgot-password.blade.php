<?php

use Illuminate\Support\Facades\Password;
use Livewire\Attributes\Layout;
use Livewire\Volt\Component;

new #[Layout('layouts.guest')] class extends Component
{
    public string $email = '';

    /**
     * Send a password reset link to the provided email address.
     */
    public function sendPasswordResetLink(): void
    {
        $this->validate([
            'email' => ['required', 'string', 'email'],
        ]);

        $status = Password::sendResetLink(
            $this->only('email')
        );

        if ($status != Password::RESET_LINK_SENT) {
            $this->addError('email', __($status));

            return;
        }

        $this->reset('email');

        session()->flash('status', __($status));
    }
}; ?>

<div>
    <div class="mb-4 text-white text-xl">
        {{ __('Ingresa tu dirección de correo electrónico y te enviaremos un enlace para restablecerla.') }}
    </div>

    <!-- Session Status -->
    <x-auth-session-status class="mb-4" :status="session('status')" />

    <form wire:submit="sendPasswordResetLink">
        <div class="flex flex-col mb-3">
            <label for="email" class="font-bold text-[24px] text-white ml-5 mb-2">Correo</label>
            <input type="email" id="email" name="email" wire:model="email"
                   class="py-2 px-5 bg-white rounded-full text-xl" placeholder="correo@correo.com" required autofocus>
            <x-input-error :messages="$errors->get('email')" class="mt-2"/>
        </div>

        <div class="flex justify-center items-center mt-5 mb-5">
            <button type="submit"
                class="w-[180px] 2xl:w-[250px] rounded-xl bg-yellow text-green-dark text-[30px] 2xl:text-[40px] text-center font-bold"
                wire:target="sendPasswordResetLink"
                wire:loading.class="opacity-75 pointer-events-none">
                <div wire:loading wire:target="sendPasswordResetLink"
                     class="w-4 h-4 border-4 border-white border-t-transparent mr-2 rounded-full animate-spin"></div>
                ENVIAR
            </button>
        </div>
    </form>
</div>
