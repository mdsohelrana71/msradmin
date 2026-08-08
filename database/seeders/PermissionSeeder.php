<?php

namespace Database\Seeders;

use App\Models\Permission;
use Illuminate\Database\Seeder;

class PermissionSeeder extends Seeder
{
    public function run(): void
    {
        $permissions = collect(config('permissions'))
            ->flatMap(fn ($module) => collect($module['permissions'])->map(fn ($label, $name) => [
                'name' => $name,
                'label' => $label,
                'group' => $module['label'] ?? 'General',
            ]));

        foreach ($permissions as $permission) {
            Permission::updateOrCreate(
                ['name' => $permission['name']],
                ['label' => $permission['label'], 'group' => $permission['group']]
            );
        }
    }
}
