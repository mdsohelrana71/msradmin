<?php

namespace App\Services\Frontend\Blog;

use App\Models\Blog;
use App\Services\Frontend\Global\BlogQuery;

class BlogService
{
    protected BlogQuery $blogQuery;

    public function __construct(BlogQuery $blogQuery)
    {
        $this->blogQuery = $blogQuery;
    }

    public function getBlogs()
    {
        return $this->blogQuery
            ->frontend()
            ->with(['category:id,name', 'author:id,name'])
            ->latest()
            ->paginate(12)
            ->withQueryString();
    }

    public function getLatestBlogs(int $limit = 3)
    {
        return $this->blogQuery->recent($limit);
    }

    public function getBlogCategories()
    {
        return $this->blogQuery->categories();
    }

    public function getBlogTags()
    {
        return $this->blogQuery->tags();
    }

    public function getBlog(Blog $blog): Blog
    {
        abort_unless($blog->status, 404);

        return $blog->load([
            'category:id,name',
            'author:id,name',
            'tags:id,name,slug',
        ]);
    }
}