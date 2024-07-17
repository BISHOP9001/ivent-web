<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\EventSettings;

class EventSettingsSeeder extends Seeder
{
    public function run()
    {
        EventSettings::create(['event_id' => 1, 'setting_name' => 'max_participants', 'setting_value' => '500']);
        EventSettings::create(['event_id' => 1, 'setting_name' => 'location', 'setting_value' => 'Conference Hall A']);
    }
}
