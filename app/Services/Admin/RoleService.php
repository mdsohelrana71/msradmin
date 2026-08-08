<?php

namespace App\Services\Admin;

use App\Models\Role;

class RoleService
{
    public function paginate(array $filters = [])
    {
        $query = Role::query();

        if (!empty($filters['search'])) {
            $search = $filters['search'];

            $query->where('name', 'like', "%{$search}%");
        }

        $perPage = (int) ($filters['per_page'] ?? 10);

        return $query
            ->latest('created_at')
            ->paginate($perPage)
            ->withQueryString();
    }

    public function create(array $data): Role
    {
        $permissions = $data['permission_ids'] ?? [];
        unset($data['permission_ids']);

        $role = Role::create($data);
        $role->permissions()->sync($permissions);

        return $role;
    }

    public function update(Role $role, array $data): Role
    {
        $permissions = $data['permission_ids'] ?? [];
        unset($data['permission_ids']);

        $role->update($data);
        $role->permissions()->sync($permissions);

        return $role;
    }

    public function delete(Role $role): void
    {
        $role->permissions()->detach();
        $role->delete();
    }
}
