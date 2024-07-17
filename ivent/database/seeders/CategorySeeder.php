<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('categories')->insert([
            ['name' => 'Professional', 'description' => 'Events related to business and professional networking.'],
            ['name' => 'Cultural', 'description' => 'Cultural events such as arts, music, and history.'],
            // Add more categories as needed...
        ]);
    }
}
