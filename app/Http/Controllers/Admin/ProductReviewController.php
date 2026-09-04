<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Models\ProductReview;
use App\Http\Controllers\Controller;
use App\Services\Admin\ProductReviewService;
use App\Http\Requests\Admin\ProductReviewRequest;

class ProductReviewController extends Controller
{
    public function __construct(
        protected ProductReviewService $productReviewService
    ) {}

    public function index(Request $request)
    {
        $reviews = $this->productReviewService->getReviews(
            $request->input('search'),
            $request->input('sort')
        );

        if ($request->ajax()) {
            $html = view(
                'admin.Product-reviews.partials.table',
                compact('reviews')
            )->render();

            return response()->json([
                'html' => $html,
            ]);
        }

        return view(
            'admin.Product-reviews.index',
            compact('reviews')
        );
    }

    public function show(ProductReview $productReview)
    {
        $review = $this->productReviewService->getReview(
            $productReview
        );

        return view(
            'admin.Product-reviews.show',
            compact('review')
        );
    }

    public function edit(ProductReview $productReview)
    {
        $review = $this->productReviewService->getReview(
            $productReview
        );

        return view(
            'admin.Product-reviews.edit',
            compact('review')
        );
    }

    public function update(
        ProductReviewRequest $request,
        ProductReview $productReview
    ) {
        $this->productReviewService->update(
            $productReview,
            $request->validated()
        );

        return redirect()
            ->route('admin.product-reviews.index')
            ->with(
                'success',
                'Product review updated successfully.'
            );
    }

    public function destroy(ProductReview $productReview)
    {
        $this->productReviewService->delete(
            $productReview
        );

        return redirect()
            ->route('admin.product-reviews.index')
            ->with(
                'success',
                'Product review deleted successfully.'
            );
    }
}