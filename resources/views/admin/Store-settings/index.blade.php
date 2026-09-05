@extends('layouts.admin')

@section('title', 'Store Settings')

@section('content')
<div class="container">
    <div class="page-inner">
        <x-admin.breadcrumb
            :items="[
                [
                    'label' => 'Store Settings',
                ],
            ]"
        />

        <x-admin.alert />

        <form
            action="{{ route('admin.store-settings.update') }}"
            method="POST"
        >
            @csrf
            @method('PUT')

            <div class="row">

                {{-- ===================== Discount Settings ===================== --}}
                <div class="col-lg-4 mb-4">
                    <div class="card border-0 shadow-sm h-100">
                        <div class="card-body p-4">
                            <div class="d-flex align-items-center mb-4">
                                <div class="rounded-circle bg-primary text-white d-flex align-items-center justify-content-center me-3"
                                     style="width: 42px; height: 42px;">
                                    <i class="fa fa-percent"></i>
                                </div>
                                <div>
                                    <h5 class="fw-bold mb-0">Discount Settings</h5>
                                    <small class="text-muted">Configure default discount type and value</small>
                                </div>
                            </div>

                            <div class="mb-3">
                                <label for="discount_type" class="form-label">Discount Type</label>
                                <select name="discount_type" id="discount_type"
                                        class="form-select @error('discount_type') is-invalid @enderror">
                                    <option value="percentage"
                                        @selected(old('discount_type', $storeSettings['discount_type']) === 'percentage')>
                                        Percentage (%)
                                    </option>
                                    <option value="fixed"
                                        @selected(old('discount_type', $storeSettings['discount_type']) === 'fixed')>
                                        Fixed Amount
                                    </option>
                                </select>
                                @error('discount_type')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div>
                                <label for="discount_value" class="form-label">Default Discount Value</label>
                                <input type="number" name="discount_value" id="discount_value"
                                       min="0" step="0.01"
                                       class="form-control @error('discount_value') is-invalid @enderror"
                                       value="{{ old('discount_value', $storeSettings['discount_value']) }}">
                                @error('discount_value')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>
                </div>

                {{-- ===================== Delivery Settings ===================== --}}
                <div class="col-lg-4 mb-4">
                    <div class="card border-0 shadow-sm h-100">
                        <div class="card-body p-4">
                            <div class="d-flex align-items-center mb-4">
                                <div class="rounded-circle bg-success text-white d-flex align-items-center justify-content-center me-3"
                                     style="width: 42px; height: 42px;">
                                    <i class="fa fa-truck"></i>
                                </div>
                                <div>
                                    <h5 class="fw-bold mb-0">Delivery Settings</h5>
                                    <small class="text-muted">Set delivery charge and free delivery threshold</small>
                                </div>
                            </div>

                            <div class="mb-3">
                                <label for="delivery_charge" class="form-label">Delivery Charge</label>
                                <input type="number" name="delivery_charge" id="delivery_charge"
                                       min="0" step="0.01"
                                       class="form-control @error('delivery_charge') is-invalid @enderror"
                                       value="{{ old('delivery_charge', $storeSettings['delivery_charge']) }}">
                                @error('delivery_charge')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div>
                                <label for="free_delivery_amount" class="form-label">Free Delivery Above</label>
                                <input type="number" name="free_delivery_amount" id="free_delivery_amount"
                                       min="0" step="0.01"
                                       class="form-control @error('free_delivery_amount') is-invalid @enderror"
                                       value="{{ old('free_delivery_amount', $storeSettings['free_delivery_amount']) }}"
                                       placeholder="Leave empty to disable">
                                @error('free_delivery_amount')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>
                </div>

                {{-- ===================== Product Review Settings ===================== --}}
                <div class="col-lg-4 mb-4">
                    <div class="card border-0 shadow-sm h-100">
                        <div class="card-body p-4">
                            <div class="d-flex align-items-center mb-4">
                                <div class="rounded-circle bg-info text-white d-flex align-items-center justify-content-center me-3"
                                     style="width: 42px; height: 42px;">
                                    <i class="fa fa-star"></i>
                                </div>
                                <div>
                                    <h5 class="fw-bold mb-0">Product Review Settings</h5>
                                    <small class="text-muted">Control product review functionality</small>
                                </div>
                            </div>

                            <div class="mb-3">
                                <div class="form-check form-switch">
                                    <input type="hidden" name="product_review_enabled" value="0">
                                    <input type="checkbox" name="product_review_enabled" value="1"
                                           id="product_review_enabled" class="form-check-input"
                                           @checked(old('product_review_enabled', $storeSettings['product_review_enabled']))>
                                    <label class="form-check-label" for="product_review_enabled">
                                        Enable Product Reviews
                                    </label>
                                </div>
                            </div>

                            <div>
                                <div class="form-check form-switch">
                                    <input type="hidden" name="review_requires_approval" value="0">
                                    <input type="checkbox" name="review_requires_approval" value="1"
                                           id="review_requires_approval" class="form-check-input"
                                           @checked(old('review_requires_approval', $storeSettings['review_requires_approval']))>
                                    <label class="form-check-label" for="review_requires_approval">
                                        Require Admin Approval
                                    </label>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- ===================== Tax Settings ===================== --}}
                <div class="col-lg-4 mb-4">
                    <div class="card border-0 shadow-sm h-100">
                        <div class="card-body p-4">
                            <div class="d-flex align-items-center mb-4">
                                <div class="rounded-circle bg-warning text-white d-flex align-items-center justify-content-center me-3"
                                     style="width: 42px; height: 42px;">
                                    <i class="fa fa-receipt"></i>
                                </div>
                                <div>
                                    <h5 class="fw-bold mb-0">Tax Settings</h5>
                                    <small class="text-muted">Configure tax calculation for orders</small>
                                </div>
                            </div>

                            <div class="mb-3">
                                <div class="form-check form-switch">
                                    <input type="hidden" name="tax_enabled" value="0">
                                    <input type="checkbox" name="tax_enabled" value="1"
                                           id="tax_enabled" class="form-check-input"
                                           @checked(old('tax_enabled', $storeSettings['tax_enabled']))>
                                    <label class="form-check-label" for="tax_enabled">
                                        Enable Tax
                                    </label>
                                </div>
                            </div>

                            <div class="mb-3">
                                <label for="tax_type" class="form-label">Tax Type</label>
                                <select name="tax_type" id="tax_type"
                                        class="form-select @error('tax_type') is-invalid @enderror">
                                    <option value="percentage"
                                        @selected(old('tax_type', $storeSettings['tax_type']) === 'percentage')>
                                        Percentage (%)
                                    </option>
                                    <option value="fixed"
                                        @selected(old('tax_type', $storeSettings['tax_type']) === 'fixed')>
                                        Fixed Amount
                                    </option>
                                </select>
                                @error('tax_type')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div>
                                <label for="tax_value" class="form-label">Tax Value</label>
                                <input type="number" name="tax_value" id="tax_value"
                                       min="0" step="0.01"
                                       class="form-control @error('tax_value') is-invalid @enderror"
                                       value="{{ old('tax_value', $storeSettings['tax_value']) }}">
                                @error('tax_value')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>
                </div>

            </div>

            {{-- ===================== Save Button ===================== --}}
            <x-admin.form-actions
                submitText="Save Settings"
            />

        </form>
    </div>
</div>
@endsection