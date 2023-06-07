<?php

namespace Database\Seeders;

use App\Models\Mail_setting;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class MailSettingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Mail_setting::create([
            'mailer' => 'smtp',
            'host' => 'host',
            'port' => 'port',
            'username' => 'username',
            'password' => 'password',
            'encryption' => 'tls',
            'from_address' => 'info@gmail.com',
            'created_by' => 1,
        ]);
    }
}
