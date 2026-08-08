<?php

namespace Database\Seeders;

use App\Models\Permission;
use App\Models\Role;
use Illuminate\Database\Seeder;

class RoleSeeder extends Seeder
{
    public function run(): void
    {
        $roles = [
            'Admin',
            'Manager',
            'Moderator',
            'Staff',
        ];

        foreach ($roles as $name) {
            $role = Role::updateOrCreate(['name' => $name]);

            // Attach all permissions to the Admin role
            if (strcasecmp($role->name, 'admin') === 0) {
                $permissionIds = Permission::query()->pluck('id')->all();

                if (!empty($permissionIds)) {
                    $role->permissions()->sync($permissionIds);
                }
            }
        }
    }
}
