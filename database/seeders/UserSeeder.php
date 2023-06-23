<?php

namespace Database\Seeders;

use Carbon\Carbon;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('admins')->insert([
            // Super Admin
            [
                'name' => 'Super Admin',
                'email' => 'superadmin@email.com',
                'password' => Hash::make('12345678'),
                'created_at' => Carbon::now(),
                'role' => 'Super Admin',
            ],
            // Admin
            [
                'name' => 'Admin',
                'email' => 'admin@email.com',
                'password' => Hash::make('12345678'),
                'created_at' => Carbon::now(),
                'role' => 'Admin',
            ],
            // Reporter
            [
                'name' => 'Reporter',
                'email' => 'reporter@email.com',
                'password' => Hash::make('12345678'),
                'created_at' => Carbon::now(),
                'role' => 'Reporter',
            ],
        ]);

        DB::table('users')->insert([
            // User
            [
                'name' => 'User 1',
                'email' => 'user@email.com',
                'password' => Hash::make('12345678'),
                'email_verified_at' => Carbon::now(),
                'created_at' => Carbon::now(),
                'last_active' => Carbon::now(),
            ]
        ]);
    }
}
