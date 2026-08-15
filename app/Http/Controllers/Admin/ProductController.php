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
        $blogs = $this->productService->getBlogs($request->all());

        if ($request->ajax()) {
            $html = view(
                'admin.Blog.partials.table',
                compact('blogs')
            )->render();

            return response()->json(['html' => $html]);
        }

        return view('admin.Blog.index', compact('blogs'));
    }

    public function create()
    {
        $categories = $this->productService->getCategories();
        $tags = $this->productService->getTags();

        return view(
            'admin.Blog.create',
            compact('categories', 'tags')
        );
    }

    public function store(ProductRequest $request)
    {
        $this->productService->create(
            $request->validated()
        );

        return redirect()
            ->route('admin.blogs.index')
            ->with('success', 'Blog created successfully.');
    }

    public function edit(Blog $blog)
    {
        $categories = $this->productService->getCategories();
        $tags = $this->productService->getTags();

        $blog->load('tags');

        return view(
            'admin.Blog.edit',
            compact('blog', 'categories', 'tags')
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
            ->route('admin.blogs.index')
            ->with('success', 'Blog updated successfully.');
    }

    public function show(Blog $blog)
    {
        $blog = $this->productService->getBlog($blog);

        return view(
            'admin.Blog.show',
            compact('blog')
        );
    }

    public function destroy(Blog $blog)
    {
        $this->productService->delete($blog);

        return redirect()
            ->route('admin.blogs.index')
            ->with('success', 'Blog deleted successfully.');
    }
}