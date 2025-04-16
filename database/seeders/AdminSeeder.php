<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class AdminSeeder extends Seeder
{
    public function run(): void
    {
        User::updateOrCreate(
            ['email' => 'admin@mail.com'], // ganti kalau perlu
            [
                'nama' => 'Admin',
                'password' => Hash::make('admin123'), // otomatis hash
                'nomor_telepon' => '08123456789',
                'alamat' => 'Jl. Admin No.1',
                'role' => 'admin',
            ]
        );
    }
}
