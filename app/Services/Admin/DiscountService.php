<?php

namespace App\Services\Admin;

use App\Models\Category;
use App\Models\Discount;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DiscountService
{
    public function getDiscounts(Request $request)
    {
        $query = Discount::query()->withCount(['products', 'categories']);

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where('name', 'like', "%{$search}%");
        }

        if ($request->filled('sort')) {
            match ($request->sort) {
                'oldest' => $query->oldest(),
                'active' => $query->where('status', true)->latest(),
                'inactive' => $query->where('status', false)->latest(),
                default => $query->latest(),
            };
        } else {
            $query->latest();
        }

        return $query->paginate(15)->withQueryString();
    }

    public function getDiscount(Discount $discount): Discount
    {
        return $discount->load([
            'products',
            'categories',
        ]);
    }

    public function getFormData(?Discount $discount = null): array
    {
        $products = Product::where('status', true)
            ->orderBy('name')
            ->get(['id', 'name']);

        $categories = Category::where('type', 'product')
            ->where('status', true)
            ->orderBy('name')
            ->get(['id', 'name']);

        $selectedProducts = [];
        $selectedCategories = [];

        if ($discount) {
            $selectedProducts = $discount->products()
                ->pluck('products.id')
                ->toArray();

            $selectedCategories = $discount->categories()
                ->pluck('categories.id')
                ->toArray();
        }

        return compact(
            'discount',
            'products',
            'categories',
            'selectedProducts',
            'selectedCategories'
        );
    }

    public function createDiscount(array $data): Discount
    {
        return DB::transaction(function () use ($data) {
            $discount = Discount::create([
                'name' => $data['name'],
                'type' => $data['type'],
                'value' => $data['value'],
                'minimum_order_amount' => $data['minimum_order_amount'] ?? 0,
                'maximum_discount' => $data['maximum_discount'] ?? null,
                'starts_at' => $data['starts_at'] ?? null,
                'ends_at' => $data['ends_at'] ?? null,
                'priority' => $data['priority'] ?? 0,
                'allow_coupon' => $data['allow_coupon'] ?? true,
                'status' => $data['status'],
            ]);

            $this->syncRelations($discount, $data);

            return $discount;
        });
    }

    public function updateDiscount(Discount $discount, array $data): Discount
    {
        return DB::transaction(function () use ($discount, $data) {
            $discount->update([
                'name' => $data['name'],
                'type' => $data['type'],
                'value' => $data['value'],
                'minimum_order_amount' => $data['minimum_order_amount'] ?? 0,
                'maximum_discount' => $data['maximum_discount'] ?? null,
                'starts_at' => $data['starts_at'] ?? null,
                'ends_at' => $data['ends_at'] ?? null,
                'priority' => $data['priority'] ?? 0,
                'allow_coupon' => $data['allow_coupon'] ?? true,
                'status' => $data['status'],
            ]);

            $this->syncRelations($discount, $data);

            return $discount;
        });
    }

    public function deleteDiscount(Discount $discount): bool
    {
        return $discount->delete();
    }

    public function toggleStatus(Discount $discount): bool
    {
        return $discount->update([
            'status' => !$discount->status,
        ]);
    }

    protected function syncRelations(Discount $discount, array $data): void
    {
        $discount->products()->sync($data['products'] ?? []);
        $discount->categories()->sync($data['categories'] ?? []);
    }

    public function getActiveDiscounts()
    {
        $now = now();

        return Discount::query()
            ->where('status', true)
            ->where(function ($query) use ($now) {
                $query->whereNull('starts_at')
                    ->orWhere('starts_at', '<=', $now);
            })
            ->where(function ($query) use ($now) {
                $query->whereNull('ends_at')
                    ->orWhere('ends_at', '>=', $now);
            })
            ->orderByDesc('priority')
            ->get();
    }

    public function getApplicableDiscount(Product $product): ?Discount
    {
        foreach ($this->getActiveDiscounts() as $discount) {
            if ($this->appliesToProduct($discount, $product)) {
                return $discount;
            }
        }

        return null;
    }

    public function appliesToProduct(Discount $discount, Product $product): bool
    {
        $hasProducts = $discount->products()->exists();
        $hasCategories = $discount->categories()->exists();

        if (!$hasProducts && !$hasCategories) {
            return true;
        }

        if ($hasProducts && $discount->products()->where('products.id', $product->id)->exists()) {
            return true;
        }

        if (
            $hasCategories &&
            $product->category_id &&
            $discount->categories()
                ->where('categories.id', $product->category_id)
                ->where('categories.type', 'product')
                ->exists()
        ) {
            return true;
        }

        return false;
    }

    public function calculateDiscount(float $amount, Discount $discount): float
    {
        if ($amount < (float) $discount->minimum_order_amount) {
            return 0;
        }

        if ($discount->type === 'percentage') {
            $discountAmount = $amount * ((float) $discount->value / 100);
        } else {
            $discountAmount = (float) $discount->value;
        }

        if ($discount->maximum_discount !== null) {
            $discountAmount = min(
                $discountAmount,
                (float) $discount->maximum_discount
            );
        }

        return min($discountAmount, $amount);
    }

    public function getDiscountedPrice(float $amount, Discount $discount): float
    {
        return max(
            0,
            $amount - $this->calculateDiscount($amount, $discount)
        );
    }
}