<div class="card h-100 border-0 shadow-sm">
    <a href="{{ route('products.show', $product) }}" class="text-decoration-none">
        <div class="ratio ratio-1x1 bg-light">
            @if ($product->primary_image)
                <img
                    src="{{ asset('storage/' . $product->primary_image) }}"
                    class="img-fluid object-fit-cover"
                    alt="{{ $product->name }}"
                >
            @else
                <div class="d-flex align-items-center justify-content-center text-muted">
                    No Image
                </div>
            @endif
        </div>
    </a>
    <div class="card-body">
        <h6 class="mb-2">
            <a href="{{ route('products.show', $product) }}" class="text-dark text-decoration-none">
                {{ $product->name }}
            </a>
        </h6>
        <div class="fw-bold">
            {{ number_format($product->price, 2) }}
        </div>
        <a href="{{ route('products.show', $product) }}" class="btn btn-dark btn-sm mt-3 w-100">
            View Product
        </a>
    </div>
</div>