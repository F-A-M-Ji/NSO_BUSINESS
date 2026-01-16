<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        User::create([
            'username' => 'admin01',      // 7 หลักพอดี
            'password' => '12345678',     // ใส่รหัสปกติ Model จะ Hash ให้เองเพราะเราตั้ง cast ไว้
            'firstname' => 'Admin',
            'lastname' => 'System',
            'province_code' => '10',      // สมมติ กทม.
            'role' => 'ADMIN',
        ]);
    }
}