<?php

use App\Models\City;
use App\Models\Department;
use App\Models\User;
use App\Providers\RouteServiceProvider;
use Illuminate\Auth\Events\Registered;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Livewire\Attributes\Layout;
use Livewire\Volt\Component;

new #[Layout('layouts.guest')]
class extends Component {
    public $departments = [], $cities = [];

    public string $first_name = '';
    public string $last_name = '';
    public string $email = '';
    public string $phone = '';
    public string $document = '';
    public string $department_id = '';
    public string $city_id = '';
    public string $password = '';
    public string $password_confirmation = '';
    public bool $terms;
    public bool $personal_data;

    public function mount()
    {
        $this->getDepartments();
    }

    public function getDepartments()
    {
        $this->departments = Department::where('active', true)->get();
    }

    public function updatedDepartmentId()
    {
        if ($this->department_id != '') {
            $this->cities = City::where([
                'department_id' => $this->department_id,
                'active' => 1
            ])->get();
        } else {
            $this->cities = [];
        }
    }

    /**
     * Handle an incoming registration request.
     */
    public function register(): void
    {
        $this->validate(
            [
                'first_name' => ['required', 'string', 'max:255'],
                'last_name' => ['required', 'string', 'max:255'],
                'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:' . User::class],
                'phone' => ['required', 'string', 'max:10'],
                'document' => ['required', 'string', 'max:10'],
                'department_id' => ['required'],
                'city_id' => ['required'],
                'password' => ['required', 'confirmed', Rules\Password::defaults()],
                'terms' => ['required'],
                'personal_data' => ['required']
            ],
            [
                'first_name.required' => 'Debes ingresar tus nombres.',
                'last_name.required' => 'Debes ingresar tus apellidos.',

                'email.required' => 'Debes ingresar un correo electrónico.',
                'email.email' => 'Ingresa un correo electrónico válido.',
                'email.unique' => 'Este correo ya se encuentra registrado.',

                'phone.required' => 'Debes ingresar tu teléfono.',
                'phone.max' => 'El teléfono no puede tener más de 10 dígitos.',

                'document.required' => 'Debes ingresar tu número de cédula.',
                'document.max' => 'La cédula no puede tener más de 10 dígitos.',

                'department_id.required' => 'Debes seleccionar un departamento.',
                'city_id.required' => 'Debes seleccionar una ciudad.',

                'password.required' => 'Debes crear una contraseña.',
                'password.confirmed' => 'Las contraseñas no coinciden.',

                'terms.required' => 'Debes aceptar los términos y condiciones.',
                'personal_data.required' => 'Debes aceptar el tratamiento de datos personales.'
            ]
        );

        $user_data = [
            'first_name' => $this->first_name,
            'last_name' => $this->last_name,
            'email' => $this->email,
            'phone' => $this->phone,
            'document' => $this->document,
            'city_id' => $this->city_id,
            'role_id' => 3,
            'terms' => $this->terms,
            'personal_data' => $this->personal_data
        ];

        $user_data['password'] = Hash::make($this->password);

        event(new Registered($user = User::create($user_data)));

        Auth::login($user);

        $this->dispatch(
            'register-success',
            message: '¡Tus datos han sido registrados!',
            url: route('participants.home')
        );
    }
}; ?>

