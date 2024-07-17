<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class LocationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('locations')->insert([
            ['address' => '123 Main St', 'city' => 'Casablanca', 'country' => 'Morocco', 'coordinates' => '33.5731104,-7.5898434'],
            ['address' => '456 Secondary St', 'city' => 'Rabat', 'country' => 'Morocco', 'coordinates' => '34.020882,-6.841650'],
        ]);
    }
}
