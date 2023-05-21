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
            'host' => 'sandbox.smtp.mailtrap.io',
            'port' => '2525',
            'username' => '071aa50653a80d',
            'password' => '8dd8b67f9819e0',
            'encryption' => 'tls',
            'from_address' => 'info@gmail.com',
            'created_by' => 1,
        ]);
    }
}
