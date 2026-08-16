<?php

namespace App\Http\Controllers\Admin;

use App\Models\Product;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Services\Admin\ProductService;
use App\Http\Requests\Admin\ProductRequest;

class ProductController extends Controller
{
    public function __construct(
        protected ProductService $productService
    ) {}

    public function index(Request $request)
    {
        $products = $this->productService->getProducts(
            $request->input('search'),
            $request->input('sort')
        );

        if ($request->ajax()) {
            $html = view(
                'admin.Product.partials.table',
                compact('products')
            )->render();

            return response()->json(['html' => $html]);
        }

        return view(
            'admin.Product.index',
            compact('products')
        );
    }

    public function create()
    {
        $categories = $this->productService->getCategories();
        $brands = $this->productService->getBrands();
        $tags = $this->productService->getTags();
        $attributes = $this->productService->getAttributes();

        return view(
            'admin.Product.create',
            compact(
                'categories',
                'brands',
                'tags',
                'attributes'
            )
        );
    }

    public function store(ProductRequest $request)
    {
        $this->productService->store(
            $request->validated()
        );

        return redirect()
            ->route('admin.products.index')
            ->with(
                'success',
                'Product created successfully.'
            );
    }

    public function edit(Product $product)
    {
        $product = $this->productService->getProduct($product);

        $categories = $this->productService->getCategories();
        $brands = $this->productService->getBrands();
        $tags = $this->productService->getTags();
        $attributes = $this->productService->getAttributes();

        return view(
            'admin.Product.edit',
            compact(
                'product',
                'categories',
                'brands',
                'tags',
                'attributes'
            )
        );
    }

    public function update(
        ProductRequest $request,
        Product $product
    ) {
        $this->productService->update(
            $product,
            $request->validated()
        );

        return redirect()
            ->route('admin.products.index')
            ->with(
                'success',
                'Product updated successfully.'
            );
    }

    public function show(Product $product)
    {
        $product = $this->productService->getProduct(
            $product
        );

        return view(
            'admin.Product.show',
            compact('product')
        );
    }

    public function destroy(Product $product)
    {
        $this->productService->delete($product);

        return redirect()
            ->route('admin.products.index')
            ->with(
                'success',
                'Product deleted successfully.'
            );
    }
}