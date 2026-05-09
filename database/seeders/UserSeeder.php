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
            'name' => 'Administrator',
            'email' => 'admin@toko-muna.test',
            'password' => \Illuminate\Support\Facades\Hash::make('password'),
            'role' => 'admin',
        ]);

        \App\Models\User::create([
            'name' => 'Kasir 1',
            'email' => 'kasir@toko-muna.test',
            'password' => \Illuminate\Support\Facades\Hash::make('password'),
            'role' => 'kasir',
        ]);
    }
}
