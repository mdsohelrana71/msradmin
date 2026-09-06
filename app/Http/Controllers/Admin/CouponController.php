<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\CouponRequest;
use App\Models\Coupon;
use App\Services\Admin\CouponService;
use Illuminate\Http\Request;

class CouponController extends Controller
{
    public function __construct(protected CouponService $couponService)
    {
    }

    public function index(Request $request)
    {
        $coupons = $this->couponService->getCoupons($request);

        if ($request->ajax()) {
            return response()->json([
                'html' => view('admin.Coupons.partials.table', compact('coupons'))->render(),
            ]);
        }

        return view('admin.Coupons.index', compact('coupons'));
    }

    public function create()
    {
        return view('admin.Coupons.create');
    }

    public function store(CouponRequest $request)
    {
        $this->couponService->createCoupon($request->validated());

        return redirect()
            ->route('admin.coupons.index')
            ->with('success', 'Coupon created successfully.');
    }

    public function show(Coupon $coupon)
    {
        $coupon = $this->couponService->getCoupon($coupon);

        return view('admin.Coupons.show', compact('coupon'));
    }

    public function edit(Coupon $coupon)
    {
        return view('admin.Coupons.edit', compact('coupon'));
    }

    public function update(CouponRequest $request, Coupon $coupon)
    {
        $this->couponService->updateCoupon($coupon, $request->validated());

        return redirect()
            ->route('admin.coupons.index')
            ->with('success', 'Coupon updated successfully.');
    }

    public function destroy(Coupon $coupon)
    {
        $this->couponService->deleteCoupon($coupon);

        return redirect()
            ->route('admin.coupons.index')
            ->with('success', 'Coupon deleted successfully.');
    }

    public function toggleStatus(Coupon $coupon)
    {
        $this->couponService->toggleStatus($coupon);

        return back()->with('success', 'Coupon status updated successfully.');
    }
}