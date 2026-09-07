<?php

namespace App\Services\Frontend\Product;

use App\Models\Product;
use App\Services\Frontend\DesignManager;
use InvalidArgumentException;

class ProductService
{
    protected DesignManager $designManager;
    protected DesignOneProductService $designOneProductService;

    public function __construct(
        DesignManager $designManager,
        DesignOneProductService $designOneProductService
    ) {
        $this->designManager = $designManager;
        $this->designOneProductService = $designOneProductService;
    }

    public function getProducts(): array
    {
        return match ($this->designManager->getActiveTemplate()) {
            'design-1' => $this->designOneProductService->getProducts(),
            default => throw new InvalidArgumentException('Product design service not found.'),
        };
    }

    public function getProduct(Product $product): Product
    {
        return match ($this->designManager->getActiveTemplate()) {
            'design-1' => $this->designOneProductService->getProduct($product),
            default => throw new InvalidArgumentException('Product design service not found.'),
        };
    }
}