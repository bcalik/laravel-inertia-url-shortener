<?php

namespace Database\Seeders;

use App\Models\Link;
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
        Link::factory()->create([
            'slug' => 'default',
            'app_url' => null,
            'ios_url' => null,
            'huawei_url' => null,
            'android_url' => null,
            'fallback_url' => url('/app'),
            'html' => 'Please wait...',
        ]);

        Link::factory()->create([
            'app_url' => 'alternatif://redirect/wallet?id=1',
            'ios_url' => 'https://apps.apple.com/tr/app/alternatif-app/id1553747714?mt=8',
            'huawei_url' => 'https://appgallery.huawei.com/app/C104766455',
            'android_url' => 'https://play.google.com/store/apps/details?id=app.alternatif',
            'fallback_url' => 'https://alternatif.app',
            'html' => 'Please wait...',
        ]);
    }
}
