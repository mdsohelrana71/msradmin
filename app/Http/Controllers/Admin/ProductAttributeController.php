<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\ProductAttributeRequest;
use App\Models\ProductAttribute;
use App\Services\Admin\ProductAttributeService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ProductAttributeController extends Controller
{
    public function __construct(
        protected ProductAttributeService $service
    ) {}

    public function index(Request $request)
    {
        $attributes = $this->service->getAttributes(
            $request->input('search'),
            $request->input('sort')
        );

        if ($request->ajax()) {
            return response()->json([
                'html' => view(
                    'admin.Product-attributes.partials.table',
                    compact('attributes')
                )->render(),
            ]);
        }

        return view(
            'admin.Product-attributes.index',
            compact('attributes')
        );
    }

    public function create(): View
    {
        return view('admin.Product-attributes.create');
    }

    public function store(
        ProductAttributeRequest $request
    ): RedirectResponse {
        $this->service->create($request->validated());

        return redirect()
            ->route('admin.product-attributes.index')
            ->with('success', 'Product attribute created successfully.');
    }

    public function edit(
        ProductAttribute $productAttribute
    ): View {
        return view(
            'admin.Product-attributes.edit',
            compact('productAttribute')
        );
    }

    public function update(
        ProductAttributeRequest $request,
        ProductAttribute $productAttribute
    ): RedirectResponse {
        $this->service->update(
            $productAttribute,
            $request->validated()
        );

        return redirect()
            ->route('admin.product-attributes.index')
            ->with('success', 'Product attribute updated successfully.');
    }

    public function destroy(
        ProductAttribute $productAttribute
    ): RedirectResponse {
        $this->service->delete($productAttribute);

        return redirect()
            ->route('admin.product-attributes.index')
            ->with('success', 'Product attribute deleted successfully.');
    }
}