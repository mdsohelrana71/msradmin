<div class="row g-4">
    @forelse ($products as $product)
        <div class="col-6 col-md-4 col-lg-3">
            @include('frontend.components.product.card.design-1', ['product' => $product])
        </div>
    @empty
        <div class="col-12">
            <div class="alert alert-info mb-0">
                No products found.
            </div>
        </div>
    @endforelse
</div>