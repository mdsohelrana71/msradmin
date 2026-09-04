<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Models\ProductCompare;
use App\Http\Controllers\Controller;
use App\Services\Admin\ProductCompareService;

class ProductCompareController extends Controller
{
    public function __construct(
        protected ProductCompareService $productCompareService
    ) {}

    public function index(Request $request)
    {
        $compares = $this->productCompareService->getCompares(
            $request->input('search'),
            $request->input('sort')
        );

        if ($request->ajax()) {
            $html = view(
                'admin.Product-compares.partials.table',
                compact('compares')
            )->render();

            return response()->json([
                'html' => $html,
            ]);
        }

        return view(
            'admin.Product-compares.index',
            compact('compares')
        );
    }

    public function show(ProductCompare $productCompare)
    {
        $compare = $this->productCompareService->getCompare(
            $productCompare
        );

        return view(
            'admin.Product-compares.show',
            compact('compare')
        );
    }

    public function destroy(ProductCompare $productCompare)
    {
        $this->productCompareService->delete(
            $productCompare
        );

        return redirect()
            ->route('admin.product-compares.index')
            ->with(
                'success',
                'Product compare deleted successfully.'
            );
    }
}