<?php

namespace App\Services\Frontend\Blog;

use App\Models\Blog;

class DesignOneBlogService
{
    public function getBlogs()
    {
        return Blog::query()
            ->where('status', true)
            ->with(['category:id,name', 'author:id,name'])
            ->latest()
            ->paginate(12);
    }

    public function getBlog(Blog $blog): Blog
    {
        abort_unless($blog->status, 404);

        return $blog->load([
            'category:id,name',
            'author:id,name',
            'tags:id,name',
        ]);
    }
}