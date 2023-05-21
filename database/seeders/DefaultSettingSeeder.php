<?php

namespace Database\Seeders;

use App\Models\DefaultSetting;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DefaultSettingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DefaultSetting::create([
            'en' => [
                'app_name' => 'Spy News',
                'support_phone' => '01878136530',
                'support_email' => 'info@email.com',
                'address' => 'Dhaka, Bangladesh',
            ],
            'bn' => [
                'app_name' => 'স্পাই নিউজ',
                'support_phone' => '01878136530',
                'support_email' => 'info@email.com',
                'address' => 'ঢাকা, বাংলাদেশ',
            ],
            'app_url' => 'http://127.0.0.1:8000',
            'time_zone' => 'UTC',
            'favicon' => 'default_favicon.png',
            'logo_photo' => 'default_logo_photo.png',
            'created_by' => 1,
        ]);
    }
}
