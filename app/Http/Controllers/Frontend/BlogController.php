<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Blog;
use App\Services\Frontend\DesignManager;

class BlogController extends Controller
{
    protected DesignManager $designManager;

    public function __construct(DesignManager $designManager)
    {
        $this->designManager = $designManager;
    }

    public function index()
    {
        $blogs = Blog::query()
            ->where('status', true)
            ->latest()
            ->paginate(12);

        return view($this->designManager->getPageView('blog_listing'), compact('blogs'));
    }

    public function show(Blog $blog)
    {
        abort_unless($blog->status, 404);

        return view($this->designManager->getPageView('blog_details'), compact('blog'));
    }
}