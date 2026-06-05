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
        $this->validate([
            'first_name' => ['required', 'string', 'max:255'],
            'last_name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:' . User::class],
            'phone' => ['required', 'string', 'max:10'],
            'document' => ['required', 'string', 'max:10'],
            'department_id' => ['required'],
            'city_id' => ['required'],
            'terms' => ['required'],
            'personal_data' => ['required']
        ]);

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

        $user_data['password'] = Hash::make($this->document);

        event(new Registered($user = User::create($user_data)));

        $this->dispatch(
            'register-success',
            message: '¡Registro exitoso! Ahora puedes iniciar sesión.'
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
            <div class="col-span-2 flex flex-col mb-1">
                <label for="first_name"
                       class="font-bold text-[20px] text-white ml-2 mb-1">Nombres</label>
                <input type="text" id="first_name" name="first_name" wire:model="first_name"
                       class="py-1 px-5 bg-white rounded-lg text-lg" placeholder="Juan" required autofocus>
                <x-input-error :messages="$errors->get('first_name')" class="mt-2"/>
            </div>
            <div class="col-span-2 flex flex-col mb-1">
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

        <div class="flex justify-center items-center mt-5">
            <button type="submit"
                class="w-[180px] 2xl:w-[250px] rounded-xl bg-primary text-white text-[30px] 2xl:text-[40px] text-center font-bold border border-white"
                wire:target="register"
                wire:loading.class="opacity-75 pointer-events-none">
                <div wire:loading wire:target="register"
                     class="w-4 h-4 border-4 border-white border-t-transparent mr-2 rounded-full animate-spin"></div>
                ACEPTAR
            </button>
        </div>
    </form>
</div>

@push('scripts')
    <script>
        window.addEventListener('register-success', event => {
            Swal.fire({
                title: '¡Listo!',
                text: event.detail.message,
                icon: 'success',
                confirmButtonText: 'Ir al login',
                allowOutsideClick: false
            }).then(() => {
                window.location.href = "{{ route('login') }}";
            });
        });
    </script>
@endpush
