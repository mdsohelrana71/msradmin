<?php

namespace App\Services\Admin;

use App\Models\Order;
use App\Models\OrderStatusHistory;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

class OrderService
{
    public function getOrders(
        ?string $search = null,
        ?string $sort = null,
        int $perPage = 20
    ): LengthAwarePaginator {
        return Order::query()
            ->with([
                'user:id,name,email',
                'items:id,order_id,product_id,product_variant_id,product_name,product_sku,variant_name,variant_sku,unit_price,quantity,discount,total',
            ])
            ->when($search, function ($query) use ($search) {
                $query->where(function ($query) use ($search) {
                    $query
                        ->where('order_number', 'like', "%{$search}%")
                        ->orWhereHas('user', function ($query) use ($search) {
                            $query
                                ->where('name', 'like', "%{$search}%")
                                ->orWhere('email', 'like', "%{$search}%");
                        });
                });
            })
            ->when($sort, function ($query) use ($sort) {
                match ($sort) {
                    'oldest' => $query->oldest('created_at'),
                    'total_high' => $query->orderByDesc('total'),
                    'total_low' => $query->orderBy('total'),
                    'pending' => $query
                        ->where('status', 'pending')
                        ->latest('created_at'),
                    'confirmed' => $query
                        ->where('status', 'confirmed')
                        ->latest('created_at'),
                    'processing' => $query
                        ->where('status', 'processing')
                        ->latest('created_at'),
                    'shipped' => $query
                        ->where('status', 'shipped')
                        ->latest('created_at'),
                    'delivered' => $query
                        ->where('status', 'delivered')
                        ->latest('created_at'),
                    'cancelled' => $query
                        ->where('status', 'cancelled')
                        ->latest('created_at'),
                    default => $query->latest('created_at'),
                };
            }, function ($query) {
                $query->latest('created_at');
            })
            ->paginate($perPage)
            ->withQueryString();
    }

    public function getOrder(Order $order): Order
    {
        return $order->load([
            'user',
            'items.product',
            'items.variant.values.attribute',
            'items.variant.values.attributeValue',
            'billingAddress',
            'shippingAddress',
            'statusHistories.creator',
        ]);
    }

    public function updateStatus(Order $order, string $status): Order
    {
        return DB::transaction(function () use ($order, $status) {
            $order->update([
                'status' => $status,
            ]);

            OrderStatusHistory::create([
                'order_id' => $order->id,
                'status' => $status,
                'created_by' => Auth::id(),
            ]);

            return $order->fresh();
        });
    }
}