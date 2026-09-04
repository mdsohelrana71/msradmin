<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Models\ProductWishlist;
use App\Http\Controllers\Controller;
use App\Services\Admin\ProductWishlistService;

class ProductWishlistController extends Controller
{
    public function __construct(
        protected ProductWishlistService $productWishlistService
    ) {}

    public function index(Request $request)
    {
        $wishlists = $this->productWishlistService->getWishlists(
            $request->input('search'),
            $request->input('sort')
        );

        if ($request->ajax()) {
            $html = view(
                'admin.Product-wishlists.partials.table',
                compact('wishlists')
            )->render();

            return response()->json([
                'html' => $html,
            ]);
        }

        return view(
            'admin.Product-wishlists.index',
            compact('wishlists')
        );
    }

    public function show(ProductWishlist $productWishlist)
    {
        $wishlist = $this->productWishlistService->getWishlist(
            $productWishlist
        );

        return view(
            'admin.Product-wishlists.show',
            compact('wishlist')
        );
    }

    public function destroy(ProductWishlist $productWishlist)
    {
        $this->productWishlistService->delete(
            $productWishlist
        );

        return redirect()
            ->route('admin.product-wishlists.index')
            ->with(
                'success',
                'Product wishlist deleted successfully.'
            );
    }
}