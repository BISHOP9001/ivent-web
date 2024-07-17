<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\SettingsItems;

class GlobalSettingsSeeder extends Seeder
{
    public function run()
    {
        SettingsItems::create(['name' => 'site_name', 'value' => 'Ivent']);
        SettingsItems::create(['name' => 'site_email', 'value' => 'info@ivent.com']);
    }
}
