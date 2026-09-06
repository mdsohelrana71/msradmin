<?php

namespace App\Services\Admin;

use App\Models\Coupon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CouponService
{
    public function getCoupons(Request $request)
    {
        $query = Coupon::query();

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where('code', 'like', "%{$search}%");
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

    public function getCoupon(Coupon $coupon): Coupon
    {
        return $coupon;
    }

    public function createCoupon(array $data): Coupon
    {
        return DB::transaction(function () use ($data) {
            return Coupon::create([
                'code' => strtoupper($data['code']),
                'type' => $data['type'],
                'value' => $data['value'],
                'minimum_order_amount' => $data['minimum_order_amount'] ?? 0,
                'maximum_discount' => $data['maximum_discount'] ?? null,
                'usage_limit' => $data['usage_limit'] ?? null,
                'usage_limit_per_customer' => $data['usage_limit_per_customer'] ?? null,
                'starts_at' => $data['starts_at'] ?? null,
                'ends_at' => $data['ends_at'] ?? null,
                'status' => $data['status'],
            ]);
        });
    }

    public function updateCoupon(Coupon $coupon, array $data): Coupon
    {
        return DB::transaction(function () use ($coupon, $data) {
            $coupon->update([
                'code' => strtoupper($data['code']),
                'type' => $data['type'],
                'value' => $data['value'],
                'minimum_order_amount' => $data['minimum_order_amount'] ?? 0,
                'maximum_discount' => $data['maximum_discount'] ?? null,
                'usage_limit' => $data['usage_limit'] ?? null,
                'usage_limit_per_customer' => $data['usage_limit_per_customer'] ?? null,
                'starts_at' => $data['starts_at'] ?? null,
                'ends_at' => $data['ends_at'] ?? null,
                'status' => $data['status'],
            ]);

            return $coupon;
        });
    }

    public function deleteCoupon(Coupon $coupon): bool
    {
        return $coupon->delete();
    }

    public function toggleStatus(Coupon $coupon): bool
    {
        return $coupon->update([
            'status' => !$coupon->status,
        ]);
    }

    public function getActiveCoupons()
    {
        $now = now();

        return Coupon::query()
            ->where('status', true)
            ->where(function ($query) use ($now) {
                $query->whereNull('starts_at')
                    ->orWhere('starts_at', '<=', $now);
            })
            ->where(function ($query) use ($now) {
                $query->whereNull('ends_at')
                    ->orWhere('ends_at', '>=', $now);
            })
            ->get();
    }

    public function findValidCoupon(string $code): ?Coupon
    {
        $now = now();

        return Coupon::query()
            ->where('code', strtoupper($code))
            ->where('status', true)
            ->where(function ($query) use ($now) {
                $query->whereNull('starts_at')
                    ->orWhere('starts_at', '<=', $now);
            })
            ->where(function ($query) use ($now) {
                $query->whereNull('ends_at')
                    ->orWhere('ends_at', '>=', $now);
            })
            ->first();
    }

    public function calculateDiscount(float $amount, Coupon $coupon): float
    {
        if ($amount < (float) $coupon->minimum_order_amount) {
            return 0;
        }

        if ($coupon->type === 'percentage') {
            $discountAmount = $amount * ((float) $coupon->value / 100);
        } else {
            $discountAmount = (float) $coupon->value;
        }

        if ($coupon->maximum_discount !== null) {
            $discountAmount = min(
                $discountAmount,
                (float) $coupon->maximum_discount
            );
        }

        return min($discountAmount, $amount);
    }

    public function getDiscountedPrice(float $amount, Coupon $coupon): float
    {
        return max(
            0,
            $amount - $this->calculateDiscount($amount, $coupon)
        );
    }
}