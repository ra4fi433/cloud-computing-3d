<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;

class SpatieSeeder extends Seeder
{
    public function run(): void
    {
        // Buat role jika belum ada
        $roles = ['superadmin', 'admin', 'user', 'Kadis', 'kabid', 'kasubag', 'bendahara', 'sekretaris'];
        foreach ($roles as $value) {
            Role::firstOrCreate(['name' => $value]);
        }

        // Buat user superadmin kalau belum ada
        $user1 = User::firstOrCreate(
            ['email' => 'admin1@admin.admin'],
            [
                'name' => 'Super Admin 1',
                'password' => Hash::make('4dmin@3374'), // Ganti saat produksi
            ]
        );

        // User kedua
        $user2 = User::firstOrCreate(
            ['email' => 'admin2@admin.admin'],
            [
                'name' => 'Super Admin 2',
                'password' => Hash::make('Password@3374'), // Ganti saat produksi
            ]
        );

        $user3 = User::firstOrCreate(
            ['email' => 'admin01@admin.admin'],
            [
                'name' => 'Staff 1',
                'password' => Hash::make(''), // Ganti saat produksi
            ]
        );

        $user4 = User::firstOrCreate(
            ['email' => 'kabid1@admin.admin'],
            [
                'name' => 'Ka-Bidang-1',
                'password' => Hash::make('password123'), // Ganti saat produksi
            ]
        );

        // Beri role superadmin ke user ini
        $user1->assignRole('superadmin');
        $user2->assignRole('superadmin');
        $user3->assignRole('admin');
        $user4->assignRole('kabid');
    }
}
