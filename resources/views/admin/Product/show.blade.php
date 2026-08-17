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
            {{-- ==================== LEFT COLUMN ==================== --}}
            <div class="col-lg-8">

                {{-- Product Content --}}
                <div class="card border shadow-none mb-4">
                    <div class="card-header">
                        <h5 class="card-title mb-0">Product Content</h5>
                    </div>
                    <div class="card-body">
                        <div class="mb-4">
                            <label class="form-label text-muted small mb-1">Product Name</label>
                            <h3 class="mb-0">{{ $product->name }}</h3>
                        </div>

                        <div class="row mb-4">
                            <div class="col-md-6">
                                <label class="form-label text-muted small mb-1">SKU</label>
                                <div class="fw-medium">{{ $product->sku ?: '—' }}</div>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label text-muted small mb-1">Barcode</label>
                                <div class="fw-medium">{{ $product->barcode ?: '—' }}</div>
                            </div>
                        </div>

                        <div class="mb-4">
                            <label class="form-label text-muted small mb-1">Short Description</label>
                            <p class="mb-0">
                                {{ $product->short_description ?: '—' }}
                            </p>
                        </div>

                        <div>
                            <label class="form-label text-muted small mb-2">Description</label>
                            <div class="product-content border rounded p-3 bg-light bg-opacity-50">
                                {!! $product->description ?: '<span class="text-muted">—</span>' !!}
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Product Pricing --}}
                <div class="card border shadow-none mb-4">
                    <div class="card-header">
                        <h5 class="card-title mb-0">Product Pricing</h5>
                    </div>
                    <div class="card-body">
                        <div class="row g-3">
                            <div class="col-md-4">
                                <div class="border rounded p-3 h-100 text-center">
                                    <label class="form-label text-muted small mb-2 d-block">Cost Price</label>
                                    <div class="fs-5 fw-semibold">
                                        {{ number_format($product->cost_price ?? 0, 2) }}
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="border rounded p-3 h-100 text-center">
                                    <label class="form-label text-muted small mb-2 d-block">Selling Price</label>
                                    <div class="fs-5 fw-semibold text-success">
                                        {{ number_format($product->selling_price ?? 0, 2) }}
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="border rounded p-3 h-100 text-center">
                                    <label class="form-label text-muted small mb-2 d-block">Discount Price</label>
                                    <div class="fs-5 fw-semibold text-danger">
                                        {{ $product->discount_price !== null ? number_format($product->discount_price, 2) : '—' }}
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Inventory & Stock --}}
                <div class="card border shadow-none mb-4">
                    <div class="card-header">
                        <h5 class="card-title mb-0">Inventory & Stock</h5>
                    </div>
                    <div class="card-body">
                        <div class="row g-3">
                            <div class="col-md-4">
                                <div class="border rounded p-3 h-100 text-center">
                                    <label class="form-label text-muted small mb-2 d-block">Stock</label>
                                    <div class="fs-5 fw-semibold">{{ $product->stock ?? 0 }}</div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="border rounded p-3 h-100 text-center">
                                    <label class="form-label text-muted small mb-2 d-block">Unit</label>
                                    <div class="fs-5 fw-semibold">{{ $product->unit ?? 'pcs' }}</div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="border rounded p-3 h-100 text-center">
                                    <label class="form-label text-muted small mb-2 d-block">Weight</label>
                                    <div class="fs-5 fw-semibold">
                                        {{ $product->weight !== null ? $product->weight : '—' }}
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Product Gallery --}}
                <div class="card border shadow-none mb-4">
                    <div class="card-header">
                        <h5 class="card-title mb-0">Product Gallery</h5>
                    </div>
                    <div class="card-body">
                        @if ($product->images && $product->images->count())
                            <div class="row g-3">
                                @foreach ($product->images as $image)
                                    <div class="col-6 col-md-4 col-lg-3">
                                        <div class="border rounded-3 p-2 bg-light bg-opacity-50 text-center">
                                            <img src="{{ asset('storage/' . $image->image) }}"
                                                 alt="{{ $image->alt ?? $product->name }}"
                                                 class="rounded-3 img-fluid"
                                                 style="height: 140px; object-fit: cover; width: 100%;">
                                            @if ($image->alt)
                                                <small class="d-block text-muted mt-2 text-truncate">
                                                    {{ $image->alt }}
                                                </small>
                                            @endif
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        @else
                            <div class="text-center py-5 text-muted">
                                <i class="fa fa-image fa-2x mb-2 opacity-50"></i>
                                <p class="mb-0 small">No gallery images added</p>
                            </div>
                        @endif
                    </div>
                </div>
            </div>

            {{-- ==================== RIGHT COLUMN ==================== --}}
            <div class="col-lg-4">

                {{-- Product Settings --}}
                <div class="card border shadow-none mb-4">
                    <div class="card-header">
                        <h5 class="card-title mb-0">Product Settings</h5>
                    </div>
                    <div class="card-body">
                        <div class="mb-3">
                            <label class="form-label text-muted small mb-1">Category</label>
                            <div>
                                @if ($product->category)
                                    <span class="badge bg-info">{{ $product->category->name }}</span>
                                @else
                                    <span class="text-muted">—</span>
                                @endif
                            </div>
                        </div>

                        <div class="mb-3">
                            <label class="form-label text-muted small mb-1">Brand</label>
                            <div>
                                @if ($product->brand)
                                    <span class="badge bg-secondary">{{ $product->brand->name }}</span>
                                @else
                                    <span class="text-muted">—</span>
                                @endif
                            </div>
                        </div>

                        <div class="mb-3">
                            <label class="form-label text-muted small mb-1">Tags</label>
                            <div>
                                @if ($product->tags->isNotEmpty())
                                    <div class="gap-1">
                                        @foreach ($product->tags as $tag)
                                            <span class="badge bg-light text-dark border">
                                                {{ ucfirst($tag->name) }}
                                            </span>
                                        @endforeach
                                    </div>
                                @else
                                    <span class="text-muted">—</span>
                                @endif
                            </div>
                        </div>

                        <div class="mb-3">
                            <label class="form-label text-muted small mb-1">Status</label>
                            <div>
                                @if ($product->status)
                                    <span class="badge bg-success">Active</span>
                                @else
                                    <span class="badge bg-secondary">Inactive</span>
                                @endif
                            </div>
                        </div>

                        <div class="mb-3">
                            <label class="form-label text-muted small mb-1">Featured Product</label>
                            <div>
                                @if ($product->is_featured)
                                    <span class="badge bg-warning text-dark">
                                        <i class="fa fa-star me-1"></i> Yes
                                    </span>
                                @else
                                    <span class="badge bg-light text-dark border">No</span>
                                @endif
                            </div>
                        </div>

                        <div>
                            <label class="form-label text-muted small mb-1">Created</label>
                            <div class="fw-medium">
                                {{ $product->created_at?->format('d M Y, h:i A') ?? '—' }}
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Product Thumbnail --}}
                <div class="card border shadow-none mb-4">
                    <div class="card-header">
                        <h5 class="card-title mb-0">Product Thumbnail</h5>
                        <p class="mb-0 small text-muted">Main product image</p>
                    </div>
                    <div class="card-body text-center">
                        @if ($product->thumbnail)
                            <img src="{{ asset('storage/' . $product->thumbnail) }}"
                                 alt="{{ $product->name }}"
                                 class="img-fluid rounded"
                                 style="max-height: 260px; width: 100%; object-fit: contain;">
                        @else
                            <div class="text-center py-5 text-muted">
                                <i class="fa fa-image fa-3x mb-2 opacity-50"></i>
                                <p class="mb-0">No thumbnail</p>
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
                        <div class="d-grid gap-2">
                            @can('products.edit')
                                <a href="{{ route('admin.products.edit', $product) }}"
                                   class="btn btn-primary">
                                    <i class="fa fa-edit me-1"></i> Edit Product
                                </a>
                            @endcan

                            <a href="{{ route('admin.products.index') }}"
                               class="btn btn-light">
                                <i class="fa fa-arrow-left me-1"></i> Back to List
                            </a>
                        </div>
                    </div>
                </div>
            </div>

            {{-- ==================== VARIANTS (Full Width) ==================== --}}
            <div class="col-12">
                <div class="card border shadow-none mb-4">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h5 class="card-title mb-0">Product Variants</h5>
                        <span class="badge bg-primary">
                            {{ $product->variants->count() }} Variant(s)
                        </span>
                    </div>

                    <div class="card-body">
                        @if ($product->variants && $product->variants->count())
                            <div class="table-responsive">
                                <table class="table table-bordered table-hover align-middle mb-0">
                                    <thead class="table-light">
                                        <tr>
                                            <th style="width: 80px;">Image</th>
                                            <th>Variant Name</th>
                                            <th>SKU</th>
                                            <th class="text-end">Price</th>
                                            <th class="text-end">Discount</th>
                                            <th class="text-end">Stock</th>
                                            <th class="text-center">Status</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($product->variants as $variant)
                                            <tr>
                                                {{-- Image --}}
                                                <td>
                                                    @if ($variant->image)
                                                        <img src="{{ asset('storage/' . $variant->image) }}"
                                                             alt="Variant"
                                                             class="rounded border"
                                                             width="60"
                                                             height="60"
                                                             style="object-fit: cover;">
                                                    @else
                                                        <div class="bg-light rounded border d-flex align-items-center justify-content-center"
                                                             style="width: 60px; height: 60px;">
                                                            <i class="fa fa-image text-muted"></i>
                                                        </div>
                                                    @endif
                                                </td>

                                                {{-- Variant Name (Attribute combination) --}}
                                                <td>
                                                    @if ($variant->values && $variant->values->count())
                                                        <div class="text-center gap-1">
                                                            @foreach ($variant->values as $value)
                                                                <span class="badge bg-light text-dark border">
                                                                    <small class="text-muted">
                                                                        {{ $value->attribute->name ?? '' }}:
                                                                    </small>
                                                                    {{ $value->attributeValue->value ?? $value->attributeValue->name ?? '—' }}
                                                                </span>
                                                            @endforeach
                                                        </div>
                                                    @else
                                                        <span class="text-muted">—</span>
                                                    @endif
                                                </td>

                                                {{-- SKU --}}
                                                <td>{{ $variant->sku ?: '—' }}</td>

                                                {{-- Selling Price --}}
                                                <td class="text-center fw-semibold text-success">
                                                    {{ number_format($variant->selling_price ?? $variant->price ?? 0, 2) }}
                                                </td>

                                                {{-- Discount Price --}}
                                                <td class="text-center text-danger">
                                                    {{ $variant->discount_price !== null ? number_format($variant->discount_price, 2) : '—' }}
                                                </td>

                                                {{-- Stock --}}
                                                <td class="text-center">
                                                    {{ $variant->stock ?? 0 }}
                                                </td>

                                                {{-- Status --}}
                                                <td class="text-center">
                                                    @if ($variant->status ?? true)
                                                        <span class="badge bg-success">Active</span>
                                                    @else
                                                        <span class="badge bg-secondary">Inactive</span>
                                                    @endif
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        @else
                            <div class="text-center py-5 text-muted">
                                <i class="fa fa-layer-group fa-2x mb-2 opacity-50"></i>
                                <p class="mb-0">No variants found for this product</p>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection