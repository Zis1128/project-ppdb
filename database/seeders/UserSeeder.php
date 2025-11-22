<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        // Create Admin User
        $admin = User::create([
            'name' => 'Administrator',
            'email' => 'admin@ppdb.smk',
            'username' => 'admin',
            'password' => Hash::make('password'),
            'no_hp' => '081234567890',
            'is_active' => true,
        ]);
        $admin->assignRole('admin');

        // Create Panitia User
        $panitia = User::create([
            'name' => 'Panitia PPDB',
            'email' => 'panitia@ppdb.smk',
            'username' => 'panitia',
            'password' => Hash::make('password'),
            'no_hp' => '081234567891',
            'is_active' => true,
        ]);
        $panitia->assignRole('panitia');

        // Create Demo User (Calon Siswa)
        $user = User::create([
            'name' => 'Calon Siswa Demo',
            'email' => 'siswa@demo.com',
            'username' => 'siswa',
            'password' => Hash::make('password'),
            'no_hp' => '081234567892',
            'is_active' => true,
        ]);
        $user->assignRole('user');
    }
}