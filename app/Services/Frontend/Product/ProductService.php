<?php
namespace App\Services\Frontend\Product;
use App\Models\Product;
use App\Services\Frontend\DesignManager;
use InvalidArgumentException;
class ProductService
{
    protected DesignManager $designManager;
    protected DesignOneProductService $designOneProductService;
    protected DesignTwoProductService $designTwoProductService;

    public function __construct(
        DesignManager $designManager,
        DesignOneProductService $designOneProductService,
        DesignTwoProductService $designTwoProductService
    ) {
        $this->designManager = $designManager;
        $this->designOneProductService = $designOneProductService;
        $this->designTwoProductService = $designTwoProductService;
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
        return Product::query()
            ->where('status', true)
            ->where(function ($query) use ($search) {
                $query->where('name', 'like', "%{$search}%")
                    ->orWhere('sku', 'like', "%{$search}%")
                    ->orWhere('barcode', 'like', "%{$search}%");
            })
            ->latest('created_at')
            ->take(8)
            ->get(['id', 'name', 'sku', 'thumbnail', 'slug']);
    }
}