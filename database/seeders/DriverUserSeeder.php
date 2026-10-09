<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DriverUserSeeder extends Seeder
{
    public function run(): void
    {
        User::updateOrCreate(
            [
                'email' => 'driver@foodiehub.com',
            ],
            [
                'name' => 'FoodieHub Driver',
                'password' => Hash::make('driver12345'),
                'role' => 'driver',
            ]
        );
    }
}