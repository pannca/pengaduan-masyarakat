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
    public function run(): void
    {
        User::create([
            'role' => 'HEAD_STAFF',
            'password' => Hash::make('hstaff123'),
            'email' => 'hstaff@gmail.com',
        ]);

        User::create([
            'role' => 'STAFF',
            'password' => Hash::make('staff123'),
            'email' => 'staff@gmail.com',
        ]);

        User::create([
            'role' => 'GUEST',
            'password' => Hash::make('guest123'),
            'email' => 'guest@gmail.com',
        ]);
    }
}
