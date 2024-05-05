<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::create([
            'name' => '管理者',
            'email' => 'manage@example.com',
            'password' => Hash::make('password123'), 
            'auth' => 'manage',
            'email_verified_at' => '2024-05-05 20:32:22'
        ]);

        User::create([
            'name' => '一般ユーザー',
            'email' => 'common@example.com',
            'password' => Hash::make('password123'), 
            'auth' => 'common',
            'email_verified_at' => '2024-05-05 20:32:22'
        ]);
    }
}
