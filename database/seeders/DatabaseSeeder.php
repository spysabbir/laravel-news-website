<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call([
            CountrySeeder::class,
            DivisionSeeder::class,
            DistrictSeeder::class,
            UpazilaSeeder::class,
            UnionSeeder::class,
            MailSettingSeeder::class,
            SeoSettingSeeder::class,
            DefaultSettingSeeder::class,
            SocialLoginSettingSeeder::class,
            UserSeeder::class,
        ]);
    }
}
