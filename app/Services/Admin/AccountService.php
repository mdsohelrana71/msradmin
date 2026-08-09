<?php

namespace App\Services\Admin;

use App\Models\User;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class AccountService
{
    public function getUserInfo(int $id): User
    {
        return User::with('assignedRole')->findOrFail($id);
    }

    public function updateUser(array $data): void
    {
        $user = User::findOrFail(Auth::user()->id);

        if (empty($data['password'])) {
            unset($data['password']);
        }

        if (! empty($data['avatar']) && $data['avatar'] instanceof UploadedFile) {
            if ($user->avatar && Storage::disk('public')->exists($user->avatar)) {
                Storage::disk('public')->delete($user->avatar);
            }

            $data['avatar'] = $data['avatar']->store('avatars', 'public');
        } else {
            unset($data['avatar']);
        }

        $user->update($data);
    }
}
