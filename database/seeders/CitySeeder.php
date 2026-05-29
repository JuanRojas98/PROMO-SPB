<?php

namespace Database\Seeders;

use App\Models\City;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CitySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $cities = [
            [
                'name' => 'Bogotá D.C.',
                'department_id' => 1
            ],
            [
                'name' => 'Medellín',
                'department_id' => 2
            ],
            [
                'name' => 'Barranquilla',
                'department_id' => 3
            ],
            [
                'name' => 'Calí',
                'department_id' => 4
            ]
        ];

        foreach ($cities as $city) {
            City::create($city);
        }
    }
}
