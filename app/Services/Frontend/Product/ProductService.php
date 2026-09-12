<?php

namespace App\Services\Frontend\Product;

use App\Models\Product;
use App\Services\Frontend\DesignManager;
use App\Services\Frontend\Global\ProductSearchService;
use InvalidArgumentException;

class ProductService
{
    protected DesignManager $designManager;
    protected DesignOneProductService $designOneProductService;
    protected DesignTwoProductService $designTwoProductService;
    protected ProductSearchService $productSearchService;

    public function __construct(
        DesignManager $designManager,
        DesignOneProductService $designOneProductService,
        DesignTwoProductService $designTwoProductService,
        ProductSearchService $productSearchService
    ) {
        $this->designManager = $designManager;
        $this->designOneProductService = $designOneProductService;
        $this->designTwoProductService = $designTwoProductService;
        $this->productSearchService = $productSearchService;
    }

    public function getProducts(): array
    {
        return match ($this->designManager->getActiveTemplate()) {
            'design-1' => $this->designOneProductService->getProducts(),
            'design-2' => $this->designTwoProductService->getProducts(),
            default => throw new InvalidArgumentException('Product design service not found.'),
        };
    }

    public function getProduct(Product $product): array
    {
        return match ($this->designManager->getActiveTemplate()) {
            'design-1' => $this->designOneProductService->getProduct($product),
            'design-2' => $this->designTwoProductService->getProduct($product),
            default => throw new InvalidArgumentException('Product design service not found.'),
        };
    }

    public function searchProducts(string $search)
    {
        return $this->productSearchService->search($search);
    }
}