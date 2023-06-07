<?php

namespace Database\Seeders;

use App\Models\Social_login_setting;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SocialLoginSettingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Social_login_setting::create([
            'google_auth_status' => 'No',
            'google_client_id' => 'google_client_id',
            'google_client_secret' => 'google_client_secret',
            'facebook_auth_status' => 'No',
            'facebook_client_id' => 'facebook_client_id',
            'facebook_client_secret' => 'facebook_client_secret',
            'created_by' => 1,
        ]);
    }
}
