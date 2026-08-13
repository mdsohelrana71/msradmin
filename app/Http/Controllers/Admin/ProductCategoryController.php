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

    public function index(): View
    {
        $categories = $this->categoryService
            ->getTree('product');

        return view(
            'admin.Product.Category.index',
            compact('categories')
        );
    }

    public function create(): View
    {
        $categories = $this->categoryService
            ->getParentOptions('product');

        return view(
            'admin.Product.Category.create',
            compact('categories')
        );
    }

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

    public function edit(Category $category): View
    {
        abort_if(
            $category->type !== 'product',
            404
        );

        $categories = $this->categoryService
            ->getParentOptions(
                'product',
                $category
            );

        return view(
            'admin.Product.Category.edit',
            compact(
                'category',
                'categories'
            )
        );
    }

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

    public function destroy(
        Category $category
    ): RedirectResponse {
        abort_if(
            $category->type !== 'product',
            404
        );

        $this->categoryService->delete($category);

        return redirect()
            ->route('admin.product-categories.index')
            ->with(
                'success',
                'Product category deleted successfully.'
            );
    }
}