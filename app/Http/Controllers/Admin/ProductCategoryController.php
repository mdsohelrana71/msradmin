<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\CategoryRequest;
use App\Models\Category;
use App\Services\Admin\CategoryService;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class ProductCategoryController extends Controller
{
    public function __construct(
        protected CategoryService $categoryService
    ) {}


    /**
     * Display product categories.
     */
    public function index(): View
    {
        $categories = $this->categoryService
            ->getTree('product');

        return view(
            'admin.Product.Category.index',
            compact('categories')
        );
    }


    /**
     * Show create category form.
     */
    public function create(): View
    {
        $categories = $this->categoryService
            ->getTree('product');

        return view(
            'admin.Product.Category.create',
            compact('categories')
        );
    }


    /**
     * Store a new product category.
     */
    public function store(
        CategoryRequest $request
    ): RedirectResponse {
        $this->categoryService->create(
            $request->validated(),
            'product'
        );

        return redirect()
            ->route('admin.product-categories.index')
            ->with(
                'success',
                'Product category created successfully.'
            );
    }


    /**
     * Show edit category form.
     */
    public function edit(
        Category $category
    ): View {
        abort_if(
            $category->type !== 'product',
            404
        );

        $categories = $this->categoryService
            ->getTree('product');

        $excludedIds = $this->categoryService
            ->getDescendantIdsForEdit($category);

        // Current category cannot be its own parent.
        $excludedIds[] = $category->id;

        return view(
            'admin.Product.Category.edit',
            compact(
                'category',
                'categories',
                'excludedIds'
            )
        );
    }


    /**
     * Update product category.
     */
    public function update(
        CategoryRequest $request,
        Category $category
    ): RedirectResponse {
        abort_if(
            $category->type !== 'product',
            404
        );

        $this->categoryService->update(
            $category,
            $request->validated(),
            'product'
        );

        return redirect()
            ->route('admin.product-categories.index')
            ->with(
                'success',
                'Product category updated successfully.'
            );
    }


    /**
     * Delete product category.
     */
    public function destroy(
        Category $category
    ): RedirectResponse {
        abort_if(
            $category->type !== 'product',
            404
        );

        $this->categoryService->delete(
            $category
        );

        return redirect()
            ->route('admin.product-categories.index')
            ->with(
                'success',
                'Product category deleted successfully.'
            );
    }
}