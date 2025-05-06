<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\Admin;

class AdminSeeder extends Seeder
{
    public function run()
    {
        // Dữ liệu mẫu cho Super Admin
        Admin::create([
            'name' => 'Super Admin',
            'email' => 'superadmin@example.com',
            'phone' => '1234567890',
            'role' => 'super_admin',
            'status' => 1,  // 1 là 'đang hoạt động'
            'email_verified_at' => now(),
            'password' => Hash::make('password123'),  // Mã hóa mật khẩu bằng bcrypt
            'remember_token' => null,
        ]);

        // Dữ liệu mẫu cho Admin
        Admin::create([
            'name' => 'Admin User',
            'email' => 'admin@example.com',
            'phone' => '0987654321',
            'role' => 'admin',
            'status' => 1,
            'email_verified_at' => now(),
            'password' => Hash::make('password123'),  // Mã hóa mật khẩu bằng bcrypt
            'remember_token' => null,
        ]);

        // Dữ liệu mẫu cho Support Staff
        Admin::create([
            'name' => 'Support Staff',
            'email' => 'support@example.com',
            'phone' => '1122334455',
            'role' => 'support_staff',
            'status' => 1,
            'email_verified_at' => now(),
            'password' => Hash::make('password123'),  // Mã hóa mật khẩu bằng bcrypt
            'remember_token' => null,
        ]);
    }
}
