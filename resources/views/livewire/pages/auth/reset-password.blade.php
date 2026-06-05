<?php

use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Str;
use Illuminate\Validation\Rules;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Locked;
use Livewire\Volt\Component;

new #[Layout('layouts.guest')] class extends Component
{
    #[Locked]
    public string $token = '';
    public string $email = '';
    public string $password = '';
    public string $password_confirmation = '';

    /**
     * Mount the component.
     */
    public function mount(string $token): void
    {
        $this->token = $token;
        $this->email = request()->string('email');
    }

    /**
     * Reset the password for the given user.
     */
    public function resetPassword(): void
    {
        $this->validate([
            'token' => ['required'],
            'email' => ['required', 'string', 'email'],
            'password' => ['required', 'string', 'confirmed', Rules\Password::defaults()],
        ]);

        $status = Password::reset(
            $this->only('email', 'password', 'password_confirmation', 'token'),
            function ($user) {
                $user->forceFill([
                    'password' => Hash::make($this->password),
                    'remember_token' => Str::random(60),
                ])->save();

                event(new PasswordReset($user));
            }
        );

        if ($status != Password::PASSWORD_RESET) {
            $this->addError('email', __($status));
            return;
        }

        Session::flash('status', __($status));
        $this->redirectRoute('login', navigate: true);
    }
}; ?>

<div>
    <div class="mb-4 text-white text-xl">
        {{ __('Completa los siguientes datos para confirmar el restablecimiento de la contraseña.') }}
    </div>

    <form wire:submit="resetPassword">
        <div class="flex flex-col mb-3">
            <label for="email" class="font-bold text-[24px] text-white ml-5 mb-2">Correo</label>
            <input type="email" id="email" name="email" wire:model="email"
                   class="py-2 px-5 bg-white rounded-full text-xl" placeholder="correo@correo.com" required autofocus autocomplete="username">
            <x-input-error :messages="$errors->get('email')" class="mt-2"/>
        </div>
        <div class="flex flex-col mb-3">
            <label for="password"
                   class="font-bold text-[24px] text-white ml-5 mb-2">Contraseña</label>
            <input type="password" id="password" name="password" wire:model="password"
                   class="py-2 px-5 bg-white rounded-full text-xl" placeholder="*******" required autocomplete="new-password">
            <x-input-error :messages="$errors->get('password')" class="mt-2"/>
        </div>
        <div class="flex flex-col mb-3">
            <label for="password_confirmation"
                   class="font-bold text-[24px] text-white ml-5 mb-2">Confirmar ontraseña</label>
            <input type="password" id="password_confirmation" name="password_confirmation" wire:model="password_confirmation"
                   class="py-2 px-5 bg-white rounded-full text-xl" placeholder="*******" required autocomplete="new-password">
            <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2"/>
        </div>

        <div class="flex justify-center items-center mt-5 mb-5">
            <button type="submit"
                    class="w-[200px] 2xl:w-[250px] rounded-xl bg-yellow text-green-dark text-[30px] 2xl:text-[40px] px-3 text-center font-bold"
                    wire:target="resetPassword"
                    wire:loading.class="opacity-75 pointer-events-none">
                <div wire:loading wire:target="resetPassword"
                     class="w-4 h-4 border-4 border-white border-t-transparent mr-2 rounded-full animate-spin"></div>
                GUARDAR
            </button>
        </div>
    </form>
</div>
