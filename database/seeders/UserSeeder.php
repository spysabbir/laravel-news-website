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
                'email' => 'superadmin@gmail.com',
                'password' => Hash::make('12345678'),
                'role' => 'Super Admin',
            ],
            // Admin
            [
                'name' => 'Admin',
                'email' => 'admin@gmail.com',
                'password' => Hash::make('12345678'),
                'role' => 'Admin',
            ],
            // Reporter
            [
                'name' => 'Reporter',
                'email' => 'reporter@email.com',
                'password' => Hash::make('12345678'),
                'role' => 'Reporter',
            ],
        ]);

        DB::table('users')->insert([
            // User
            [
                'name' => 'User 1',
                'email' => 'user@gmail.com',
                'password' => Hash::make('12345678'),
                'last_active' => Carbon::now(),
            ]
        ]);
    }
}
