@extends('layouts.admin')

@section('title', 'Coupon Details')

@section('content')
<div class="container">
    <div class="page-inner">
        <x-admin.breadcrumb
            :items="[
                [
                    'label' => 'Coupons',
                    'url' => route('admin.coupons.index'),
                ],
                [
                    'label' => 'Coupon Details',
                ],
            ]"
        />
        <x-admin.alert />

        <div class="row">
            <div class="col-lg-8">
                <div class="card border shadow-none mb-4">
                    <div class="card-header">
                        <div class="d-flex align-items-center">
                            <h5 class="card-title mb-0">Coupon Information</h5>
                            @can('coupons.edit')
                                <a
                                    href="{{ route('admin.coupons.edit', $coupon) }}"
                                    class="btn btn-primary btn-sm ms-auto"
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
                                    Coupon Code
                                </label>
                                <div class="fw-semibold fs-5">
                                    {{ $coupon->code }}
                                </div>
                            </div>

                            <div class="col-md-6 mb-4">
                                <label class="form-label text-muted small mb-1">
                                    Status
                                </label>
                                <div>
                                    @if ($coupon->status)
                                        <span class="badge bg-success">
                                            Active
                                        </span>
                                    @else
                                        <span class="badge bg-warning">
                                            Inactive
                                        </span>
                                    @endif
                                </div>
                            </div>

                            <div class="col-md-6 mb-4">
                                <label class="form-label text-muted small mb-1">
                                    Coupon Type
                                </label>
                                <div class="fw-medium">
                                    {{ ucfirst($coupon->type) }}
                                </div>
                            </div>

                            <div class="col-md-6 mb-4">
                                <label class="form-label text-muted small mb-1">
                                    Coupon Value
                                </label>
                                <div class="fw-medium">
                                    @if ($coupon->type === 'percentage')
                                        {{ number_format($coupon->value, 2) }}%
                                    @else
                                        {{ number_format($coupon->value, 2) }}
                                    @endif
                                </div>
                            </div>

                            <div class="col-md-6 mb-4">
                                <label class="form-label text-muted small mb-1">
                                    Minimum Order Amount
                                </label>
                                <div class="fw-medium">
                                    {{ number_format($coupon->minimum_order_amount, 2) }}
                                </div>
                            </div>

                            <div class="col-md-6 mb-4">
                                <label class="form-label text-muted small mb-1">
                                    Maximum Discount
                                </label>
                                <div class="fw-medium">
                                    @if ($coupon->maximum_discount !== null)
                                        {{ number_format($coupon->maximum_discount, 2) }}
                                    @else
                                        <span class="text-muted">Unlimited</span>
                                    @endif
                                </div>
                            </div>

                            <div class="col-md-6 mb-4">
                                <label class="form-label text-muted small mb-1">
                                    Starts At
                                </label>
                                <div class="fw-medium">
                                    {{ $coupon->starts_at?->format('d M Y, h:i A') ?? 'No start date' }}
                                </div>
                            </div>

                            <div class="col-md-6 mb-4">
                                <label class="form-label text-muted small mb-1">
                                    Ends At
                                </label>
                                <div class="fw-medium">
                                    {{ $coupon->ends_at?->format('d M Y, h:i A') ?? 'No expiry date' }}
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
                                <label class="form-label text-muted small mb-1">
                                    Total Usage Limit
                                </label>
                                <div class="fw-medium">
                                    {{ $coupon->usage_limit ?? 'Unlimited' }}
                                </div>
                            </div>

                            <div class="col-md-6">
                                <label class="form-label text-muted small mb-1">
                                    Per Customer Limit
                                </label>
                                <div class="fw-medium">
                                    {{ $coupon->usage_limit_per_customer ?? 'Unlimited' }}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-lg-4">
                <div class="card border shadow-none mb-4">
                    <div class="card-header">
                        <h5 class="card-title mb-0">Summary</h5>
                    </div>
                    <div class="card-body">
                        <div class="mb-3">
                            <div class="text-muted small">
                                Created At
                            </div>
                            <div class="fw-medium">
                                {{ $coupon->created_at->format('d M Y, h:i A') }}
                            </div>
                        </div>

                        <div class="mb-3">
                            <div class="text-muted small">
                                Last Updated
                            </div>
                            <div class="fw-medium">
                                {{ $coupon->updated_at->format('d M Y, h:i A') }}
                            </div>
                        </div>

                        <div>
                            <div class="text-muted small">
                                Coupon Status
                            </div>
                            <div class="fw-medium">
                                @if ($coupon->status)
                                    Currently Active
                                @else
                                    Currently Inactive
                                @endif
                            </div>
                        </div>
                    </div>
                </div>

                <a
                    href="{{ route('admin.coupons.index') }}"
                    class="btn btn-secondary"
                >
                    <i class="fas fa-arrow-left me-1"></i>
                    Back to Coupons
                </a>
            </div>
        </div>
    </div>
</div>
@endsection