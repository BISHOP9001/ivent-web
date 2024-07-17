<?php

namespace Database\Seeders;

use App\Models\User;
use Database\Seeders\RolesAndPermissionsSeeder as SeedersRolesAndPermissionsSeeder;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use RolesAndPermissionsSeeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();


        $this->call([
            AdminUserSeeder::class,
            LocationSeeder::class,
            CategorySeeder::class,
            EventSeeder::class,
            ActivitySeeder::class,
            GlobalSettingsSeeder::class,
            EventSettingsSeeder::class,
            FormFieldTemplateSeeder::class,
            FormFieldTemplateValueSeeder::class,
            SeedersRolesAndPermissionsSeeder::class,

        ]);
    }
}
