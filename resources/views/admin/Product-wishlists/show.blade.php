@extends('layouts.admin')

@section('title', 'Product Wishlist Details')

@section('content')
<div class="container">
    <div class="page-inner">
        <x-admin.breadcrumb
            :items="[
                [
                    'label' => 'Product Wishlists',
                    'url' => route('admin.product-wishlists.index'),
                ],
                [
                    'label' => 'Details',
                ],
            ]"
        />

        <x-admin.alert />

        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <div class="d-flex align-items-center">
                            <div>
                                <h4 class="card-title mb-1">
                                    Product Wishlist Details
                                </h4>
                                <p class="text-muted mb-0">
                                    View customer wishlist information
                                </p>
                            </div>

                            <a
                                href="{{ route('admin.product-wishlists.index') }}"
                                class="btn btn-secondary btn-round ms-auto"
                            >
                                Back
                            </a>
                        </div>
                    </div>

                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6 mb-4">
                                <label class="form-label text-muted small">
                                    Product
                                </label>

                                <div class="d-flex align-items-center">
                                    @if ($wishlist->product?->thumbnail)
                                        <img
                                            src="{{ asset('storage/' . $wishlist->product->thumbnail) }}"
                                            alt="{{ $wishlist->product->name }}"
                                            class="rounded me-3"
                                            style="width:60px;height:60px;object-fit:cover;"
                                        >
                                    @else
                                        <div
                                            class="rounded bg-light d-flex align-items-center justify-content-center me-3"
                                            style="width:60px;height:60px;"
                                        >
                                            <i class="fas fa-image text-muted"></i>
                                        </div>
                                    @endif

                                    <div>
                                        <div class="fw-semibold">
                                            {{ $wishlist->product?->name ?? '—' }}
                                        </div>

                                        @if ($wishlist->product?->sku)
                                            <small class="text-muted">
                                                SKU: {{ $wishlist->product->sku }}
                                            </small>
                                        @endif
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-6 mb-4">
                                <label class="form-label text-muted small">
                                    Customer
                                </label>

                                <div class="fw-medium">
                                    {{ $wishlist->user?->name ?? '—' }}
                                </div>

                                @if ($wishlist->user?->email)
                                    <small class="text-muted">
                                        {{ $wishlist->user->email }}
                                    </small>
                                @endif
                            </div>

                            <div class="col-md-6 mb-4">
                                <label class="form-label text-muted small">
                                    Added To Wishlist
                                </label>

                                <div class="fw-medium">
                                    {{ $wishlist->created_at?->format('M d, Y h:i A') ?? '—' }}
                                </div>
                            </div>

                            <div class="col-md-6 mb-4">
                                <label class="form-label text-muted small">
                                    Last Updated
                                </label>

                                <div class="fw-medium">
                                    {{ $wishlist->updated_at?->format('M d, Y h:i A') ?? '—' }}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection