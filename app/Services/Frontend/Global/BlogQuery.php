<?php

namespace App\Services\Frontend\Global;

use App\Models\Blog;
use App\Models\Category;
use App\Models\Tag;
use Illuminate\Database\Eloquent\Builder;

class BlogQuery
{
    public function frontend(): Builder
    {
        return Blog::query()
            ->where('status', true);
    }

    public function categories()
    {
        return Category::query()
            ->where('type', 'blog')
            ->where('status', true)
            ->orderBy('name')
            ->get(['id', 'name', 'slug']);
    }

    public function tags()
    {
        return Tag::query()
            ->whereHas('blogs', fn ($query) => $query->where('status', true))
            ->orderBy('name')
            ->get(['id', 'name', 'slug']);
    }

    public function recent(int $limit = 3)
    {
        return $this->frontend()
            ->with(['category:id,name', 'author:id,name'])
            ->latest('created_at')
            ->take($limit)
            ->get();
    }
}
