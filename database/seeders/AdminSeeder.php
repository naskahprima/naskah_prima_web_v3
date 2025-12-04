<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;

class AdminSeeder extends Seeder
{
    public function run(): void
    {
        // Disable foreign key checks
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        User::truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        // Buat admin utama
        User::create([
            'name' => 'Admin Naskah Prima',
            'email' => 'admin@naskahprima.com',
            'password' => Hash::make('admin@naskahprima.com'),
            'email_verified_at' => now(),
        ]);
    }
}