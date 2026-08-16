@extends('layouts.admin')

@section('title', 'View Product')

@section('content')
<div class="container">
    <div class="page-inner">
        <x-admin.breadcrumb
            :items="[
                [
                    'label' => 'Products',
                    'url' => route('admin.products.index'),
                ],
                [
                    'label' => 'View Product',
                ],
            ]"
            :action="[
                'label' => 'Edit Product',
                'url' => route('admin.products.edit', $product),
                'icon' => 'fa fa-edit',
                'permission' => 'products.edit',
            ]"
        />

        <x-admin.alert />

        <div class="row">
            {{-- Left Column --}}
            <div class="col-lg-8">
                {{-- Product Details --}}
                <div class="card border shadow-none mb-4">
                    <div class="card-header">
                        <h4 class="card-title mb-0">Product Details</h4>
                    </div>

                    <div class="card-body">
                        {{-- Name --}}
                        <div class="border rounded p-3 mb-3">
                            <h6 class="text-muted mb-2">
                                <i class="fa fa-tag me-1"></i>
                                Product Name
                            </h6>
                            <h2 class="mb-0">{{ $product->name }}</h2>
                        </div>

                        {{-- SKU & Barcode --}}
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <div class="border rounded p-3 h-100">
                                    <h6 class="text-muted mb-2">
                                        <i class="fa fa-barcode me-1"></i>
                                        SKU
                                    </h6>
                                    <div class="fw-medium">{{ $product->sku ?: '—' }}</div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="border rounded p-3 h-100">
                                    <h6 class="text-muted mb-2">
                                        <i class="fa fa-qrcode me-1"></i>
                                        Barcode
                                    </h6>
                                    <div class="fw-medium">{{ $product->barcode ?: '—' }}</div>
                                </div>
                            </div>
                        </div>

                        {{-- Short Description --}}
                        <div class="border rounded p-3 mb-3">
                            <h6 class="text-muted mb-2">
                                <i class="fa fa-align-left me-1"></i>
                                Short Description
                            </h6>
                            <p class="mb-0 text-muted">
                                {{ $product->short_description ?: '—' }}
                            </p>
                        </div>

                        {{-- Description --}}
                        <div class="border rounded p-3">
                            <h6 class="text-muted mb-3">
                                <i class="fa fa-file-alt me-1"></i>
                                Description
                            </h6>
                            <div class="product-content">
                                {!! $product->description ?: '<span class="text-muted">—</span>' !!}
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Pricing --}}
                <div class="card border shadow-none mb-4">
                    <div class="card-header">
                        <h5 class="card-title mb-0">Product Pricing</h5>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-4">
                                <div class="border rounded p-3 text-center">
                                    <h6 class="text-muted mb-2">Cost Price</h6>
                                    <div class="fs-5 fw-semibold">
                                        {{ number_format($product->cost_price ?? 0, 2) }}
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="border rounded p-3 text-center">
                                    <h6 class="text-muted mb-2">Selling Price</h6>
                                    <div class="fs-5 fw-semibold text-success">
                                        {{ number_format($product->selling_price ?? 0, 2) }}
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="border rounded p-3 text-center">
                                    <h6 class="text-muted mb-2">Discount Price</h6>
                                    <div class="fs-5 fw-semibold text-danger">
                                        {{ $product->discount_price !== null ? number_format($product->discount_price, 2) : '—' }}
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Dimensions --}}
                <div class="card border shadow-none mb-4">
                    <div class="card-header">
                        <h5 class="card-title mb-0">Product Dimensions</h5>
                    </div>
                    <div class="card-body">
                        <div class="border rounded p-3">
                            <h6 class="text-muted mb-2">
                                <i class="fa fa-weight-hanging me-1"></i>
                                Weight
                            </h6>
                            <div>
                                {{ $product->weight !== null ? $product->weight : '—' }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Right Column --}}
            <div class="col-lg-4">
                {{-- Product Settings / Info --}}
                <div class="card border shadow-none mb-4">
                    <div class="card-header">
                        <h5 class="card-title mb-0">Product Information</h5>
                    </div>
                    <div class="card-body">
                        {{-- Category --}}
                        <div class="border rounded p-3 mb-3">
                            <h6 class="text-muted mb-2">
                                <i class="fa fa-folder me-1"></i>
                                Category
                            </h6>
                            @if ($product->category)
                                <span class="badge bg-info">{{ $product->category->name }}</span>
                            @else
                                <span class="text-muted">—</span>
                            @endif
                        </div>

                        {{-- Brand --}}
                        <div class="border rounded p-3 mb-3">
                            <h6 class="text-muted mb-2">
                                <i class="fa fa-copyright me-1"></i>
                                Brand
                            </h6>
                            @if ($product->brand)
                                <span class="badge bg-secondary">{{ $product->brand->name }}</span>
                            @else
                                <span class="text-muted">—</span>
                            @endif
                        </div>

                        {{-- Tags --}}
                        <div class="border rounded p-3 mb-3">
                            <h6 class="text-muted mb-2">
                                <i class="fa fa-tags me-1"></i>
                                Tags
                            </h6>
                            @if ($product->tags->isNotEmpty())
                                <div class="gap-1">
                                    @foreach ($product->tags as $tag)
                                        <span class="badge bg-light text-dark">
                                            {{ ucfirst($tag->name) }}
                                        </span>
                                    @endforeach
                                </div>
                            @else
                                <span class="text-muted">—</span>
                            @endif
                        </div>

                        {{-- Stock & Unit --}}
                        <div class="row mb-3">
                            <div class="col-6">
                                <div class="border rounded p-3 h-100">
                                    <h6 class="text-muted mb-2">Stock</h6>
                                    <div class="fw-medium">{{ $product->stock ?? 0 }}</div>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="border rounded p-3 h-100">
                                    <h6 class="text-muted mb-2">Unit</h6>
                                    <div class="fw-medium">{{ $product->unit ?? 'pcs' }}</div>
                                </div>
                            </div>
                        </div>

                        {{-- Status --}}
                        <div class="border rounded p-3 mb-3">
                            <h6 class="text-muted mb-2">
                                <i class="fa fa-circle-check me-1"></i>
                                Status
                            </h6>
                            @if ($product->status)
                                <span class="badge bg-success">Active</span>
                            @else
                                <span class="badge bg-secondary">Inactive</span>
                            @endif
                        </div>

                        {{-- Featured --}}
                        <div class="border rounded p-3 mb-3">
                            <h6 class="text-muted mb-2">
                                <i class="fa fa-star me-1"></i>
                                Featured
                            </h6>
                            @if ($product->is_featured)
                                <span class="badge bg-warning text-dark">Yes</span>
                            @else
                                <span class="badge bg-light text-dark">No</span>
                            @endif
                        </div>

                        {{-- Created --}}
                        <div class="border rounded p-3">
                            <h6 class="text-muted mb-2">
                                <i class="fa fa-clock me-1"></i>
                                Created
                            </h6>
                            <div>
                                {{ $product->created_at?->format('d M Y, h:i A') ?? '—' }}
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Thumbnail --}}
                <div class="card border shadow-none mb-4">
                    <div class="card-header">
                        <h5 class="card-title mb-0">Product Image</h5>
                    </div>
                    <div class="card-body">
                        @if ($product->thumbnail)
                            <img
                                src="{{ asset('storage/' . $product->thumbnail) }}"
                                alt="{{ $product->name }}"
                                class="img-fluid rounded"
                                style="max-height: 280px; width: 100%; object-fit: contain;"
                            >
                        @else
                            <div class="text-center py-4 text-muted">
                                <i class="fas fa-image fa-2x mb-2"></i>
                                <div>No image</div>
                            </div>
                        @endif
                    </div>
                </div>

                {{-- Actions --}}
                <div class="card border shadow-none">
                    <div class="card-header">
                        <h5 class="card-title mb-0">Actions</h5>
                    </div>
                    <div class="card-body">
                        <div class="d-flex gap-2">
                            @can('products.edit')
                                <a
                                    href="{{ route('admin.products.edit', $product) }}"
                                    class="btn btn-primary"
                                >
                                    <i class="fa fa-edit me-1"></i>
                                    Edit
                                </a>
                            @endcan

                            <a
                                href="{{ route('admin.products.index') }}"
                                class="btn btn-light"
                            >
                                <i class="fa fa-arrow-left me-1"></i>
                                Back
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection