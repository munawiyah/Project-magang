<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // 1. Superadmin
        User::updateOrCreate(
            ['email' => 'superadmin@tangerangkab.go.id'],
            [
                'name' => 'Super Administrator Diskominfo',
                'password' => Hash::make('password123'),
                'role' => 'superadmin',
                'phone' => '081234567890',
                'is_active' => true,
            ]
        );

        // 2. Admin Sistem (CMS / Content Manager)
        User::updateOrCreate(
            ['email' => 'cms@tangerangkab.go.id'],
            [
                'name' => 'Admin Sistem (Content Lead)',
                'password' => Hash::make('password123'),
                'role' => 'admin_sistem',
                'phone' => '081234567891',
                'is_active' => true,
            ]
        );

        // 3. Admin Data (School Data Operator)
        User::updateOrCreate(
            ['email' => 'operator@tangerangkab.go.id'],
            [
                'name' => 'Admin Data (Operator Sekolah)',
                'password' => Hash::make('password123'),
                'role' => 'admin_data',
                'phone' => '081234567892',
                'is_active' => true,
            ]
        );
    }
}

