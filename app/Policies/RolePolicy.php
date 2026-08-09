<?php

namespace App\Policies;

use App\Models\Role;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class RolePolicy
{
    use HandlesAuthorization;

    public function update(User $user, Role $role): bool
    {
        // Prevent editing the primary Admin role
        if (strcasecmp($role->name, 'admin') === 0) {
            return false;
        }

        return $user->hasPermission('roles.edit');
    }

    public function delete(User $user, Role $role): bool
    {
        // Prevent deleting the primary Admin role
        if (strcasecmp($role->name, 'admin') === 0) {
            return false;
        }

        return $user->hasPermission('roles.delete');
    }
}
