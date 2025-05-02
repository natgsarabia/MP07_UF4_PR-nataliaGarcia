<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        //Crear usuario admin
        User::create([
            'name' => 'administrador',
            'email' => 'nagasa@admin.com',
            'password' => Hash::make('admin1234'),
            'role' => 'administrador',
        ]);

        //Crear usuario normal
        User::create([
            'name' => 'usuari',
            'email' => 'nagasa@user.com',
            'password' => Hash::make('user1234'),
            'role' => 'usuari',
        ]);
    }
}
