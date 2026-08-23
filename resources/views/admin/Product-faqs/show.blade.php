@extends('layouts.admin')

@section('title', 'View Product FAQ')

@section('content')
<div class="container">
    <div class="page-inner">
        <x-admin.breadcrumb
            :items="[
                [
                    'label' => 'Product FAQs',
                    'url' => route('admin.product-faqs.index'),
                ],
                [
                    'label' => 'View',
                ],
            ]"
        />

        <div class="row justify-content-center">
            <div class="col-12">
                <div class="card border-0 shadow-sm">
                    {{-- Header --}}
                    <div class="card-header bg-white border-0 p-4">
                        <div class="d-flex align-items-center">
                            <div>
                                <h4 class="card-title mb-1 fw-bold">
                                    Product FAQ Details
                                </h4>
                                <p class="text-muted mb-0 small">
                                    View FAQ information and assigned products
                                </p>
                            </div>
                            <div class="ms-auto d-flex gap-2">
                                @can('product-faqs.edit')
                                    <a
                                        href="{{ route('admin.product-faqs.edit', $faq) }}"
                                        class="btn btn-primary btn-round"
                                    >
                                        <i class="fa fa-edit me-1"></i>
                                        Edit
                                    </a>
                                @endcan
                                <a
                                    href="{{ route('admin.product-faqs.index') }}"
                                    class="btn btn-secondary btn-round"
                                >
                                    <i class="fa fa-arrow-left me-1"></i>
                                    Back
                                </a>
                            </div>
                        </div>
                    </div>

                    {{-- Body --}}
                    <div class="card-body p-4">
                        {{-- FAQ Information --}}
                        <div class="card border-0 shadow-sm rounded-4 mb-4 overflow-hidden">
                            <div class="card-header bg-white border-0">
                                <div class="d-flex align-items-center">
                                    <div
                                        class="rounded-circle bg-primary bg-opacity-10 text-primary d-flex align-items-center justify-content-center me-3"
                                        style="width: 42px; height: 42px;"
                                    >
                                        <i class="fa fa-question-circle text-white"></i>
                                    </div>
                                    <div>
                                        <h5 class="fw-bold mb-0">
                                            FAQ Information
                                        </h5>
                                        <small class="text-muted">
                                            Basic FAQ details
                                        </small>
                                    </div>
                                </div>
                            </div>
                            <div class="card-body p-4">
                                <div class="row g-4">
                                    {{-- Question --}}
                                    <div class="col-md-8">
                                        <small class="text-muted d-block mb-1 fw-medium">
                                            Question
                                        </small>
                                        <div class="fw-semibold fs-5">
                                            {{ $faq->question }}
                                        </div>
                                    </div>

                                    {{-- Status --}}
                                    <div class="col-md-2">
                                        <small class="text-muted d-block mb-2 fw-medium">
                                            Status
                                        </small>
                                        @if ($faq->status)
                                            <span class="badge rounded-pill bg-success-subtle text-success px-3 py-2">
                                                <i class="fa fa-check-circle me-1"></i>
                                                Active
                                            </span>
                                        @else
                                            <span class="badge rounded-pill bg-warning-subtle text-warning px-3 py-2">
                                                <i class="fa fa-pause-circle me-1"></i>
                                                Inactive
                                            </span>
                                        @endif
                                    </div>

                                    {{-- Sort Order --}}
                                    <div class="col-md-2">
                                        <small class="text-muted d-block mb-1 fw-medium">
                                            Sort Order
                                        </small>
                                        <span class="badge bg-light text-dark border px-3 py-2">
                                            {{ $faq->sort_order }}
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div>

                        {{-- Answer --}}
                        <div class="border rounded-3 p-4 mb-4">
                            <div class="d-flex align-items-center mb-3">
                                <div
                                    class="rounded-circle bg-info text-white d-flex align-items-center justify-content-center me-2"
                                    style="width: 36px; height: 36px;"
                                >
                                    <i class="fa fa-align-left"></i>
                                </div>
                                <div>
                                    <h5 class="fw-bold mb-0">
                                        Answer
                                    </h5>
                                    <small class="text-muted">
                                        FAQ answer
                                    </small>
                                </div>
                            </div>
                            <div class="text-muted">
                                {!! nl2br(e($faq->answer)) !!}
                            </div>
                        </div>
 
                        {{-- Products --}}
                        <div class="border rounded-3 p-4">
                            <div class="d-flex align-items-center mb-3">
                                <div
                                    class="rounded-circle bg-info text-white d-flex align-items-center justify-content-center me-2"
                                    style="width: 36px; height: 36px;"
                                >
                                    <i class="fa fa-box"></i>
                                </div>
                                <div>
                                    <h5 class="fw-bold mb-0">
                                        Products
                                    </h5>
                                    <small class="text-muted">
                                        Products assigned to this FAQ
                                    </small>
                                </div>
                            </div>

                            @forelse ($faq->products as $product)
                                <span class="badge bg-info me-1 mb-1 px-3 py-2">
                                    {{ $product->name }}
                                </span>
                            @empty
                                <div class="text-center py-4">
                                    <div
                                        class="rounded-circle bg-secondary text-white d-flex align-items-center justify-content-center mx-auto mb-3"
                                        style="width: 55px; height: 55px;"
                                    >
                                        <i class="fa fa-box"></i>
                                    </div>
                                    <h6 class="fw-semibold">
                                        No Products
                                    </h6>
                                    <p class="text-muted small mb-0">
                                        No products are assigned to this FAQ.
                                    </p>
                                </div>
                            @endforelse
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection