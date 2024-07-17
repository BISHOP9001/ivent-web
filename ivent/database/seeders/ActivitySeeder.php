<?php

namespace Database\Seeders;

use Carbon\Carbon;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ActivitySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('activities')->insert([
            [
                'event_id' => 1, // Ensure this matches a valid event ID
                'name' => 'Opening Ceremony',
                'description' => 'Kickoff the conference with keynote speeches.',
                'start_time' => Carbon::parse('2024-03-01 09:00:00'), // Adjusted for timestamp
                'end_time' => Carbon::parse('2024-03-01 10:00:00'), // Adjusted for timestamp
            ],
            // You can add more activities with similar timestamp formatting
            [
                'event_id' => 1, // This should match the event ID
                'name' => 'Panel Discussion',
                'description' => 'Experts discuss the future of technology.',
                'start_time' => Carbon::parse('2024-03-01 11:00:00'), // Adjusted for timestamp
                'end_time' => Carbon::parse('2024-03-01 12:30:00'), // Adjusted for timestamp
            ],
            // Continue adding more activities as needed...
        ]);
    }
}
