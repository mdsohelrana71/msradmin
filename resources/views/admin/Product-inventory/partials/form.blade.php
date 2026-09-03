<div class="row">
    <div class="col-md-6 mb-4">
        <label class="form-label text-muted small">
            Product
        </label>
        <div class="fw-medium">
            {{ $inventory->product?->name ?? '—' }}
        </div>
    </div>

    <div class="col-md-6 mb-4">
        <label class="form-label text-muted small">
            SKU
        </label>
        <div class="fw-medium">
            {{ $inventory->product?->sku ?? '—' }}
        </div>
    </div>

    <div class="col-md-6 mb-4">
        <label class="form-label text-muted small">
            Variant
        </label>
        <div class="fw-medium">
            @if ($inventory->variant)
                @forelse ($inventory->variant->values as $value)
                    <span class="d-block">
                        <small class="text-muted">
                            {{ $value->attribute?->name }}:
                        </small>
                        {{ $value->attributeValue?->value }}
                    </span>
                @empty
                    <span class="text-muted">Variant</span>
                @endforelse
            @else
                Default
            @endif
        </div>
    </div>

    <div class="col-md-6 mb-4">
        <label class="form-label">
            Reserved Stock
        </label>
        <input
            type="number"
            class="form-control"
            value="{{ $inventory->reserved_stock }}"
            readonly
        >
        <small class="text-muted">
            Reserved stock is managed automatically.
        </small>
    </div>

    <div class="col-md-6 mb-4">
        <label for="stock" class="form-label">
            Stock <span class="text-danger">*</span>
        </label>
        <input
            type="number"
            id="stock"
            name="stock"
            class="form-control @error('stock') is-invalid @enderror"
            value="{{ old('stock', $inventory->stock) }}"
            min="0"
            required
        >
        @error('stock')
            <div class="invalid-feedback">
                {{ $message }}
            </div>
        @enderror
    </div>

    <div class="col-md-6 mb-4">
        <label for="low_stock_alert" class="form-label">
            Low Stock Alert <span class="text-danger">*</span>
        </label>
        <input
            type="number"
            id="low_stock_alert"
            name="low_stock_alert"
            class="form-control @error('low_stock_alert') is-invalid @enderror"
            value="{{ old('low_stock_alert', $inventory->low_stock_alert) }}"
            min="0"
            required
        >
        @error('low_stock_alert')
            <div class="invalid-feedback">
                {{ $message }}
            </div>
        @enderror
    </div>

    <div class="col-md-6 mb-4">
        <label class="form-label text-muted small">
            Available Stock
        </label>
        <div class="fw-medium">
            {{ $inventory->available_stock }}
        </div>
    </div>
</div>