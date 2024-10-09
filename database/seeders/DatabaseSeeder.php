<?php

namespace Database\Seeders;

use App\Models\Property;
use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        Property::factory(5)->create();

        User::factory(5)->create([
            'name' => 'Christian Gerard Delos Reyes',
            'email' => 'christiangerarddelosreyes@gmail.com',
            'password' => bcrypt('password'),
        ]);
    }
}
