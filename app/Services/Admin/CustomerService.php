<?php

namespace App\Services\Admin;

use App\Models\User;
use Illuminate\Pagination\LengthAwarePaginator;

class CustomerService
{
    public function getCustomers(
        ?string $search = null,
        ?string $sort = null,
        int $perPage = 20
    ): LengthAwarePaginator {
        return User::query()
            ->whereNull('role_id')
            ->withCount([
                'orders',
                'wishlists',
                'compares',
                'reviews',
            ])
            ->when($search, function ($query) use ($search) {
                $query->where(function ($query) use ($search) {
                    $query
                        ->where('name', 'like', "%{$search}%")
                        ->orWhere('email', 'like', "%{$search}%");
                });
            })
            ->when($sort, function ($query) use ($sort) {
                match ($sort) {
                    'oldest' => $query->oldest('created_at'),
                    'name_asc' => $query->orderBy('name'),
                    'name_desc' => $query->orderByDesc('name'),
                    'active' => $query->where('is_active', true)->latest('created_at'),
                    'inactive' => $query->where('is_active', false)->latest('created_at'),
                    default => $query->latest('created_at'),
                };
            }, function ($query) {
                $query->latest('created_at');
            })
            ->paginate($perPage)
            ->withQueryString();
    }

    public function getCustomer(User $customer): User
    {
        $customer = User::query()
            ->whereNull('role_id')
            ->findOrFail($customer->id);

        return $customer->load([
            'orders' => function ($query) {
                $query->latest('created_at');
            },
            'wishlists.product',
            'compares.product',
            'reviews.product',
        ]);
    }

    public function updateStatus(
        User $customer,
        bool $isActive
    ): User {
        $customer = User::query()
            ->whereNull('role_id')
            ->findOrFail($customer->id);

        $customer->update([
            'is_active' => $isActive,
        ]);

        return $customer->fresh();
    }
}