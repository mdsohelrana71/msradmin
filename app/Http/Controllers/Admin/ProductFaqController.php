<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\ProductFaqRequest;
use App\Models\Product;
use App\Models\ProductFaq;
use App\Services\Admin\ProductFaqService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ProductFaqController extends Controller
{
    public function __construct(
        protected ProductFaqService $service
    ) {}

    public function index(Request $request)
    {
        $faqs = $this->service->getFaqs(
            $request->input('search'),
            $request->input('sort')
        );

        if ($request->ajax()) {
            return response()->json([
                'html' => view(
                    'admin.Product-faqs.partials.table',
                    compact('faqs')
                )->render(),
            ]);
        }

        return view(
            'admin.Product-faqs.index',
            compact('faqs')
        );
    }

    public function create(): View
    {
        $products = Product::query()
            ->where('status', true)
            ->orderBy('name')
            ->get([
                'id',
                'name',
                'sku',
            ]);

        return view(
            'admin.Product-faqs.create',
            compact('products')
        );
    }

    public function store(
        ProductFaqRequest $request
    ): RedirectResponse {
        $this->service->create(
            $request->validated()
        );

        return redirect()
            ->route('admin.product-faqs.index')
            ->with(
                'success',
                'Product FAQ created successfully.'
            );
    }

    public function show(
        ProductFaq $productFaq
    ): View {
        $faq = $this->service->find(
            $productFaq->id
        );

        return view(
            'admin.Product-faqs.show',
            compact('faq')
        );
    }

    public function edit(
        ProductFaq $productFaq
    ): View {
        $products = Product::query()
            ->where('status', true)
            ->orderBy('name')
            ->get([
                'id',
                'name',
                'sku',
            ]);

        $faq = $this->service->find(
            $productFaq->id
        );

        return view(
            'admin.Product-faqs.edit',
            compact(
                'faq',
                'products'
            )
        );
    }

    public function update(
        ProductFaqRequest $request,
        ProductFaq $productFaq
    ): RedirectResponse {
        $this->service->update(
            $productFaq,
            $request->validated()
        );

        return redirect()
            ->route('admin.product-faqs.index')
            ->with(
                'success',
                'Product FAQ updated successfully.'
            );
    }

    public function destroy(
        ProductFaq $productFaq
    ): RedirectResponse {
        $this->service->delete(
            $productFaq
        );

        return redirect()
            ->route('admin.product-faqs.index')
            ->with(
                'success',
                'Product FAQ deleted successfully.'
            );
    }

    public function searchProducts(
        Request $request
    ): JsonResponse {
        $products = $this->service->searchProducts(
            $request->input('q')
        );

        return response()->json([
            'results' => $products->map(
                function ($product) {
                    return [
                        'id' => $product->id,
                        'text' => $product->name
                            . (
                                $product->sku
                                    ? " ({$product->sku})"
                                    : ''
                            ),
                    ];
                }
            ),
        ]);
    }
}