<?php

namespace App\Services\Admin;

use App\Models\Blog;
use App\Models\Category;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Str;

class BlogService
{
    public function getBlogs(
        ?string $search = null,
        int $perPage = 20
    ): LengthAwarePaginator {
        return Blog::query()
            ->with('category')
            ->when($search, function ($query) use ($search) {
                $query->where(function ($query) use ($search) {
                    $query->where(
                        'title',
                        'like',
                        "%{$search}%"
                    )->orWhere(
                        'content',
                        'like',
                        "%{$search}%"
                    );
                });
            })
            ->latest()
            ->paginate($perPage)
            ->withQueryString();
    }

    public function getCategories(): Collection
    {
        return Category::query()
            ->ofType('blog')
            ->active()
            ->orderBy('name')
            ->get();
    }

    public function create(array $data): Blog
    {
        $data = $this->prepareData($data);

        return Blog::create($data);
    }

    public function update(
        Blog $blog,
        array $data
    ): Blog {
        $data = $this->prepareData($data);

        $blog->update($data);

        return $blog->fresh();
    }

    public function delete(Blog $blog): bool
    {
        return $blog->delete();
    }

    private function prepareData(array $data): array
    {
        if (empty($data['slug'])) {
            $data['slug'] = Str::slug($data['title']);
        }

        return $data;
    }
}