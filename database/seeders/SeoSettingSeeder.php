<?php

namespace Database\Seeders;

use App\Models\Seo_setting;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SeoSettingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Seo_setting::create([
            'title' => 'Spy News',
            'keywords' => 'news, blog, khobor',
            'author' => 'Md Sabbir Ahammed',
            'description' => 'Neque porro quisquam est qui dolorem ipsum quia dolor sit amet, consectetur, adipisci velit...',
            'seo_image' => NULL,
            'created_by' => 1,
        ]);
    }
}
