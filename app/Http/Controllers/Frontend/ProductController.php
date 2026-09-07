<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Services\Frontend\DesignManager;

class ProductController extends Controller
{
    protected DesignManager $designManager;

    public function __construct(DesignManager $designManager)
    {
        $this->designManager = $designManager;
    }

    public function index()
    {
        $query = Product::query()
            ->where('status', true)
            ->with(['images']);

        $sort = request('sort', 'newest');

        match ($sort) {
            'priceLowHigh' => $query->orderBy('selling_price'),
            'priceHighLow' => $query->orderByDesc('selling_price'),
            default => $query->latest('created_at'),
        };

        $products = $query->paginate(12)->withQueryString();

        return view($this->designManager->getPageView('product_listing'), compact('products'));
    }

    public function show(Product $product)
    {
        abort_unless($product->status, 404);

        return view($this->designManager->getPageView('product_details'), compact('product'));
    }
}