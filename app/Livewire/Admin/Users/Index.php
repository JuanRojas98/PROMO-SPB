<?php

namespace App\Livewire\Admin\Users;

use App\Models\Role;
use App\Models\User;
use Livewire\Attributes\On;
use Livewire\Component;

class Index extends Component
{
    public $document;
    public $role_id;
    public $roles = [];
    public $users = [];

    #[On('user-saved')]
    public function refresh() {}

    public function render()
    {
        $queryUsers = User::query()
            ->when($this->document, function ($query) {
                $query->where('document', 'LIKE', '%' . $this->document . '%');
            })
            ->when($this->role_id, function ($query) {
                $query->where('role_id', $this->role_id);
            });

        $this->users = $queryUsers->latest()->get();

        return view('livewire.admin.users.index');
    }

    public function mount() {
        $this->getRoles();
    }

    public function getRoles() {
        $this->roles = Role::get();
    }
}
