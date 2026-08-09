<?php

namespace App\Policies;

use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class OptionPolicy
{
    use HandlesAuthorization;

    public function viewAny(User $user): bool
    {
        return $user->hasPermission('settings.view');
    }

    public function update(User $user): bool
    {
        return $user->hasPermission('settings.edit');
    }
}
