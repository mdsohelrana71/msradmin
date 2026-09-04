<?php

namespace App\Services\Admin;

use App\Models\ProductReview;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

class ProductReviewService
{
    public function getReviews(
        ?string $search = null,
        ?string $sort = null,
        int $perPage = 20
    ): LengthAwarePaginator {
        return ProductReview::query()
            ->with([
                'product:id,name,sku,thumbnail',
                'user:id,name,email',
                'images:id,review_id,image',
            ])
            ->when($search, function ($query) use ($search) {
                $query->where(function ($query) use ($search) {
                    $query
                        ->where('title', 'like', "%{$search}%")
                        ->orWhere('review', 'like', "%{$search}%")
                        ->orWhereHas('product', function ($query) use ($search) {
                            $query
                                ->where('name', 'like', "%{$search}%")
                                ->orWhere('sku', 'like', "%{$search}%");
                        })
                        ->orWhereHas('user', function ($query) use ($search) {
                            $query
                                ->where('name', 'like', "%{$search}%")
                                ->orWhere('email', 'like', "%{$search}%");
                        });
                });
            })
            ->when($sort, function ($query) use ($sort) {
                match ($sort) {
                    'rating_high' => $query->orderByDesc('rating'),
                    'rating_low' => $query->orderBy('rating'),
                    'verified' => $query
                        ->where('is_verified', true)
                        ->latest('created_at'),
                    'unverified' => $query
                        ->where('is_verified', false)
                        ->latest('created_at'),
                    'active' => $query
                        ->where('status', true)
                        ->latest('created_at'),
                    'inactive' => $query
                        ->where('status', false)
                        ->latest('created_at'),
                    'oldest' => $query->oldest('created_at'),
                    default => $query->latest('created_at'),
                };
            }, function ($query) {
                $query->latest('created_at');
            })
            ->paginate($perPage)
            ->withQueryString();
    }

    public function getReview(ProductReview $review): ProductReview
    {
        return $review->load([
            'product',
            'user',
            'images',
        ]);
    }

    public function update(
        ProductReview $review,
        array $data
    ): ProductReview {
        return DB::transaction(function () use (
            $review,
            $data
        ) {
            $images = $data['images'] ?? [];
            $removedImageIds = $data['removed_image_ids'] ?? [];

            unset(
                $data['images'],
                $data['removed_image_ids']
            );

            $review->update($data);

            if (!empty($removedImageIds)) {
                $review->images()
                    ->whereIn('id', $removedImageIds)
                    ->each(function ($image) {
                        if ($image->image) {
                            Storage::disk('public')
                                ->delete($image->image);
                        }

                        $image->delete();
                    });
            }

            foreach ($images as $image) {
                if (!$image) {
                    continue;
                }

                $imagePath = $image->store(
                    'products/reviews',
                    'public'
                );

                $review->images()->create([
                    'image' => $imagePath,
                ]);
            }

            return $review->fresh([
                'product',
                'user',
                'images',
            ]);
        });
    }

    public function delete(ProductReview $review): bool
    {
        return DB::transaction(function () use ($review) {
            $review->images()
                ->each(function ($image) {
                    if ($image->image) {
                        Storage::disk('public')
                            ->delete($image->image);
                    }
                });

            return $review->delete();
        });
    }
}