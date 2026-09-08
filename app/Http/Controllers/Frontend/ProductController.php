<?php
namespace App\Http\Controllers\Frontend;
use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Services\Frontend\DesignManager;
use App\Services\Frontend\Product\ProductService;
use Illuminate\Http\Request;
class ProductController extends Controller
{
    protected DesignManager $designManager;
    protected ProductService $productService;
    public function __construct(DesignManager $designManager, ProductService $productService)
    {
        $this->designManager = $designManager;
        $this->productService = $productService;
    }
    public function index(Request $request)
    {
        $data = $this->productService->getProducts();
        $productListingView = $this->designManager->getSectionView('product_listing');
        $productCardView = $this->designManager->getSectionView('product_card');
        $data['productCardView'] = $productCardView;
        if ($request->ajax()) {
            return response()->json([
                'html' => view($productListingView, [
                    'products' => $data['products'],
                    'productCardView' => $productCardView,
                ])->render(),
            ]);
        }
        return view(
            $this->designManager->getPageView('product_listing'),
            $data
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