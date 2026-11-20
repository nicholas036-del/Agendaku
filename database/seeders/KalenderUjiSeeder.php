<?php

namespace Database\Seeders;

use App\Models\SchoolEvent;
use App\Models\Task;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class KalenderUjiSeeder extends Seeder
{
    public function run(): void
    {
        // User untuk login (username: admin / password: password123)
        $admin = User::updateOrCreate(
            ['username' => 'admin'],
            [
                'name'     => 'Admin Agendaku',
                'email'    => 'admin@agendaku.test',
                'password' => Hash::make('password123'),
                'role'     => 'admin',
            ]
        );

        // Data uji tugas (forceCreate = abaikan $fillable).
        // Kalau tabel tasks punya kolom wajib lain (misal user_id), tambahkan di sini.
        Task::forceCreate(['title' => 'Tugas Matematika', 'deadline' => '2026-11-20', 'user_id' => $admin->id]);
        Task::forceCreate(['title' => 'Laporan Fisika',   'deadline' => '2026-11-25', 'user_id' => $admin->id]);

        // Data uji acara
        SchoolEvent::forceCreate(['title' => 'Rapat OSIS',     'event_date' => '2026-11-20', 'user_id' => $admin->id]);
        SchoolEvent::forceCreate(['title' => 'Class Meeting',  'event_date' => '2026-11-28', 'user_id' => $admin->id]);
    }
}