<div class="md:w-[500px] flex flex-col justify-center items-center">
    <h2 class="relative font-bold text-[48px] md:text-[60px] 2xl:text-[80px] text-center title-stroke tracking-wider mb-5
        after:absolute after:content-[''] after:left-[10%] after:-bottom-1 after:w-4/5 after:h-[2px] after:bg-yellow">
        REGISTRO
    </h2>

    <form wire:submit="register" class="md:w-[400px]">
        <div class="grid grid-cols-2">
            <div class="flex flex-col mb-1 mr-1">
                <label for="first_name"
                       class="font-bold text-[20px] text-white ml-2 mb-1">Nombres</label>
                <input type="text" id="first_name" name="first_name" wire:model="first_name"
                       class="py-1 px-5 bg-white rounded-lg text-lg" placeholder="Juan" required autofocus>
                <x-input-error :messages="$errors->get('first_name')" class="mt-2"/>
            </div>
            <div class="flex flex-col mb-1 ml-1">
                <label for="last_name"
                       class="font-bold text-[20px] text-white ml-2 mb-1">Apellidos</label>
                <input type="text" id="last_name" name="last_name" wire:model="last_name"
                       class="py-1 px-5 bg-white rounded-lg text-lg" placeholder="Perez" required>
                <x-input-error :messages="$errors->get('last_name')" class="mt-2"/>
            </div>
            <div class="col-span-2 flex flex-col mb-1">
                <label for="email"
                       class="font-bold text-[20px] text-white ml-2 mb-1">Correo</label>
                <input type="email" id="email" name="email" wire:model="email"
                       class="py-1 px-5 bg-white rounded-lg text-lg" placeholder="correo@correo.com" required>
                <x-input-error :messages="$errors->get('email')" class="mt-2"/>
            </div>
            <div class="col-span-2 flex flex-col mb-1">
                <label for="phone"
                       class="font-bold text-[20px] text-white ml-2 mb-1">Teléfono</label>
                <input type="number" id="phone" name="phone" wire:model="phone"
                       class="py-1 px-5 bg-white rounded-lg text-lg" min="0" placeholder="311*******" required>
                <x-input-error :messages="$errors->get('phone')" class="mt-2"/>
            </div>
            <div class="col-span-2 flex flex-col mb-1">
                <label for="document"
                       class="font-bold text-[20px] text-white ml-2 mb-1">Cédula</label>
                <input type="number" id="document" name="document" wire:model="document"
                       class="py-1 px-5 bg-white rounded-lg text-lg" min="0" placeholder="101*******" required>
                <x-input-error :messages="$errors->get('document')" class="mt-2"/>
            </div>
            <div class="flex flex-col mb-1 mr-1">
                <label for="password" class="font-bold text-[20px] text-white ml-2 mb-1">
                    Contraseña
                </label>
                <div class="relative">
                    <input type="password"  id="password"  wire:model="password"
                           class="py-1 px-5 bg-white rounded-lg text-lg w-full" placeholder="*********" required>
                    <button type="button" onclick="togglePassword('password', this)"
                        class="absolute right-3 top-1/2 -translate-y-1/2 text-gray-600">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M2.036 12.322a1.012 1.012 0 0 1 0-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178Z" />
                            <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z" />
                        </svg>
                    </button>
                </div>
                <x-input-error :messages="$errors->get('password')" class="mt-2"/>
            </div>

            <div class="flex flex-col mb-1 ml-1">
                <label for="password_confirmation" class="font-bold text-[20px] text-white ml-2 mb-1">
                    Confirmar contraseña
                </label>
                <div class="relative">
                    <input type="password" id="password_confirmation" wire:model="password_confirmation"
                        class="py-1 px-5 bg-white rounded-lg text-lg w-full" placeholder="*********" required>
                    <button type="button" onclick="togglePassword('password_confirmation', this)"
                        class="absolute right-3 top-1/2 -translate-y-1/2 text-gray-600">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M2.036 12.322a1.012 1.012 0 0 1 0-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178Z" />
                            <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z" />
                        </svg>
                    </button>
                </div>
                <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2"/>
            </div>
            <div class="flex flex-col mb-2 mr-1">
                <label for="department_id"
                       class="font-bold text-[20px] text-white ml-2 mb-1">Departamento</label>
                <select id="department_id" name="department_id" wire:model.live="department_id"
                        class="py-1 px-5 bg-white rounded-lg text-lg" required>
                    <option value>--Seleccione--</option>
                    @foreach ($departments as $department)
                        <option value="{{ $department->id }}">
                            {{ $department->name }}
                        </option>
                    @endforeach
                </select>
            </div>
            <div class="flex flex-col mb-2 ml-1">
                <label for="city_id"
                       class="font-bold text-[20px] text-white ml-2 mb-1">Ciudad</label>
                <select id="city_id" name="city_id" wire:model="city_id"
                        class="py-1 px-5 bg-white rounded-lg text-lg" required>
                    <option value>--Seleccione--</option>
                    @foreach ($cities as $city)
                        <option value="{{ $city->id }}">
                            {{ $city->name }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="col-span-2 flex items-center mb-1">
                <input type="checkbox" id="terms" wire:model="terms"
                       class="w-4 h-4 border border-default-medium rounded-xs bg-neutral-secondary-medium focus:ring-2 focus:ring-brand-soft"
                       required>
                <label for="terms" class="select-none ms-2 text-[18px] font-bold text-white">
                    Acepto los
                    <a href="https://activatusvacaciones.com/terminos-condiciones.pdf" target="_blank"
                       class="text-yellow underline">
                        términos y condiciones
                    </a>
                </label>
            </div>
            <div class="col-span-2 flex items-center">
                <input type="checkbox" id="personal_data_checkbox" wire:model="personal_data"
                       class="w-4 h-4 border border-default-medium rounded-xs bg-neutral-secondary-medium focus:ring-2 focus:ring-brand-soft"
                       required>
                <label for="personal_data_checkbox" class="select-none ms-2 text-[18px] font-bold text-white">
                    Acepto el
                    <a href="https://activatusvacaciones.com/terminos-condiciones.pdf" target="_blank"
                       class="text-yellow underline">
                        tratamiento de datos personales
                    </a>
                </label>
            </div>
        </div>

        <div class="flex justify-center items-center my-5">
            <button type="submit"
                class="w-[180px] 2xl:w-[250px] rounded-xl bg-primary text-white text-[30px] 2xl:text-[40px] text-center font-bold border border-white"
                wire:target="register"
                wire:loading.class="opacity-75 pointer-events-none">
                <div wire:loading wire:target="register"
                     class="w-4 h-4 border-4 border-white border-t-transparent mr-2 rounded-full animate-spin"></div>
                ACEPTAR
            </button>
        </div>

        <div class="flex justify-center items-center">
            <a href="{{ route('login') }}" class="font-bold text-xl text-yellow cursor-pointer mb-1"
               wire:navigate>
                Iniciar sesión
            </a>
        </div>
    </form>
</div>

@section('footer')
    <p class="text-sm text-white text-center">
        Oferta válida del 15 de Junio de 2026 al 15 de Julio de 2026 <br>
        <a href="#" class="text-yellow underline">Consulta términos y condiciones</a> en activatupasion.com <br>
        © 2026 Rapid Repel & Black Flag. Todos los derechos reservados.
    </p>
@endsection

@push('scripts')
    <script>
        window.addEventListener('register-success', event => {
            console.log(event.detail);
            Swal.fire({
                title: '¡Listo!',
                text: event.detail.message,
                icon: 'success',
                showConfirmButton: true,
                confirmButtonText: 'Continuar',
                allowOutsideClick: false
            }).then(() => {
                window.location.href = event.detail.url;
            });
        });

        function togglePassword(inputId, button) {
            const input = document.getElementById(inputId);

            if (input.type === 'password') {
                input.type = 'text';
                button.innerHTML = '<svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6"><path stroke-linecap="round" stroke-linejoin="round" d="M3.98 8.223A10.477 10.477 0 0 0 1.934 12C3.226 16.338 7.244 19.5 12 19.5c.993 0 1.953-.138 2.863-.395M6.228 6.228A10.451 10.451 0 0 1 12 4.5c4.756 0 8.773 3.162 10.065 7.498a10.522 10.522 0 0 1-4.293 5.774M6.228 6.228 3 3m3.228 3.228 3.65 3.65m7.894 7.894L21 21m-3.228-3.228-3.65-3.65m0 0a3 3 0 1 0-4.243-4.243m4.242 4.242L9.88 9.88" /></svg>';
            } else {
                input.type = 'password';
                button.innerHTML = '<svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6"> <path stroke-linecap="round" stroke-linejoin="round" d="M2.036 12.322a1.012 1.012 0 0 1 0-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178Z" /><path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z" /></svg>';
            }
        }
    </script>
@endpush
