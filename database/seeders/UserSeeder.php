<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        \App\Models\User::create([
            'name' => 'Admin Toko',
            'email' => 'admin@tokomuna.com',
            'password' => \Illuminate\Support\Facades\Hash::make('admin123'),
            'role' => 'admin',
        ]);

        \App\Models\User::create([
            'name' => 'Kasir Toko',
            'email' => 'kasir@tokomuna.com',
            'password' => \Illuminate\Support\Facades\Hash::make('kasir123'),
            'role' => 'kasir',
        ]);
    }
}
