<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class SuperAdminSeeder extends Seeder
{
    public function run()
    {
        DB::table('admins')->insert([
            'name' => 'Super Admin',
            'email' => 'superadmin@example.com',
            'phone' => '0976122003',
            'role' => 'super_admin',
            'status' => 1,
            'email_verified_at' => now(),
            'password' => Hash::make('giang6122003'), // thay đổi mật khẩu nếu cần
            'remember_token' => Str::random(10),
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }
}
