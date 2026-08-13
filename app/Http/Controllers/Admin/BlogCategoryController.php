<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\CategoryRequest;
use App\Models\Category;
use App\Services\Admin\CategoryService;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class BlogCategoryController extends Controller
{
    public function __construct(
        protected CategoryService $categoryService
    ) {}

    public function index(): View
    {
        $categories = $this->categoryService
            ->getTree('blog');

        return view(
            'admin.Blog.Category.index',
            compact('categories')
        );
    }

    public function create(): View
    {
        $categories = $this->categoryService->getTree('blog');

        return view('admin.Blog.Category.create', compact('categories'));
    }

    public function store(
        CategoryRequest $request
    ): RedirectResponse {
        $this->categoryService->create(
            $request->validated(),
            'blog'
        );

        return redirect()
            ->route('admin.blog-categories.index')
            ->with(
                'success',
                'Blog category created successfully.'
            );
    }

    public function edit(Category $category): View
    {
        abort_if($category->type !== 'blog', 404);

        $categories = $this->categoryService->getTree('blog');

        $excludedIds = $this->categoryService
            ->getDescendantIdsForEdit($category);

        $excludedIds[] = $category->id;

        return view(
            'admin.Blog.Category.edit',
            compact(
                'category',
                'categories',
                'excludedIds'
            )
        );
    }

    public function update(
        CategoryRequest $request,
        Category $category
    ): RedirectResponse {
        abort_if(
            $category->type !== 'blog',
            404
        );

        $this->categoryService->update(
            $category,
            $request->validated(),
            'blog'
        );

        return redirect()
            ->route('admin.blog-categories.index')
            ->with(
                'success',
                'Blog category updated successfully.'
            );
    }

    public function destroy(
        Category $category
    ): RedirectResponse {
        abort_if(
            $category->type !== 'blog',
            404
        );

        $this->categoryService->delete($category);

        return redirect()
            ->route('admin.blog-categories.index')
            ->with(
                'success',
                'Blog category deleted successfully.'
            );
    }
}