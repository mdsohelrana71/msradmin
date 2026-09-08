<div class="row g-3 g-lg-4">
    @forelse ($products as $product)
        <div class="col-6 col-lg-3">
            @include($productCardView, ['product' => $product])
        </div>
    @empty
        <div class="col-12">
            <div class="text-center py-5">
                <i class="fa-solid fa-box-open fs-1 text-muted mb-3"></i>
                <h5 class="mb-2">No Products Found</h5>
                <p class="text-muted mb-0">There are no products available at the moment.</p>
            </div>
        </div>
    @endforelse
</div>
@if ($products->hasPages())
    <div class="d-flex justify-content-center mt-5 products-pagination">
        {{ $products->withQueryString()->links() }}
    </div>
@endif