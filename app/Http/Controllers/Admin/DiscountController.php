<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\DiscountRequest;
use App\Models\Discount;
use App\Services\Admin\DiscountService;
use Illuminate\Http\Request;

class DiscountController extends Controller
{
    public function __construct(protected DiscountService $discountService)
    {
    }

    public function index(Request $request)
    {
        $discounts = $this->discountService->getDiscounts($request);

        if ($request->ajax()) {
            return response()->json([
                'html' => view('admin.Discounts.partials.table', compact('discounts'))->render(),
            ]);
        }

        return view('admin.Discounts.index', compact('discounts'));
    }

    public function create()
    {
        return view('admin.Discounts.create', $this->discountService->getFormData());
    }

    public function store(DiscountRequest $request)
    {
        $this->discountService->createDiscount($request->validated());
        return redirect()->route('admin.discounts.index')->with('success', 'Discount created successfully.');
    }

    public function show(Discount $discount)
    {
        $discount = $this->discountService->getDiscount($discount);
        return view('admin.Discounts.show', compact('discount'));
    }

    public function edit(Discount $discount)
    {
        return view('admin.Discounts.edit', $this->discountService->getFormData($discount));
    }

    public function update(DiscountRequest $request, Discount $discount)
    {
        $this->discountService->updateDiscount($discount, $request->validated());
        return redirect()->route('admin.discounts.index')->with('success', 'Discount updated successfully.');
    }

    public function destroy(Discount $discount)
    {
        $this->discountService->deleteDiscount($discount);
        return redirect()->route('admin.discounts.index')->with('success', 'Discount deleted successfully.');
    }

    public function toggleStatus(Discount $discount)
    {
        $this->discountService->toggleStatus($discount);
        return back()->with('success', 'Discount status updated successfully.');
    }
}