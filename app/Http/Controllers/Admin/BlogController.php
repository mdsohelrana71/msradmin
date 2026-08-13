<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\BlogRequest;
use App\Models\Blog;
use App\Services\Admin\BlogService;
use Illuminate\Http\Request;

class BlogController extends Controller
{
    public function __construct(
        protected BlogService $blogService
    ) {}

    public function index(Request $request)
    {
        $blogs = $this->blogService->getBlogs(
            $request->input('search')
        );

        return view('admin.Blog.index', compact('blogs'));
    }

    public function create()
    {
        $categories = $this->blogService->getCategories();

        return view(
            'admin.Blog.create',
            compact('categories')
        );
    }

    public function store(BlogRequest $request)
    {
        $this->blogService->create(
            $request->validated()
        );

        return redirect()
            ->route('admin.blogs.index')
            ->with(
                'success',
                'Blog created successfully.'
            );
    }

    public function edit(Blog $blog)
    {
        $categories = $this->blogService->getCategories();

        return view(
            'admin.Blog.edit',
            compact('blog', 'categories')
        );
    }

    public function update(
        BlogRequest $request,
        Blog $blog
    ) {
        $this->blogService->update(
            $blog,
            $request->validated()
        );

        return redirect()
            ->route('admin.blogs.index')
            ->with(
                'success',
                'Blog updated successfully.'
            );
    }

    public function show(Blog $blog)
    {
        return view(
            'admin.Blog.show',
            compact('blog')
        );
    }

    public function destroy(Blog $blog)
    {
        $this->blogService->delete($blog);

        return redirect()
            ->route('admin.blogs.index')
            ->with(
                'success',
                'Blog deleted successfully.'
            );
    }
}
