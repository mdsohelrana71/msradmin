<?php

namespace App\Services\Admin;

use App\Models\Blog;
use App\Models\Order;
use App\Models\Product;
use App\Models\User;

class DashboardService
{
    public function getStats(): array
    {
        return [
            'products' => Product::count(),
            'blogs' => Blog::count(),
            'customers' => User::whereNull('role_id')->count(),
            'orders' => Order::count(),
        ];
    }
}