<div class="row">
    <div class="col-lg-8">
        <div class="card border shadow-none mb-4">
            <div class="card-header">
                <h5 class="card-title mb-0">Coupon Information</h5>
            </div>
            <div class="card-body">
                <div class="form-group mb-3">
                    <label for="code">
                        Coupon Code <span class="text-danger">*</span>
                    </label>
                    <input
                        type="text"
                        name="code"
                        id="code"
                        class="form-control @error('code') is-invalid @enderror"
                        value="{{ old('code', $coupon->code ?? '') }}"
                        placeholder="e.g. SAVE20"
                    >
                    @error('code')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group mb-3">
                            <label for="type">
                                Coupon Type <span class="text-danger">*</span>
                            </label>
                            <select
                                name="type"
                                id="type"
                                class="form-control @error('type') is-invalid @enderror"
                            >
                                <option value="percentage" @selected(old('type', $coupon->type ?? '') === 'percentage')>
                                    Percentage (%)
                                </option>
                                <option value="fixed" @selected(old('type', $coupon->type ?? '') === 'fixed')>
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
                                Coupon Value <span class="text-danger">*</span>
                            </label>
                            <input
                                type="number"
                                name="value"
                                id="value"
                                min="0"
                                step="0.01"
                                class="form-control @error('value') is-invalid @enderror"
                                value="{{ old('value', $coupon->value ?? '') }}"
                                placeholder="Enter coupon value"
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
                                value="{{ old('minimum_order_amount', $coupon->minimum_order_amount ?? 0) }}"
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
                                value="{{ old('maximum_discount', $coupon->maximum_discount ?? '') }}"
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
                                value="{{ old('starts_at', isset($coupon->starts_at) ? $coupon->starts_at->format('Y-m-d\TH:i') : '') }}"
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
                                value="{{ old('ends_at', isset($coupon->ends_at) ? $coupon->ends_at->format('Y-m-d\TH:i') : '') }}"
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
                <h5 class="card-title mb-0">Usage Limits</h5>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group mb-0">
                            <label for="usage_limit">
                                Usage Limit
                            </label>
                            <input
                                type="number"
                                name="usage_limit"
                                id="usage_limit"
                                min="1"
                                class="form-control @error('usage_limit') is-invalid @enderror"
                                value="{{ old('usage_limit', $coupon->usage_limit ?? '') }}"
                                placeholder="Leave empty for unlimited"
                            >
                            @error('usage_limit')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <small class="text-muted">
                                Maximum number of times this coupon can be used.
                            </small>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="form-group mb-0">
                            <label for="usage_limit_per_customer">
                                Usage Limit Per Customer
                            </label>
                            <input
                                type="number"
                                name="usage_limit_per_customer"
                                id="usage_limit_per_customer"
                                min="1"
                                class="form-control @error('usage_limit_per_customer') is-invalid @enderror"
                                value="{{ old('usage_limit_per_customer', $coupon->usage_limit_per_customer ?? '') }}"
                                placeholder="Leave empty for unlimited"
                            >
                            @error('usage_limit_per_customer')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <small class="text-muted">
                                Maximum number of times one customer can use this coupon.
                            </small>
                        </div>
                    </div>
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
                        @checked(old('status', $coupon->status ?? true))
                    >
                    <label class="form-check-label" for="status">
                        Active
                    </label>
                </div>
            </div>
        </div>
    </div>
</div>