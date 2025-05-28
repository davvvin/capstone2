<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Role; // Import model Role

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Role::firstOrCreate(['slug' => 'administrator', 'name' => 'Administrator']);
        Role::firstOrCreate(['slug' => 'member', 'name' => 'Member']);
        Role::firstOrCreate(['slug' => 'tim-keuangan', 'name' => 'Tim Keuangan']);
        Role::firstOrCreate(['slug' => 'panitia', 'name' => 'Panitia Pelaksana Kegiatan']);
        // Tambahkan peran 'guest' jika diperlukan, meskipun guest biasanya tidak memiliki record di tabel roles
        // Guest adalah pengguna yang belum terautentikasi.
    }
}