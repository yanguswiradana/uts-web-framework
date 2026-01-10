<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class AdminSeeder extends Seeder
{
    public function run(): void
    {
        User::create([
            'name' => 'Administrator',
            'email' => 'admin@gmail.com', // Email login admin
            'password' => Hash::make('password123'), // Password admin
            'role' => 'admin', // Penting: set role jadi admin
        ]);
    }
}