<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Hapus user lama kalau ada
        User::truncate();

        // Buat admin utama
        User::create([
            'name' => 'Admin Naskah Prima',
            'email' => '    ',
            'password' => Hash::make('admin@naskahprima.com'), // Password: admin123
            'email_verified_at' => now(),
        ]);
    }
}
