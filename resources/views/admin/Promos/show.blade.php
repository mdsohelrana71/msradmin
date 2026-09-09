@extends('layouts.admin')

@section('title', 'View Promo')

@section('content')
<div class="container">
    <div class="page-inner">
        <x-admin.breadcrumb
            :items="[
                [
                    'label' => 'Promos',
                    'url' => route('admin.promos.index'),
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
                                    <i class="fa fa-bullhorn fs-5"></i>
                                </div>

                                <div>
                                    <h4 class="card-title mb-1 fw-bold">
                                        Promo Details
                                    </h4>

                                    <p class="text-muted mb-0 small">
                                        View promo information and buttons
                                    </p>
                                </div>
                            </div>

                            <div class="ms-auto d-flex gap-2">
                                @can('promos.edit')
                                    <a
                                        href="{{ route('admin.promos.edit', $promo) }}"
                                        class="btn btn-primary btn-round">
                                        <i class="fa fa-edit me-1"></i>
                                        Edit
                                    </a>
                                @endcan

                                <a
                                    href="{{ route('admin.promos.index') }}"
                                    class="btn btn-secondary btn-round">
                                    <i class="fa fa-arrow-left me-1"></i>
                                    Back
                                </a>
                            </div>
                        </div>
                    </div>

                    {{-- Body --}}
                    <div class="card-body p-4">

                        {{-- Promo Information --}}
                        <div class="card border-0 shadow-sm rounded-4 mb-4 overflow-hidden">
                            <div class="card-header bg-white border-0 pt-4 px-4 pb-0">
                                <div class="d-flex align-items-center">
                                    <div
                                        class="rounded-circle bg-primary bg-opacity-10 text-white d-flex align-items-center justify-content-center me-3"
                                        style="width: 42px; height: 42px;">
                                        <i class="fa fa-bullhorn"></i>
                                    </div>

                                    <div>
                                        <h5 class="fw-bold mb-0">Promo Information</h5>
                                        <small class="text-muted">
                                            Basic details of the promotional banner
                                        </small>
                                    </div>
                                </div>
                            </div>

                            <div class="card-body p-4">
                                <div class="row g-4">

                                    {{-- Title --}}
                                    <div class="col-md-6 col-lg-5">
                                        <small class="text-muted d-block mb-1 fw-medium">
                                            Promo Text
                                        </small>

                                        <div class="fw-semibold fs-5">
                                            {{ $promo->title }}
                                        </div>
                                    </div>

                                    {{-- Status --}}
                                    <div class="col-md-3 col-lg-2">
                                        <small class="text-muted d-block mb-2 fw-medium">
                                            Status
                                        </small>

                                        @if ($promo->status)
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
                                    <div class="col-md-3 col-lg-2">
                                        <small class="text-muted d-block mb-1 fw-medium">
                                            Sort Order
                                        </small>

                                        <span class="badge bg-light text-dark border px-3 py-2">
                                            {{ $promo->sort_order }}
                                        </span>
                                    </div>

                                    {{-- Created & Updated --}}
                                    <div class="col-md-6 col-lg-3">
                                        <div class="row g-3">
                                            <div class="col-6">
                                                <small class="text-muted d-block mb-1 fw-medium">
                                                    Created
                                                </small>

                                                <div class="fw-semibold small">
                                                    {{ $promo->created_at->format('d M, Y') }}

                                                    <div class="text-muted" style="font-size: 12px;">
                                                        {{ $promo->created_at->format('h:i A') }}
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-6">
                                                <small class="text-muted d-block mb-1 fw-medium">
                                                    Last Updated
                                                </small>

                                                <div class="fw-semibold small">
                                                    {{ $promo->updated_at->format('d M, Y') }}

                                                    <div class="text-muted" style="font-size: 12px;">
                                                        {{ $promo->updated_at->format('h:i A') }}
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    {{-- Start Date --}}
                                    <div class="col-md-6">
                                        <small class="text-muted d-block mb-1 fw-medium">
                                            Start Date
                                        </small>

                                        @if ($promo->start_date)
                                            <div class="fw-semibold">
                                                {{ $promo->start_date->format('d M, Y') }}

                                                <span class="text-muted small">
                                                    {{ $promo->start_date->format('h:i A') }}
                                                </span>
                                            </div>
                                        @else
                                            <span class="text-muted">No start date</span>
                                        @endif
                                    </div>

                                    {{-- End Date --}}
                                    <div class="col-md-6">
                                        <small class="text-muted d-block mb-1 fw-medium">
                                            End Date
                                        </small>

                                        @if ($promo->end_date)
                                            <div class="fw-semibold">
                                                {{ $promo->end_date->format('d M, Y') }}

                                                <span class="text-muted small">
                                                    {{ $promo->end_date->format('h:i A') }}
                                                </span>
                                            </div>
                                        @else
                                            <span class="text-muted">No end date</span>
                                        @endif
                                    </div>

                                </div>
                            </div>
                        </div>

                        {{-- Description --}}
                        <div class="border rounded-3 p-4 mb-4">
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
                                        Promo description
                                    </small>
                                </div>
                            </div>

                            @if ($promo->description)
                                <div class="text-muted">
                                    {!! nl2br(e($promo->description)) !!}
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
                                        This promo does not have a description.
                                    </p>
                                </div>
                            @endif
                        </div>

                        {{-- Promo Buttons --}}
                        <div class="card border-0 shadow-sm rounded-4 overflow-hidden">
                            <div class="card-header bg-white border-0 pt-4 px-4 pb-0">
                                <div class="d-flex align-items-center">
                                    <div
                                        class="rounded-circle bg-success bg-opacity-10 text-white d-flex align-items-center justify-content-center me-3"
                                        style="width: 42px; height: 42px;">
                                        <i class="fa fa-link"></i>
                                    </div>

                                    <div>
                                        <h5 class="fw-bold mb-0">Promo Buttons</h5>
                                        <small class="text-muted">
                                            Buttons attached to this promo
                                        </small>
                                    </div>
                                </div>
                            </div>

                            <div class="card-body p-4">
                                @if ($promo->buttons->count())
                                    <div class="table-responsive">
                                        <table class="table table-hover align-middle mb-0">
                                            <thead>
                                                <tr>
                                                    <th width="60">#</th>
                                                    <th>Label</th>
                                                    <th>URL</th>
                                                    <th width="100">Order</th>
                                                    <th width="120">Status</th>
                                                </tr>
                                            </thead>

                                            <tbody>
                                                @foreach ($promo->buttons as $button)
                                                    <tr>
                                                        <td>{{ $loop->iteration }}</td>

                                                        <td>
                                                            <div class="fw-semibold">
                                                                {{ $button->label }}
                                                            </div>
                                                        </td>

                                                        <td>
                                                            <code>
                                                                {{ $button->url }}
                                                            </code>
                                                        </td>

                                                        <td>
                                                            <span class="badge bg-light text-dark border px-3 py-2">
                                                                {{ $button->sort_order }}
                                                            </span>
                                                        </td>

                                                        <td>
                                                            @if ($button->status)
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
                                                        </td>
                                                    </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                @else
                                    <div class="text-center py-5">
                                        <div
                                            class="rounded-circle bg-secondary text-white d-flex align-items-center justify-content-center mx-auto mb-3"
                                            style="width: 55px; height: 55px;">
                                            <i class="fa fa-link"></i>
                                        </div>

                                        <h6 class="fw-semibold">
                                            No Buttons
                                        </h6>

                                        <p class="text-muted small mb-0">
                                            This promo does not have any buttons.
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
</div>
@endsection