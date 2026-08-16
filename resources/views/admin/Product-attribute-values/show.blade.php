@extends('layouts.admin')

@section('title', 'View Brand')

@section('content')
<div class="container">
    <div class="page-inner">
        <x-admin.breadcrumb
            :items="[
                [
                    'label' => 'Brands',
                    'url' => route('admin.brands.index'),
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
                            <div class="d-flex align-items-center">
                                <div
                                    class="rounded-circle bg-primary text-white d-flex align-items-center justify-content-center me-3"
                                    style="width: 52px; height: 52px;">
                                    <i class="fa fa-tags fs-5"></i>
                                </div>

                                <div>
                                    <h4 class="card-title mb-1 fw-bold">
                                        Brand Details
                                    </h4>

                                    <p class="text-muted mb-0 small">
                                        View brand information and details
                                    </p>
                                </div>
                            </div>

                            <div class="ms-auto d-flex gap-2">
                                @can('brands.edit')
                                    <a
                                        href="{{ route('admin.brands.edit', $brand) }}"
                                        class="btn btn-primary btn-round">
                                        <i class="fa fa-edit me-1"></i>
                                        Edit
                                    </a>
                                @endcan

                                <a
                                    href="{{ route('admin.brands.index') }}"
                                    class="btn btn-secondary btn-round">
                                    <i class="fa fa-arrow-left me-1"></i>
                                    Back
                                </a>
                            </div>
                        </div>
                    </div>

                    {{-- Body --}}
                    <div class="card-body p-4">

                        {{-- Brand Information --}}
                        <div class="card border-0 shadow-sm rounded-4 mb-4 overflow-hidden">
                            {{-- Header --}}
                            <div class="card-header bg-white border-0 pt-4 px-4 pb-0">
                                <div class="d-flex align-items-center">
                                    <div class="rounded-circle bg-primary bg-opacity-10 text-white d-flex align-items-center justify-content-center me-3"
                                        style="width: 42px; height: 42px;">
                                        <i class="fa fa-tags"></i>
                                    </div>
                                    <div>
                                        <h5 class="fw-bold mb-0">Brand Information</h5>
                                        <small class="text-muted">Basic details of the brand</small>
                                    </div>
                                </div>
                            </div>

                            <div class="card-body p-4">
                                <div class="row g-4 align-items-center">

                                    {{-- Brand Logo --}}
                                    <div class="col-md-3 col-lg-2">
                                        <small class="text-muted d-block mb-2 fw-medium">Brand Logo</small>

                                        @if ($brand->logo)
                                            <div class="border rounded-3 bg-light d-flex align-items-center justify-content-center p-3"
                                                style="width: 130px; height: 100px;">
                                                <img src="{{ asset('storage/' . $brand->logo) }}"
                                                    alt="{{ $brand->name }}"
                                                    class="img-fluid"
                                                    style="max-height: 80px; object-fit: contain;">
                                            </div>
                                        @else
                                            <div class="border rounded-3 bg-light d-flex align-items-center justify-content-center"
                                                style="width: 130px; height: 100px;">
                                                <i class="fa fa-tags fa-2x text-muted opacity-50"></i>
                                            </div>
                                        @endif
                                    </div>

                                    {{-- Brand Name & Slug --}}
                                    <div class="col-md-3 col-lg-3">
                                        <small class="text-muted d-block mb-1 fw-medium">Brand Name</small>
                                        <div class="fw-semibold fs-5 mb-1">
                                            {{ $brand->name }}
                                        </div>
                                        <code class="text-muted small bg-light px-2 py-1 rounded">
                                            {{ $brand->slug }}
                                        </code>
                                    </div>

                                    {{-- Status --}}
                                    <div class="col-md-2 col-lg-2">
                                        <small class="text-muted d-block mb-2 fw-medium">Status</small>
                                        @if ($brand->status)
                                            <span class="badge rounded-pill bg-success-subtle text-success px-3 py-2">
                                                <i class="fa fa-check-circle me-1"></i> Active
                                            </span>
                                        @else
                                            <span class="badge rounded-pill bg-warning-subtle text-warning px-3 py-2">
                                                <i class="fa fa-pause-circle me-1"></i> Inactive
                                            </span>
                                        @endif
                                    </div>

                                    {{-- Sort Order --}}
                                    <div class="col-md-2 col-lg-2">
                                        <small class="text-muted d-block mb-1 fw-medium">Sort Order</small>
                                        <div class="fw-semibold">
                                            <span class="badge bg-light text-dark border px-3 py-2">
                                                {{ $brand->sort_order }}
                                            </span>
                                        </div>
                                    </div>

                                    {{-- Created & Updated --}}
                                    <div class="col-md-2 col-lg-3">
                                        <div class="row g-3">
                                            <div class="col-6">
                                                <small class="text-muted d-block mb-1 fw-medium">Created</small>
                                                <div class="fw-semibold small">
                                                    {{ $brand->created_at->format('d M, Y') }}
                                                    <div class="text-muted" style="font-size: 12px;">
                                                        {{ $brand->created_at->format('h:i A') }}
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-6">
                                                <small class="text-muted d-block mb-1 fw-medium">Last Updated</small>
                                                <div class="fw-semibold small">
                                                    {{ $brand->updated_at->format('d M, Y') }}
                                                    <div class="text-muted" style="font-size: 12px;">
                                                        {{ $brand->updated_at->format('h:i A') }}
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                </div>
                            </div>
                        </div>

                        {{-- Description --}}
                        <div class="border rounded-3 p-4">
                            <div class="d-flex align-items-center mb-3">
                                <div
                                    class="rounded-circle bg-info text-white d-flex align-items-center justify-content-center me-2"
                                    style="width: 36px; height: 36px;">
                                    <i class="fa fa-align-left"></i>
                                </div>

                                <div>
                                    <h5 class="fw-bold mb-0">
                                        Description
                                    </h5>

                                    <small class="text-muted">
                                        Brand description
                                    </small>
                                </div>
                            </div>

                            @if ($brand->description)
                                <div class="text-muted">
                                    {!! nl2br(e($brand->description)) !!}
                                </div>
                            @else
                                <div class="text-center py-4">
                                    <div
                                        class="rounded-circle bg-secondary text-white d-flex align-items-center justify-content-center mx-auto mb-3"
                                        style="width: 55px; height: 55px;">
                                        <i class="fa fa-align-left"></i>
                                    </div>

                                    <h6 class="fw-semibold">
                                        No Description
                                    </h6>

                                    <p class="text-muted small mb-0">
                                        This brand does not have a description.
                                    </p>
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