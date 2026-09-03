<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Models\ProductInventory;
use App\Http\Controllers\Controller;
use App\Services\Admin\ProductInventoryService;

class ProductInventoryController extends Controller
{
    public function __construct(
        protected ProductInventoryService $productInventoryService
    ) {}

    public function index(Request $request)
    {
        $data = $this->productInventoryService->getInventories([
            'search' => $request->input('search'),
            'sort' => $request->input('sort'),
        ]);

        if ($request->ajax()) {
            $html = view(
                'admin.Product-inventory.partials.table',
                $data
            )->render();

            return response()->json([
                'html' => $html,
            ]);
        }

        return view(
            'admin.Product-inventory.index',
            $data
        );
    }

    public function show(ProductInventory $productInventory)
    {
        $data = $this->productInventoryService->getInventory(
            $productInventory
        );

        return view(
            'admin.Product-inventory.show',
            $data
        );
    }

    public function edit(ProductInventory $productInventory)
    {
        $data = $this->productInventoryService->getInventory(
            $productInventory
        );

        return view(
            'admin.Product-inventory.edit',
            $data
        );
    }

    public function update(
        Request $request,
        ProductInventory $productInventory
    ) {
        $validated = $request->validate([
            'stock' => [
                'required',
                'integer',
                'min:0',
            ],
            'low_stock_alert' => [
                'required',
                'integer',
                'min:0',
            ],
        ]);

        $this->productInventoryService->update(
            $productInventory,
            $validated
        );

        return redirect()
            ->route(
                'admin.product-inventory.index'
            )
            ->with(
                'success',
                'Product inventory updated successfully.'
            );
    }
}