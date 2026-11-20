<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // Hapus user lama dulu (opsional)
        User::where('email', 'budi@mail.test')->orWhere('username', 'budi')->delete();

        // Buat user yang bisa login
        User::create([
            'name'     => 'Budi',
            'username' => 'budi',                    // ← ini yang dipakai untuk login
            'email'    => 'budi@mail.test',
            'password' => Hash::make('password'),    // password: password
        ]);

        // Kalau mau user lain juga:
        User::create([
            'name'     => 'Arianto',
            'username' => 'arianto',
            'email'    => 'test@example.com',
            'password' => Hash::make('password'),
        ]);
    }
}