@extends('layouts.admin')

@section('title', 'Product Review Details')

@section('content')
<div class="container">
    <div class="page-inner">
        <x-admin.breadcrumb
            :items="[
                [
                    'label' => 'Product Reviews',
                    'url' => route('admin.product-reviews.index'),
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
                                    Product Review Details
                                </h4>
                                <p class="text-muted mb-0">
                                    View product review information
                                </p>
                            </div>

                            <div class="ms-auto d-flex gap-2">
                                @can('product-reviews.edit')
                                    <a
                                        href="{{ route('admin.product-reviews.edit', $review) }}"
                                        class="btn btn-primary btn-round"
                                    >
                                        <i class="fa fa-edit me-1"></i>
                                        Edit
                                    </a>
                                @endcan

                                <a
                                    href="{{ route('admin.product-reviews.index') }}"
                                    class="btn btn-secondary btn-round"
                                >
                                    Back
                                </a>
                            </div>
                        </div>
                    </div>

                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6 mb-4">
                                <label class="form-label text-muted small">
                                    Product
                                </label>
                                <div class="d-flex align-items-center">
                                    @if ($review->product?->thumbnail)
                                        <img
                                            src="{{ asset('storage/' . $review->product->thumbnail) }}"
                                            alt="{{ $review->product->name }}"
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
                                            {{ $review->product?->name ?? '—' }}
                                        </div>
                                        @if ($review->product?->sku)
                                            <small class="text-muted">
                                                SKU: {{ $review->product->sku }}
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
                                    {{ $review->user?->name ?? '—' }}
                                </div>
                                @if ($review->user?->email)
                                    <small class="text-muted">
                                        {{ $review->user->email }}
                                    </small>
                                @endif
                            </div>

                            <div class="col-md-4 mb-4">
                                <label class="form-label text-muted small">
                                    Rating
                                </label>
                                <div class="text-warning fs-5">
                                    @for ($i = 1; $i <= 5; $i++)
                                        <i class="fa fa-star{{ $i <= $review->rating ? '' : '-o' }}"></i>
                                    @endfor
                                </div>
                                <small class="text-muted">
                                    {{ $review->rating }}/5
                                </small>
                            </div>

                            <div class="col-md-4 mb-4">
                                <label class="form-label text-muted small">
                                    Verification
                                </label>
                                <div>
                                    @if ($review->is_verified)
                                        <span class="badge bg-success">
                                            Verified
                                        </span>
                                    @else
                                        <span class="badge bg-secondary">
                                            Unverified
                                        </span>
                                    @endif
                                </div>
                            </div>

                            <div class="col-md-4 mb-4">
                                <label class="form-label text-muted small">
                                    Status
                                </label>
                                <div>
                                    @if ($review->status)
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

                            <div class="col-md-12 mb-4">
                                <label class="form-label text-muted small">
                                    Review Title
                                </label>
                                <div class="fw-semibold">
                                    {{ $review->title ?: '—' }}
                                </div>
                            </div>

                            <div class="col-md-12 mb-4">
                                <label class="form-label text-muted small">
                                    Review
                                </label>
                                <div class="border rounded p-3">
                                    {!! nl2br(e($review->review ?: 'No review text provided.')) !!}
                                </div>
                            </div>

                            @if ($review->images->isNotEmpty())
                                <div class="col-md-12">
                                    <label class="form-label text-muted small">
                                        Customer Review Images
                                    </label>
                                    <div class="d-flex flex-wrap gap-3">
                                        @foreach ($review->images as $image)
                                            <div>
                                                <img
                                                    src="{{ asset('storage/' . $image->image) }}"
                                                    alt="Customer review image"
                                                    class="rounded border"
                                                    style="width:120px;height:120px;object-fit:cover;"
                                                >
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection