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
            'google_client_id' => '94152419762-kot722ibqmsiodh3l38dajmut3e2ot5o.apps.googleusercontent.com',
            'google_client_secret' => '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',
            'facebook_auth_status' => 'No',
            'facebook_client_id' => '3531091607174199',
            'facebook_client_secret' => '4e3359ed937b50ac9598f8b0fdd001d5',
            'created_by' => 1,
        ]);
    }
}
