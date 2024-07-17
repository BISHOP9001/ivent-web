<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class EventSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('events')->insert([
            [
                'title' => 'Tech Conference',
                'description' => 'Annual tech conference in Casablanca.',
                'start_date' => '2024-03-01',
                'end_date' => '2024-03-03',
                'location_id' => 2,  // Ensure this matches a valid location ID from your locations table
                'category_id' => 2,  // Ensure this matches a valid category ID from your categories table
                'created_by_user_id' => 1,  // Ensure this matches a valid user ID
                'event_type' => 'public',
                'payment_required' => 'yes',
            ],
        ]);
    }
}
