<?php

namespace App\Livewire\Admin\Users;

use App\Models\City;
use App\Models\Department;
use App\Models\Role;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Livewire\Component;

class UserForm extends Component
{
    public $user_id;

    public $departments = [];
    public $cities = [];
    public $roles = [];
    public $first_name, $last_name, $document, $email, $phone, $department_id, $city_id, $password, $role_id;

    protected $listeners = [
        'create-user' => 'create',
        'edit-user' => 'edit'
    ];

    protected $rules = [
        'first_name' => ['required', 'string', 'max:255'],
        'last_name' => ['required', 'string', 'max:255'],
        'email' => ['required', 'string', 'lowercase', 'email', 'max:255'],
        'phone' => ['required', 'string', 'max:10'],
        'document' => ['required', 'string', 'max:10'],
        'department_id' => ['required'],
        'city_id' => ['required'],
        'role_id' => ['required']
    ];

    public function render()
    {
        return view('livewire.admin.users.user-form');
    }

    public function mount() {
        $this->getDepartments();
        $this->getRoles();
    }

    public function getDepartments() {
        $this->departments = Department::where('active', true)->get();
    }

    public function getRoles() {
        $this->roles = Role::get();
    }

    public function updatedDepartmentId() {
        if ($this->department_id != '') {
            $this->cities = City::where([
                'department_id' => $this->department_id,
                'active' => 1
            ])->get();
        } else {
            $this->cities = [];
        }
    }

    public function create() {
        $this->resetFields();
        $this->dispatch('open-modal', name: 'user-form');
    }

    public function edit($id) {
        $user = User::findOrFail($id);

        $this->user_id = $user->id;
        $this->first_name = $user->first_name;
        $this->last_name = $user->last_name;
        $this->document = $user->document;
        $this->email = $user->email;
        $this->phone = $user->phone;
        $this->department_id = $user->city->department->id;

        $this->cities = City::where('department_id', $this->department_id)->get();

        $this->city_id = $user->city_id;
        $this->role_id = $user->role_id;

        $this->dispatch('open-modal', name: 'user-form');
    }

    public function save() {
        $this->validate();

        $user = User::find($this->user_id);

        $data = [
            'first_name' => $this->first_name,
            'last_name' => $this->last_name,
            'document' => $this->document,
            'email' => $this->email,
            'phone' => $this->phone,
            'city_id' => $this->city_id,
            'role_id' => $this->role_id
        ];

        if (! $user) {
            $data['password'] = Hash::make($this->password);
        }
        else {
            if (! Hash::check($this->password, $user->password)) {
                $data['password'] = Hash::make($this->password);
            }
        }

        User::updateOrCreate(
            ['id' => $this->user_id],
            $data
        );

        $this->dispatch('close-modal', name: 'user-form');
        $this->dispatch('user-saved',
            message: $this->user_id ? 'Usuario actualizado exitosamente!' : 'Usuario creado exitosamente!'
        );

        $this->resetFields();
    }

    private function resetFields() {
        $this->reset([
            'user_id',
            'first_name',
            'last_name',
            'document',
            'email',
            'phone',
            'department_id',
            'city_id',
            'password',
            'role_id'
        ]);
    }
}
