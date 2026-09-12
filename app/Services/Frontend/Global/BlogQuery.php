<?php

namespace App\Services\Frontend\Global;

use App\Models\Blog;
use Illuminate\Database\Eloquent\Builder;

class BlogQuery
{
    public function frontend(): Builder
    {
        return Blog::query()
            ->where('status', true);
    }
}