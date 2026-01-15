<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        /* Menggunakan updateOrCreate agar aman.
           Artinya: 
           - Jika email admin@gmail.com SUDAH ADA -> update datanya (password/role).
           - Jika BELUM ADA -> buat baru.
           
           Ini mencegah error "Duplicate Entry" jika seeder dijalankan 2x.
        */
        User::updateOrCreate(
            ['email' => 'admin@gmail.com'], // 1. Cek berdasarkan email ini
            [
                'name' => 'Administrator',
                'password' => Hash::make('123'), // Password di-hash
                'role' => 'admin', // Pastikan kolom ini ada di database & fillable
                'email_verified_at' => now(), // Opsional: agar dianggap sudah verifikasi email
            ]
        );
    }
}