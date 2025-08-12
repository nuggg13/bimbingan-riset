<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\Admin;

class AdminSeeder extends Seeder
{
    public function run(): void
    {
        Admin::create([
            'nama' => 'Administrator',
            'email' => 'admin@bimbinganriset.com',
            'password' => Hash::make('admin123'),
            'nomor_wa' => '081234567890',
        ]);

        Admin::create([
            'nama' => 'Super Admin',
            'email' => 'superadmin@bimbinganriset.com',
            'password' => Hash::make('superadmin123'),
            'nomor_wa' => '081234567891',
        ]);
    }
}
