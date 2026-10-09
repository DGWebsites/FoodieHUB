<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminUserSeeder extends Seeder
{
    public function run(): void
    {
        User::updateOrCreate(
            [
                'email' => 'admin@foodiehub.com',
            ],
            [
                'name' => 'FoodieHub Admin',
                'password' => Hash::make('admin12345'),
                'role' => 'admin',
            ]
        );
    }
}