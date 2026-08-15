<?php

namespace App\Services\Admin;

use App\Models\Blog;
use App\Models\Category;
use App\Models\Tag;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

class ProductService
{
    public function getBlogs(array $filters = []): LengthAwarePaginator
    {
        $query = Blog::query()
            ->with(['category', 'author', 'tags']);

        if (!empty($filters['search'])) {
            $search = $filters['search'];

            $query->where(function ($query) use ($search) {
                $query->where('title', 'like', "%{$search}%")
                    ->orWhere('content', 'like', "%{$search}%")
                    ->orWhere('excerpt', 'like', "%{$search}%");
            });
        }

        if (!empty($filters['sort'])) {
            match ($filters['sort']) {
                'a_z' => $query->orderBy('title'),
                'z_a' => $query->orderByDesc('title'),
                'latest' => $query->latest('created_at'),
                'oldest' => $query->oldest('created_at'),
                'published' => $query
                    ->where('status', true)
                    ->latest('created_at'),
                'draft' => $query
                    ->where('status', false)
                    ->latest('created_at'),
                default => $query->latest('created_at'),
            };
        } else {
            $query->latest('created_at');
        }

        $perPage = (int) ($filters['per_page'] ?? 10);

        return $query
            ->paginate($perPage)
            ->withQueryString();
    }

    public function getBlog(Blog $blog): Blog
    {
        return $blog->load([
            'category',
            'author',
            'tags',
        ]);
    }

    public function getCategories(): Collection
    {
        return Category::query()
            ->ofType('product')
            ->active()
            ->orderBy('name')
            ->get();
    }

    public function getTags(): Collection
    {
        return Tag::query()
            ->orderBy('name')
            ->get();
    }

    public function create(array $data): Blog
    {
        $data['user_id'] = Auth::id();

        $tagIds = $this->prepareTags($data['tags'] ?? []);

        unset($data['tags']);

        $blog = Blog::create(
            $this->prepareData($data)
        );

        $blog->tags()->sync($tagIds);

        return $blog->load([
            'category',
            'author',
            'tags',
        ]);
    }

    public function update(Blog $blog, array $data): Blog
    {
        $tagIds = $this->prepareTags($data['tags'] ?? []);

        unset($data['tags']);

        $blog->update(
            $this->prepareData($data, $blog)
        );

        $blog->tags()->sync($tagIds);

        return $blog->fresh([
            'category',
            'author',
            'tags',
        ]);
    }

    public function delete(Blog $blog): bool
    {
        if ($blog->featured_image) {
            Storage::disk('public')->delete(
                $blog->featured_image
            );
        }

        if ($blog->og_image) {
            Storage::disk('public')->delete(
                $blog->og_image
            );
        }

        $blog->tags()->detach();

        return $blog->delete();
    }

    private function prepareTags(array $tags): array
    {
        return collect($tags)
            ->map(function ($tag) {
                if (is_numeric($tag)) {
                    return (int) $tag;
                }

                $name = trim($tag);

                if ($name === '') {
                    return null;
                }

                return Tag::firstOrCreate(
                    [
                        'slug' => Str::slug($name),
                    ],
                    [
                        'name' => $name,
                        'status' => true,
                    ]
                )->id;
            })
            ->filter()
            ->unique()
            ->values()
            ->all();
    }

    private function prepareData(
        array $data,
        ?Blog $blog = null
    ): array {
        $data['slug'] = Str::slug($data['title']);

        if (isset($data['featured_image']) && $data['featured_image']) {
            if ($blog?->featured_image) {
                Storage::disk('public')->delete(
                    $blog->featured_image
                );
            }

            $data['featured_image'] = $data['featured_image']
                ->store('blogs/featured', 'public');
        } elseif ($blog) {
            unset($data['featured_image']);
        }

        if (isset($data['og_image']) && $data['og_image']) {
            if ($blog?->og_image) {
                Storage::disk('public')->delete(
                    $blog->og_image
                );
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