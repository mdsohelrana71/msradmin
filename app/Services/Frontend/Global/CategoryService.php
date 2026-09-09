<?php

namespace App\Services\Frontend\Global;

use App\Models\Category;

class CategoryService
{
    public function getHeaderCategories()
    {
        return Category::query()
            ->whereNull('parent_id')
            ->where('status', true)
            ->where('type', 'product')
            ->orderBy('sort_order')
            ->latest('id')
            ->get();
    }

    public function getHomeCategories()
    {
        return $this->getHeaderCategories();
    }
}