<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $user = [
            'first_name' => 'Juan',
            'last_name' => 'Rojas',
            'document' => '123456789',
            'email' => 'juan.rojas@bullmarketing.com.co',
            'phone' => '123456789',
            'city_id' => 1,
            'password' => Hash::make('1010240075'),
            'role_id' => 1
        ];

        User::create($user);
    }
}
