<?php

namespace Database\Seeders;

use App\Models\Department;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DepartmentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $departments = [
            ['name' => 'Bogotá, D.C.'],
            ['name' => 'Antioquia'],
            ['name' => 'Atlantico'],
            ['name' => 'Valle del Cauca']
        ];

        foreach ($departments as $department) {
            Department::create($department);
        }
    }
}
