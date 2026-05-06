<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Models\StaffProvince;
use App\Models\StaffProvinces;

class StaffProvincesSeeder extends Seeder
{
    public function run()
    {
        // Contoh data untuk provinsi dan akun staff
        $provinces = ['Jawa Barat', 'Jawa Timur', 'Bali', 'Sumatera Utara', 'Sulawesi Selatan'];

        foreach ($provinces as $province) {
            // Buat User baru (akun staff)
            $user = User::create([
                'email' => strtolower(str_replace(' ', '.', $province)) . '@example.com',
                'password' => Hash::make('password123'),  // Gantilah dengan password yang lebih aman jika perlu
                'role' => 'STAFF',
            ]);

            // Simpan data provinsi ke tabel staff_provinces
            StaffProvinces::create([
                'user_id' => $user->id,
                'province' => $province,
            ]);
        }
    }
}
