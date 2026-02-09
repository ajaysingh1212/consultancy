<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RolePermissionSeeder extends Seeder
{
    public function run(): void
    {
        /*
        |--------------------------------------------------------------------------
        | Define Permissions
        |--------------------------------------------------------------------------
        */
        $permissions = [
            // Users
            'user.view',
            'user.create',
            'user.edit',
            'user.delete',

            // Roles
            'role.view',
            'role.create',
            'role.edit',
            'role.delete',

            // Permissions
            'permission.view',
            'permission.create',
            'permission.edit',
            'permission.delete',
        ];

        foreach ($permissions as $permission) {
            Permission::firstOrCreate([
                'name' => $permission,
                'guard_name' => 'web',
            ]);
        }

        /*
        |--------------------------------------------------------------------------
        | Define Roles
        |--------------------------------------------------------------------------
        */

        // Super Admin (ALL ACCESS)
        $superAdmin = Role::firstOrCreate([
            'name' => 'Super Admin',
            'guard_name' => 'web',
        ]);

        // Admin
        $admin = Role::firstOrCreate([
            'name' => 'Admin',
            'guard_name' => 'web',
        ]);

        // Editor
        $editor = Role::firstOrCreate([
            'name' => 'Editor',
            'guard_name' => 'web',
        ]);

        /*
        |--------------------------------------------------------------------------
        | Assign Permissions to Roles
        |--------------------------------------------------------------------------
        */

        // Super Admin → ALL permissions
        $superAdmin->syncPermissions(Permission::all());

        // Admin → User + Role management
        $admin->syncPermissions([
            'user.view',
            'user.create',
            'user.edit',
            'user.delete',
            'role.view',
            'role.create',
            'role.edit',
            'role.delete',
        ]);

        // Editor → Limited access
        $editor->syncPermissions([
            'user.view',
            'user.edit',
        ]);

        /*
        |--------------------------------------------------------------------------
        | Assign Super Admin Role to First User
        |--------------------------------------------------------------------------
        */
        $user = User::first(); // usually ID = 1

        if ($user) {
            $user->syncRoles(['Super Admin']);
        }
    }
}
