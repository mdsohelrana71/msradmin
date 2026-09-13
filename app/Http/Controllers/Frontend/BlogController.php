<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Blog;
use App\Services\Frontend\Blog\BlogService;
use App\Services\Frontend\DesignManager;

class BlogController extends Controller
{
    protected DesignManager $designManager;
    protected BlogService $blogService;

    public function __construct(
        DesignManager $designManager,
        BlogService $blogService
    ) {
        $this->designManager = $designManager;
        $this->blogService = $blogService;
    }

    public function index()
    {
        $blogs = $this->blogService->getBlogs();
        $blogCategories = $this->blogService->getBlogCategories();
        $recentBlogs = $this->blogService->getLatestBlogs(3);
        $blogTags = $this->blogService->getBlogTags();
        $blogCardView = $this->designManager->getSectionView('blog_card');

        return view(
            $this->designManager->getPageView('blog_listing'),
            compact('blogs', 'blogCategories', 'recentBlogs', 'blogTags', 'blogCardView')
        );
    }

    public function show(Blog $blog)
    {
        $blog = $this->blogService->getBlog($blog);
        $blogDetailsView = $this->designManager->getSectionView('blog_details');

        return view(
            $this->designManager->getPageView('blog_details'),
            compact('blog', 'blogDetailsView')
        );
    }
}