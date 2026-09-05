<?php

namespace App\Services\Admin;

use App\Models\User;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

class UserService
{
    public function paginate(array $filters = [])
    {
        $query = User::query()->whereNotNull('role_id');

        if (!empty($filters['search'])) {
            $search = $filters['search'];

            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                    ->orWhere('email', 'like', "%{$search}%")
                    ->orWhere('phone', 'like', "%{$search}%");
            });
        }

        if (!empty($filters['role_id'])) {
            $query->where('role_id', $filters['role_id']);
        }

        if (isset($filters['status']) && $filters['status'] !== '') {
            $query->where('is_active', $filters['status'] === 'active');
        }

        if (! empty($filters['sort'])) {
            switch ($filters['sort']) {
                case 'name_asc':
                    $query->orderBy('name', 'asc');
                    break;
                case 'name_desc':
                    $query->orderBy('name', 'desc');
                    break;
                case 'oldest':
                    $query->oldest('created_at');
                    break;
                default:
                    $query->latest('created_at');
                    break;
            }
        } else {
            $query->latest('created_at');
        }

        $perPage = (int) ($filters['per_page'] ?? 10);

        return $query
            ->paginate($perPage)
            ->withQueryString();
    }

    public function create(array $data): User
    {
        $data = $this->processAvatar($data);

        return User::create($data);
    }

    public function update(User $user, array $data): User
    {
        $data = $this->processAvatar($data, $user);

        $user->update($data);

        return $user;
    }

    protected function processAvatar(array $data, ?User $user = null): array
    {
        if (! empty($data['avatar']) && $data['avatar'] instanceof UploadedFile) {
            if ($user && $user->avatar) {
                Storage::disk('public')->delete($user->avatar);
            }

            $data['avatar'] = $data['avatar']->store('avatars', 'public');
        } else {
            unset($data['avatar']);
        }

        return $data;
    }

    public function delete(User $user): void
    {
        $user->delete();
    }
}
