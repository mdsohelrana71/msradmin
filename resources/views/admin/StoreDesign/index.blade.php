@extends('layouts.admin')

@section('title', 'Store Design')

@section('content')

<div class="container">
    <div class="page-inner">
        <x-admin.breadcrumb
            :items="[
                [
                    'label' => 'Store Design',
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
                                <h4 class="card-title mb-1">Store Design</h4>
                                <p class="text-muted mb-0">Manage the design of your storefront sections.</p>
                            </div>
                        </div>
                    </div>

                    <div class="card-body">
                        <div class="row">
                            @foreach ($sections as $key => $section)
                                @php
                                    $selectedKey = $selectedDesigns[$key] ?? null;
                                    $selectedLabel = $section['designs'][$selectedKey] ?? 'Not Selected';
                                @endphp

                                <div class="col-md-6 col-xl-4 mb-4">
                                    <div class="card border shadow-sm h-100 mb-0">
                                        <div class="card-body d-flex flex-column">
                                            <div class="d-flex align-items-start justify-content-between mb-4">
                                                <div class="d-flex align-items-center">
                                                    <div
                                                        class="d-flex align-items-center justify-content-center rounded"
                                                        style="width: 46px;height: 46px;background: rgba(13, 110, 253, 0.1);"
                                                    >
                                                        <i class="fa fa-paint-brush text-primary"></i>
                                                    </div>

                                                    <div class="ms-3">
                                                        <h5 class="mb-1">{{ $section['label'] }}</h5>
                                                        <small class="text-muted">
                                                            {{ count($section['designs']) }} designs available
                                                        </small>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="p-3 rounded bg-light mb-4">
                                                <div class="d-flex align-items-center justify-content-between">
                                                    <div>
                                                        <small class="text-muted d-block mb-1">
                                                            Active Design
                                                        </small>
                                                        <span class="fw-semibold">
                                                            {{ $selectedLabel }}
                                                        </span>
                                                    </div>

                                                    <span class="badge bg-success">
                                                        Active
                                                    </span>
                                                </div>
                                            </div>

                                            <div class="mt-auto">
                                                <a
                                                    href="{{ route('admin.store-designs.edit', $key) }}"
                                                    class="btn btn-primary w-100"
                                                >
                                                    <i class="fa fa-paint-brush me-1"></i>
                                                    Manage Design
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection