<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RolesAndPermissionsSeeder extends Seeder
{
    public function run()
    {
        // Reset cached roles and permissions
        app()['cache']->forget('spatie.permission.cache');

        // Optional: Clear the existing roles and permissions to avoid duplicates
        Permission::query()->delete();
        Role::query()->delete();

        // Create permissions
        $permissions = [
            'create event',
            'edit event',
            'delete event',
            'view event',
            'publish event',
            'unpublish event'
        ];

        foreach ($permissions as $permission) {
            Permission::create(['name' => $permission]);
        }

        // Create roles and assign created permissions

        // Admin role
        $admin = Role::create(['name' => 'admin']);
        $admin->givePermissionTo(Permission::all()); // Grant all permissions to admin

        // Moderator role
        $moderator = Role::create(['name' => 'moderator']);
        $moderator->givePermissionTo(['create event', 'edit event', 'delete event', 'view event']);

        // Participant role
        $participant = Role::create(['name' => 'participant']);
        $participant->givePermissionTo(['view event']);
    }
}
