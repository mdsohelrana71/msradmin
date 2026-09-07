<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Services\Frontend\DesignManager;
use App\Services\Frontend\Product\ProductService;

class ProductController extends Controller
{
    protected DesignManager $designManager;
    protected ProductService $productService;

    public function __construct(
        DesignManager $designManager,
        ProductService $productService
    ) {
        $this->designManager = $designManager;
        $this->productService = $productService;
    }

    public function index()
    {
        $products = $this->productService->getProducts();

        return view(
            $this->designManager->getPageView('product_listing'),
            compact('products')
        );
    }

    public function show(Product $product)
    {
        $product = $this->productService->getProduct($product);

        return view(
            $this->designManager->getPageView('product_details'),
            compact('product')
        );
    }
}