<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
public function run()
{
    $user = User::firstOrCreate(
        ['email' => 'admin@gmail.com'],
        [
            'name' => 'Super Admin',
            'password' => Hash::make('password')
        ]
    );

    // Admin role assign
    $user->assignRole('Super Admin');
}
}
