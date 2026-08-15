<?php

namespace App\Http\Controllers\Admin;


use App\Models\Blog;
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
        $products = $this->productService->getBlogs($request->all());

        if ($request->ajax()) {
            $html = view(
                'admin.Product.partials.table',
                compact('products')
            )->render();

            return response()->json(['html' => $html]);
        }

        return view('admin.Product.index', compact('products'));
    }

    public function create()
    {
        $categories = $this->productService->getCategories();
        $tags = $this->productService->getTags();

        return view(
            'admin.Product.create',
            compact('categories', 'tags')
        );
    }

    public function store(ProductRequest $request)
    {
        $this->productService->create(
            $request->validated()
        );

        return redirect()
            ->route('admin.products.index')
            ->with('success', 'Product created successfully.');
    }

    public function edit(Blog $product)
    {
        $categories = $this->productService->getCategories();
        $tags = $this->productService->getTags();

        $product->load('tags');

        return view(
            'admin.Product.edit',
            compact('product', 'categories', 'tags')
        );
    }

    public function update(
        ProductRequest $request,
        Blog $blog
    ) {
        $this->productService->update(
            $blog,
            $request->validated()
        );

        return redirect()
            ->route('admin.products.index')
            ->with('success', 'Product updated successfully.');
    }

    public function show(Blog $blog)
    {
        $product = $this->productService->getBlog($blog);

        return view(
            'admin.Product.show',
            compact('product')
        );
    }

    public function destroy(Blog $blog)
    {
        $this->productService->delete($blog);

        return redirect()
            ->route('admin.products.index')
            ->with('success', 'Product deleted successfully.');
    }
}