@extends('layouts.admin')

@section('title', 'Discount Details')

@section('content')
<div class="container">
    <div class="page-inner">
        <x-admin.breadcrumb
            :items="[
                [
                    'label' => 'Discounts',
                    'url' => route('admin.discounts.index'),
                ],
                [
                    'label' => 'Discount Details',
                ],
            ]"
        />

        <x-admin.alert />

        <div class="row">
            <div class="col-lg-8">
                <div class="card mb-4">
                    <div class="card-header">
                        <div class="d-flex align-items-center">
                            <h4 class="card-title mb-0">Discount Information</h4>

                            @can('discounts.edit')
                                <a
                                    href="{{ route('admin.discounts.edit', $discount) }}"
                                    class="btn btn-primary btn-round ms-auto"
                                >
                                    <i class="fa fa-edit me-1"></i>
                                    Edit
                                </a>
                            @endcan
                        </div>
                    </div>

                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6 mb-4">
                                <label class="form-label text-muted small mb-1">
                                    Discount Name
                                </label>
                                <div class="fw-semibold">
                                    {{ $discount->name }}
                                </div>
                            </div>

                            <div class="col-md-3 mb-4">
                                <label class="form-label text-muted small mb-1">
                                    Type
                                </label>
                                <div>
                                    <span class="badge bg-light text-dark">
                                        {{ ucfirst($discount->type) }}
                                    </span>
                                </div>
                            </div>

                            <div class="col-md-3 mb-4">
                                <label class="form-label text-muted small mb-1">
                                    Value
                                </label>
                                <div class="fw-semibold">
                                    @if($discount->type === 'percentage')
                                        {{ number_format($discount->value, 2) }}%
                                    @else
                                        {{ number_format($discount->value, 2) }}
                                    @endif
                                </div>
                            </div>

                            <div class="col-md-6 mb-4">
                                <label class="form-label text-muted small mb-1">
                                    Minimum Order Amount
                                </label>
                                <div class="fw-semibold">
                                    {{ number_format($discount->minimum_order_amount, 2) }}
                                </div>
                            </div>

                            <div class="col-md-6 mb-4">
                                <label class="form-label text-muted small mb-1">
                                    Maximum Discount
                                </label>
                                <div class="fw-semibold">
                                    {{ $discount->maximum_discount !== null ? number_format($discount->maximum_discount, 2) : 'Unlimited' }}
                                </div>
                            </div>

                            <div class="col-md-6 mb-4">
                                <label class="form-label text-muted small mb-1">
                                    Starts At
                                </label>
                                <div class="fw-semibold">
                                    {{ $discount->starts_at ? $discount->starts_at->format('d M Y, h:i A') : 'Immediately' }}
                                </div>
                            </div>

                            <div class="col-md-6 mb-4">
                                <label class="form-label text-muted small mb-1">
                                    Ends At
                                </label>
                                <div class="fw-semibold">
                                    {{ $discount->ends_at ? $discount->ends_at->format('d M Y, h:i A') : 'No expiry' }}
                                </div>
                            </div>

                            <div class="col-md-4">
                                <label class="form-label text-muted small mb-1">
                                    Priority
                                </label>
                                <div class="fw-semibold">
                                    {{ $discount->priority }}
                                </div>
                            </div>

                            <div class="col-md-4">
                                <label class="form-label text-muted small mb-1">
                                    Allow Coupon
                                </label>
                                <div>
                                    <span class="badge {{ $discount->allow_coupon ? 'bg-success' : 'bg-secondary' }}">
                                        {{ $discount->allow_coupon ? 'Yes' : 'No' }}
                                    </span>
                                </div>
                            </div>

                            <div class="col-md-4">
                                <label class="form-label text-muted small mb-1">
                                    Status
                                </label>
                                <div>
                                    <span class="badge {{ $discount->status ? 'bg-success' : 'bg-secondary' }}">
                                        {{ $discount->status ? 'Active' : 'Inactive' }}
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="card mb-4">
                    <div class="card-header">
                        <h4 class="card-title mb-0">Applicable Products</h4>
                    </div>

                    <div class="card-body">
                        @if($discount->products->count())
                            <div class="list-group list-group-flush">
                                @foreach($discount->products as $product)
                                    <div class="list-group-item px-0 d-flex justify-content-between align-items-center">
                                        <div>
                                            <div class="fw-semibold">
                                                {{ $product->name }}
                                            </div>

                                            @if(isset($product->sku))
                                                <small class="text-muted">
                                                    SKU: {{ $product->sku }}
                                                </small>
                                            @endif
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        @else
                            <div class="text-muted">
                                <i class="fa fa-store me-1"></i>
                                This discount applies to the entire store or is category-based.
                            </div>
                        @endif
                    </div>
                </div>

                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title mb-0">Applicable Categories</h4>
                    </div>

                    <div class="card-body">
                        @if($discount->categories->count())
                            <div class="d-flex flex-wrap gap-2">
                                @foreach($discount->categories as $category)
                                    <span class="badge bg-light text-dark border px-3 py-2">
                                        {{ $category->name }}
                                    </span>
                                @endforeach
                            </div>
                        @else
                            <div class="text-muted">
                                No specific categories selected.
                            </div>
                        @endif
                    </div>
                </div>
            </div>

            <div class="col-lg-4">
                <div class="card mb-4">
                    <div class="card-header">
                        <h4 class="card-title mb-0">Summary</h4>
                    </div>

                    <div class="card-body">
                        <div class="d-flex justify-content-between mb-3">
                            <span class="text-muted">Products</span>
                            <span class="fw-semibold">
                                {{ $discount->products->count() }}
                            </span>
                        </div>

                        <div class="d-flex justify-content-between mb-3">
                            <span class="text-muted">Categories</span>
                            <span class="fw-semibold">
                                {{ $discount->categories->count() }}
                            </span>
                        </div>

                        <div class="d-flex justify-content-between mb-3">
                            <span class="text-muted">Priority</span>
                            <span class="fw-semibold">
                                {{ $discount->priority }}
                            </span>
                        </div>

                        <div class="d-flex justify-content-between">
                            <span class="text-muted">Status</span>
                            <span class="badge {{ $discount->status ? 'bg-success' : 'bg-secondary' }}">
                                {{ $discount->status ? 'Active' : 'Inactive' }}
                            </span>
                        </div>
                    </div>
                </div>

                <div class="card">
                    <div class="card-body">
                        <a
                            href="{{ route('admin.discounts.index') }}"
                            class="btn btn-secondary btn-round w-100"
                        >
                            <i class="fa fa-arrow-left me-1"></i>
                            Back to Discounts
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection