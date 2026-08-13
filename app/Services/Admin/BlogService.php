<?php

namespace App\Services\Admin;

use App\Models\Blog;
use App\Models\Category;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

class BlogService
{
    public function getBlogs(
        ?string $search = null,
        int $perPage = 20
    ): LengthAwarePaginator {
        return Blog::query()
            ->with(['category', 'author'])
            ->when($search, function ($query) use ($search) {
                $query->where(function ($query) use ($search) {
                    $query->where('title', 'like', "%{$search}%")
                        ->orWhere('content', 'like', "%{$search}%");
                });
            })
            ->latest()
            ->paginate($perPage)
            ->withQueryString();
    }

    public function getBlog(Blog $blog): Blog
    {
        return $blog->load([
            'category',
            'author',
        ]);
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
        $data['user_id'] = Auth::id();

        return Blog::create(
            $this->prepareData($data)
        );
    }

    public function update(Blog $blog, array $data): Blog
    {
        $blog->update(
            $this->prepareData($data, $blog)
        );

        return $blog->fresh([
            'category',
            'author',
        ]);
    }

    public function delete(Blog $blog): bool
    {
        if ($blog->featured_image) {
            Storage::disk('public')->delete(
                $blog->featured_image
            );
        }

        return $blog->delete();
    }
    
    private function prepareData(
        array $data,
        ?Blog $blog = null
    ): array {
        $data['slug'] = Str::slug($data['title']);

        if (isset($data['featured_image']) && $data['featured_image']) {
            if ($blog?->featured_image) {
                Storage::disk('public')->delete($blog->featured_image);
            }

            $data['featured_image'] = $data['featured_image']
                ->store('blogs/featured', 'public');
        } elseif ($blog) {
            unset($data['featured_image']);
        }

        if (isset($data['og_image']) && $data['og_image']) {
            if ($blog?->og_image) {
                Storage::disk('public')->delete($blog->og_image);
            }

            $data['og_image'] = $data['og_image']
                ->store('blogs/og', 'public');
        } elseif ($blog) {
            unset($data['og_image']);
        }

        $data['is_featured'] = $data['is_featured'] ?? false;
        $data['allow_comments'] = $data['allow_comments'] ?? false;

        return $data;
    }
}