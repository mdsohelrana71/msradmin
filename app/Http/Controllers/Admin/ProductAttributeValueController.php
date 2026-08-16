<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\ProductAttributeValueRequest;
use App\Models\ProductAttribute;
use App\Models\ProductAttributeValue;
use App\Services\Admin\ProductAttributeValueService;
use Illuminate\Http\Request;

class ProductAttributeValueController extends Controller
{
    public function __construct(
        protected ProductAttributeValueService $service
    ) {}

    public function index(
        Request $request,
        ProductAttribute $product_attribute
    ) {
        $values = $this->service->getValues(
            $product_attribute,
            $request->input('search'),
            $request->input('sort')
        );

        if ($request->ajax()) {
            return response()->json([
                'html' => view(
                    'admin.product-attribute-values.partials.table',
                    compact('values', 'product_attribute')
                )->render(),
            ]);
        }

        return view(
            'admin.Product-attribute-values.index',
            compact('values', 'product_attribute')
        );
    }

    public function create(
        ProductAttribute $product_attribute
    ) {
        return view(
            'admin.Product-attribute-values.create',
            compact('product_attribute')
        );
    }

    public function store(
        ProductAttributeValueRequest $request,
        ProductAttribute $product_attribute
    ) {
        $this->service->create(
            $product_attribute,
            $request->validated()
        );

        return redirect()
            ->route(
                'admin.product-attributes.values.index',
                $product_attribute
            )
            ->with('success', 'Attribute value created successfully.');
    }

    public function edit(
        ProductAttribute $product_attribute,
        ProductAttributeValue $value
    ) {
        return view(
            'admin.Product-attribute-values.edit',
            compact('product_attribute', 'value')
        );
    }

    public function update(
        ProductAttributeValueRequest $request,
        ProductAttribute $product_attribute,
        ProductAttributeValue $value
    ) {
        $this->service->update(
            $value,
            $request->validated()
        );

        return redirect()
            ->route(
                'admin.product-attributes.values.index',
                $product_attribute
            )
            ->with('success', 'Attribute value updated successfully.');
    }

    public function destroy(
        ProductAttribute $product_attribute,
        ProductAttributeValue $value
    ) {
        $this->service->delete($value);

        return redirect()
            ->route(
                'admin.product-attributes.values.index',
                $product_attribute
            )
            ->with('success', 'Attribute value deleted successfully.');
    }
}