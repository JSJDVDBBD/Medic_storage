<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run()
    {
        User::truncate();
        
        $users = [
            [
                'name' => 'Admin',
                'email' => 'admin@medicstorage.com',
                'password' => Hash::make('password'),
                'role' => 'admin',
                'telefono' => '1234567890',
            ],
            [
                'name' => 'Farmacéutico',
                'email' => 'farmacia@medicstorage.com',
                'password' => Hash::make('password'),
                'role' => 'farmacia',
                'telefono' => '0987654321',
            ],
            [
                'name' => 'Vendedor',
                'email' => 'vendedor@medicstorage.com',
                'password' => Hash::make('password'),
                'role' => 'vendedor',
                'telefono' => '5555555555',
            ],
        ];

        foreach ($users as $user) {
            User::create($user);
        }
    }
}
