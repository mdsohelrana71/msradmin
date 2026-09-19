<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Services\Frontend\Global\WishlistService;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;

class WishlistController extends Controller
{
    public function __construct(
        protected WishlistService $wishlistService
    ) {}

    public function toggle(int $productId): JsonResponse
    {
        if (!Auth::check()) {
            return response()->json([
                'status' => false,
                'message' => 'Please login to add products to your wishlist.',
                'redirect' => route('login'),
            ], 401);
        }

        $added = $this->wishlistService->toggle($productId);

        return response()->json([
            'status' => true,
            'added' => $added,
            'message' => $added
                ? 'Product added to wishlist.'
                : 'Product removed from wishlist.',
        ]);
    }
}