@php
    $selectedProducts = old('products', $selectedProducts ?? []);
    $selectedCategories = old('categories', $selectedCategories ?? []);
@endphp

<div class="row">
    <div class="col-lg-8">
        <div class="card border shadow-none mb-4">
            <div class="card-header">
                <h5 class="card-title mb-0">Discount Information</h5>
            </div>
            <div class="card-body">
                <div class="form-group mb-3">
                    <label for="name">
                        Discount Name <span class="text-danger">*</span>
                    </label>
                    <input
                        type="text"
                        name="name"
                        id="name"
                        class="form-control @error('name') is-invalid @enderror"
                        value="{{ old('name', $discount->name ?? '') }}"
                        placeholder="Enter discount name"
                    >
                    @error('name')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group mb-3">
                            <label for="type">
                                Discount Type <span class="text-danger">*</span>
                            </label>
                            <select
                                name="type"
                                id="type"
                                class="form-control @error('type') is-invalid @enderror"
                            >
                                <option value="percentage" @selected(old('type', $discount->type ?? '') === 'percentage')>
                                    Percentage (%)
                                </option>
                                <option value="fixed" @selected(old('type', $discount->type ?? '') === 'fixed')>
                                    Fixed Amount
                                </option>
                            </select>
                            @error('type')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="form-group mb-3">
                            <label for="value">
                                Discount Value <span class="text-danger">*</span>
                            </label>
                            <input
                                type="number"
                                name="value"
                                id="value"
                                min="0"
                                step="0.01"
                                class="form-control @error('value') is-invalid @enderror"
                                value="{{ old('value', $discount->value ?? '') }}"
                                placeholder="Enter discount value"
                            >
                            @error('value')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group mb-3">
                            <label for="minimum_order_amount">
                                Minimum Order Amount
                            </label>
                            <input
                                type="number"
                                name="minimum_order_amount"
                                id="minimum_order_amount"
                                min="0"
                                step="0.01"
                                class="form-control @error('minimum_order_amount') is-invalid @enderror"
                                value="{{ old('minimum_order_amount', $discount->minimum_order_amount ?? 0) }}"
                                placeholder="0.00"
                            >
                            @error('minimum_order_amount')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="form-group mb-3">
                            <label for="maximum_discount">
                                Maximum Discount
                            </label>
                            <input
                                type="number"
                                name="maximum_discount"
                                id="maximum_discount"
                                min="0"
                                step="0.01"
                                class="form-control @error('maximum_discount') is-invalid @enderror"
                                value="{{ old('maximum_discount', $discount->maximum_discount ?? '') }}"
                                placeholder="Leave empty for unlimited"
                            >
                            @error('maximum_discount')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group mb-0">
                            <label for="starts_at">
                                Starts At
                            </label>
                            <input
                                type="datetime-local"
                                name="starts_at"
                                id="starts_at"
                                class="form-control @error('starts_at') is-invalid @enderror"
                                value="{{ old('starts_at', isset($discount->starts_at) ? $discount->starts_at->format('Y-m-d\TH:i') : '') }}"
                            >
                            @error('starts_at')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="form-group mb-0">
                            <label for="ends_at">
                                Ends At
                            </label>
                            <input
                                type="datetime-local"
                                name="ends_at"
                                id="ends_at"
                                class="form-control @error('ends_at') is-invalid @enderror"
                                value="{{ old('ends_at', isset($discount->ends_at) ? $discount->ends_at->format('Y-m-d\TH:i') : '') }}"
                            >
                            @error('ends_at')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="card border shadow-none mb-4">
            <div class="card-header">
                <h5 class="card-title mb-0">Apply To Products</h5>
            </div>
            <div class="card-body">
                <div class="form-group mb-0">
                    <label for="products">
                        Products
                    </label>
                    <select
                        name="products[]"
                        id="products"
                        class="form-control select2 @error('products') is-invalid @enderror"
                        multiple
                    >
                        @foreach ($products as $product)
                            <option
                                value="{{ $product->id }}"
                                @selected(in_array($product->id, $selectedProducts))
                            >
                                {{ $product->name }}
                            </option>
                        @endforeach
                    </select>
                    @error('products')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror
                    @error('products.*')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror
                    <small class="text-muted">
                        Select one or multiple products. Leave empty to apply to the entire store or selected categories.
                    </small>
                </div>
            </div>
        </div>

        <div class="card border shadow-none mb-4">
            <div class="card-header">
                <h5 class="card-title mb-0">Apply To Categories</h5>
            </div>
            <div class="card-body">
                <div class="form-group mb-0">
                    <label for="categories">
                        Product Categories
                    </label>
                    <select
                        name="categories[]"
                        id="categories"
                        class="form-control select2 @error('categories') is-invalid @enderror"
                        multiple
                    >
                        @foreach ($categories as $category)
                            <option
                                value="{{ $category->id }}"
                                @selected(in_array($category->id, $selectedCategories))
                            >
                                {{ $category->name }}
                            </option>
                        @endforeach
                    </select>
                    @error('categories')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror
                    @error('categories.*')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror
                    <small class="text-muted">
                        Select one or multiple product categories.
                    </small>
                </div>
            </div>
        </div>
    </div>

    <div class="col-lg-4">
        <div class="card border shadow-none mb-4">
            <div class="card-header">
                <h5 class="card-title mb-0">Settings</h5>
            </div>
            <div class="card-body">
                <div class="form-group mb-3">
                    <label for="priority">
                        Priority
                    </label>
                    <input
                        type="number"
                        name="priority"
                        id="priority"
                        min="0"
                        class="form-control @error('priority') is-invalid @enderror"
                        value="{{ old('priority', $discount->priority ?? 0) }}"
                    >
                    @error('priority')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                    <small class="text-muted">
                        Higher priority discounts are applied first.
                    </small>
                </div>

                <div class="form-check form-switch mb-3">
                    <input
                        type="hidden"
                        name="allow_coupon"
                        value="0"
                    >
                    <input
                        class="form-check-input"
                        type="checkbox"
                        name="allow_coupon"
                        value="1"
                        id="allow_coupon"
                        @checked(old('allow_coupon', $discount->allow_coupon ?? true))
                    >
                    <label class="form-check-label" for="allow_coupon">
                        Allow Coupon
                    </label>
                    <div class="small text-muted mt-1">
                        Allow coupon to be used with this discount.
                    </div>
                </div>

                <div class="form-check form-switch">
                    <input
                        type="hidden"
                        name="status"
                        value="0"
                    >
                    <input
                        class="form-check-input"
                        type="checkbox"
                        name="status"
                        value="1"
                        id="status"
                        @checked(old('status', $discount->status ?? true))
                    >
                    <label class="form-check-label" for="status">
                        Active
                    </label>
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
    $(document).ready(function() {
        $('.select2').select2({
            placeholder: 'Select options',
            allowClear: true,
            width: '100%'
        });
    });
</script>
@endpush