@extends('layouts.admin')

@section('title', 'Inventory Details')

@section('content')
<div class="container">
    <div class="page-inner">
        <x-admin.breadcrumb
            :items="[
                [
                    'label' => 'Product Inventory',
                    'url' => route('admin.product-inventory.index'),
                ],
                [
                    'label' => 'Inventory Details',
                ],
            ]"
            :action="auth()->user()->can('product-inventory.edit') ? [
                'label' => 'Edit Inventory',
                'url' => route('admin.product-inventory.edit', $inventory),
                'icon' => 'fa fa-edit',
                'permission' => 'product-inventory.edit',
            ] : null"
        />

        <x-admin.alert />

        <div class="card">
            <div class="card-header">
                <div>
                    <h4 class="card-title mb-1">Inventory Details</h4>
                    <p class="text-muted mb-0">
                        View product inventory information
                    </p>
                </div>
            </div>

            <div class="card-body">
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
                            {{ $inventory->variant?->name ?? 'Default' }}
                        </div>
                    </div>

                    <div class="col-md-6 mb-4">
                        <label class="form-label text-muted small">
                            On Hand
                        </label>
                        <div class="fw-medium">
                            {{ $inventory->stock }}
                        </div>
                    </div>

                    <div class="col-md-6 mb-4">
                        <label class="form-label text-muted small">
                            Reserved
                        </label>
                        <div class="fw-medium">
                            {{ $inventory->reserved_stock }}
                        </div>
                    </div>

                    <div class="col-md-6 mb-4">
                        <label class="form-label text-muted small">
                            Available
                        </label>
                        <div class="fw-medium">
                            {{ $inventory->available_stock }}
                        </div>
                    </div>

                    <div class="col-md-6 mb-4">
                        <label class="form-label text-muted small">
                            Low Stock Alert
                        </label>
                        <div class="fw-medium">
                            {{ $inventory->low_stock_alert }}
                        </div>
                    </div>

                    <div class="col-md-6 mb-4">
                        <label class="form-label text-muted small">
                            Status
                        </label>
                        <div>
                            @if($inventory->stock_status === 'out_of_stock')
                                <span class="badge bg-danger">Out of Stock</span>
                            @elseif($inventory->stock_status === 'low_stock')
                                <span class="badge bg-warning text-dark">Low Stock</span>
                            @else
                                <span class="badge bg-success">In Stock</span>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection