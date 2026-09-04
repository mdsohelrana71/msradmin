@extends('layouts.admin')

@section('title', 'Product Compare Details')

@section('content')
<div class="container">
    <div class="page-inner">
        <x-admin.breadcrumb
            :items="[
                [
                    'label' => 'Product Compares',
                    'url' => route('admin.product-compares.index'),
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
                                    Product Compare Details
                                </h4>
                                <p class="text-muted mb-0">
                                    View customer's compared products
                                </p>
                            </div>

                            <a
                                href="{{ route('admin.product-compares.index') }}"
                                class="btn btn-secondary btn-round ms-auto"
                            >
                                Back
                            </a>
                        </div>
                    </div>

                    <div class="card-body">
                        <div class="mb-4">
                            <label class="form-label text-muted small">
                                Customer
                            </label>

                            <div class="fw-semibold">
                                {{ $compare['user']?->name ?? '—' }}
                            </div>

                            @if ($compare['user']?->email)
                                <small class="text-muted">
                                    {{ $compare['user']->email }}
                                </small>
                            @endif
                        </div>

                        <div class="mb-3">
                            <label class="form-label text-muted small">
                                Compared Products
                            </label>
                        </div>

                        <div class="row">
                            @forelse ($compare['products'] as $product)
                                <div class="col-md-4 col-lg-3 mb-4">
                                    <div class="border rounded p-3 h-100">
                                        @if ($product->thumbnail)
                                            <img
                                                src="{{ asset('storage/' . $product->thumbnail) }}"
                                                alt="{{ $product->name }}"
                                                class="rounded w-100 mb-3"
                                                style="height:180px;object-fit:cover;"
                                            >
                                        @else
                                            <div
                                                class="rounded bg-light d-flex align-items-center justify-content-center w-100 mb-3"
                                                style="height:180px;"
                                            >
                                                <i class="fas fa-image fa-2x text-muted"></i>
                                            </div>
                                        @endif

                                        <h5 class="mb-1">
                                            {{ $product->name }}
                                        </h5>

                                        @if ($product->sku)
                                            <small class="text-muted d-block">
                                                SKU: {{ $product->sku }}
                                            </small>
                                        @endif
                                    </div>
                                </div>
                            @empty
                                <div class="col-md-12">
                                    <div class="text-center py-5">
                                        <i class="fas fa-exchange-alt fa-3x text-muted mb-3"></i>

                                        <h5 class="text-muted">
                                            No compared products found
                                        </h5>
                                    </div>
                                </div>
                            @endforelse
                        </div>

                        @if ($compare['compares']->isNotEmpty())
                            <div class="mt-2">
                                <label class="form-label text-muted small">
                                    Compare Started
                                </label>

                                <div class="fw-medium">
                                    {{ $compare['compares']->min('created_at')?->format('M d, Y h:i A') ?? '—' }}
                                </div>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection