<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Role;
use Illuminate\Support\Facades\Hash;

class AdminUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Cari peran Administrator
        $adminRole = Role::where('slug', 'administrator')->first();

        if ($adminRole) {
            User::firstOrCreate(
                ['email' => 'admin@example.com'], 
                [ // Data untuk dibuat jika tidak ditemukan
                    'name' => 'Admin User',
                    'password' => Hash::make('password'), 
                    'email_verified_at' => now(),
                    'is_active' => true,
                ]
            )->roles()->syncWithoutDetaching([$adminRole->id]); 
        } else {
            $this->command->error('Peran Administrator tidak ditemukan. Pastikan RoleSeeder sudah dijalankan.');
        }
    }
}