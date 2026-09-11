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
        $data['productListingView'] = $productListingView;
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
        $data = $this->productService->getProduct($product);
        $data['productDetailsView'] = $this->designManager->getSectionView('product_details');
        $data['productCardView'] = $this->designManager->getSectionView('product_card');

        return view(
            $this->designManager->getPageView('product_details'),
            $data
        );
    }

    public function search(Request $request)
    {
        $search = trim($request->get('q', ''));
        if (mb_strlen($search) < 2) {
            return response()->json([]);
        }
        $products = $this->productService->searchProducts($search);
        return response()->json($products->map(function ($product) {
            return [
                'id' => $product->id,
                'name' => $product->name,
                'sku' => $product->sku,
                'thumbnail' => $product->thumbnail
                    ? asset('storage/' . $product->thumbnail)
                    : null,
                'url' => route('products.show', ['product' => $product->slug]),
            ];
        }));
    }
}