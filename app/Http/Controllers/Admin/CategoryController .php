<?php

namespace App\Http\Controllers\Admin;

use App\Enums\CategoryType;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\CategoryRequest;
use App\Models\Category;
use App\Services\Admin\CategoryService;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function __construct(
        protected CategoryService $categoryService
    ) {}

    public function index(Request $request)
    {
        $type = $request->enum('type', CategoryType::class)
            ?? CategoryType::BLOG;

        $categories = $this->categoryService
            ->getCategories($type);

        return view('admin.categories.index', compact(
            'categories',
            'type'
        ));
    }

    public function create(Request $request)
    {
        $type = $request->enum('type', CategoryType::class)
            ?? CategoryType::BLOG;

        $parents = $this->categoryService
            ->getParents($type);

        return view('admin.categories.create', compact(
            'type',
            'parents'
        ));
    }

    public function store(CategoryRequest $request)
    {
        $category = $this->categoryService->create(
            $request->validated()
        );

        return redirect()
            ->route('admin.categories.index', [
                'type' => $category->type,
            ])
            ->with('success', 'Category created successfully.');
    }

    public function edit(Category $category)
    {
        $parents = $this->categoryService
            ->getParents(
                CategoryType::from($category->type),
                $category->id
            );

        return view('admin.categories.edit', compact(
            'category',
            'parents'
        ));
    }

    public function update(
        CategoryRequest $request,
        Category $category
    ) {
        $category = $this->categoryService->update(
            $category,
            $request->validated()
        );

        return redirect()
            ->route('admin.categories.index', [
                'type' => $category->type,
            ])
            ->with('success', 'Category updated successfully.');
    }

    public function destroy(Category $category)
    {
        $this->categoryService->delete($category);

        return back()->with(
            'success',
            'Category deleted successfully.'
        );
    }
}