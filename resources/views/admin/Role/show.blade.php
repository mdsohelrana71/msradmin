@extends('layouts.admin')

@section('title', 'View Role')

@section('content')
<div class="container">
    <div class="page-inner">

        {{-- Breadcrumb --}}
        <div class="page-header">
            <ul class="breadcrumbs">
                <li class="nav-home">
                    <a href="{{ route('admin.dashboard') }}">
                        <i class="icon-home"></i>
                    </a>
                </li>
                <li class="separator">
                    <i class="icon-arrow-right"></i>
                </li>
                <li class="nav-item">
                    <a href="{{ route('admin.roles.index') }}">Roles</a>
                </li>
                <li class="separator">
                    <i class="icon-arrow-right"></i>
                </li>
                <li class="nav-item">
                    <a href="#">View</a>
                </li>
            </ul>
        </div>

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
                                    <i class="fa fa-user-shield fs-5"></i>
                                </div>

                                <div>
                                    <h4 class="card-title mb-1 fw-bold">
                                        Role Details
                                    </h4>

                                    <p class="text-muted mb-0 small">
                                        View role information and assigned permissions
                                    </p>
                                </div>
                            </div>

                            <div class="ms-auto d-flex gap-2">
                                @can('update', $role)
                                    <a
                                        href="{{ route('admin.roles.edit', $role) }}"
                                        class="btn btn-warning btn-round">
                                        <i class="fa fa-edit me-1"></i>
                                        Edit
                                    </a>
                                @endcan

                                <a
                                    href="{{ route('admin.roles.index') }}"
                                    class="btn btn-secondary btn-round">
                                    <i class="fa fa-arrow-left me-1"></i>
                                    Back
                                </a>
                            </div>
                        </div>
                    </div>

                    {{-- Body --}}
                    <div class="card-body p-4">
                        {{-- Role Information --}}
                        <div class="border rounded-3 p-4 mb-4">
                            <div class="d-flex align-items-center mb-3">
                                <div
                                    class="rounded-circle bg-primary text-white d-flex align-items-center justify-content-center me-2"
                                    style="width: 36px; height: 36px;">
                                    <i class="fa fa-id-badge"></i>
                                </div>

                                <h5 class="fw-bold mb-0">
                                    Role Information
                                </h5>
                            </div>

                            <div class="row">
                                <div class="col-md-6 mb-3 mb-md-0">
                                    <small class="text-muted d-block mb-1">
                                        Role Name
                                    </small>
                                    <div class="fw-semibold">
                                        <span class="badge bg-primary fs-6 px-3 py-2">
                                            {{ ucfirst($role->name) }}
                                        </span>
                                    </div>
                                </div>

                                <div class="col-md-3">
                                    <small class="text-muted d-block mb-1">
                                        Created
                                    </small>
                                    <span class="fw-semibold">
                                        {{ $role->created_at->format('Y-m-d H:i') }}
                                    </span>
                                </div>

                                <div class="col-md-3">
                                    <small class="text-muted d-block mb-1">
                                        Last Updated
                                    </small>

                                    <span class="fw-semibold">
                                        {{ $role->updated_at->format('Y-m-d H:i') }}
                                    </span>
                                </div>
                            </div>
                        </div>

                        {{-- Permissions --}}
                        <div class="border rounded-3 p-4">
                            <div class="d-flex align-items-center justify-content-between mb-3">
                                <div class="d-flex align-items-center">
                                    <div
                                        class="rounded-circle bg-info text-white d-flex align-items-center justify-content-center me-2"
                                        style="width: 36px; height: 36px;">
                                        <i class="fa fa-key"></i>
                                    </div>

                                    <div>
                                        <h5 class="fw-bold mb-0">
                                            Permissions
                                        </h5>

                                        <small class="text-muted">
                                            Permissions assigned to this role
                                        </small>
                                    </div>
                                </div>

                                <span class="badge bg-info text-dark px-3 py-2">
                                    {{ $role->permissions->count() }}
                                    {{ Str::plural('Permission', $role->permissions->count()) }}
                                </span>
                            </div>

                            @if($role->permissions->isEmpty())
                                <div class="text-center py-5">
                                    <div
                                        class="rounded-circle bg-secondary text-white d-flex align-items-center justify-content-center mx-auto mb-3"
                                        style="width: 65px; height: 65px;">
                                        <i class="fa fa-lock fs-4"></i>
                                    </div>

                                    <h6 class="fw-semibold">
                                        No Permissions Assigned
                                    </h6>

                                    <p class="text-muted small mb-0">
                                        This role currently has no permissions.
                                    </p>
                                </div>
                            @else

                            <div class="row g-3">
                                @foreach($role->permissions as $permission)
                                    <div class="col-md-6">
                                        <div class="border rounded-3 p-3 d-flex align-items-center h-100">
                                            <div
                                                class="rounded-circle bg-success text-white d-flex align-items-center justify-content-center me-3"
                                                style="width: 38px; height: 38px;">
                                                <i class="fa fa-check"></i>
                                            </div>

                                            <div>
                                                <div class="fw-semibold">
                                                    {{ $permission->name }}
                                                </div>
                                                <small class="text-muted">
                                                    Permission granted
                                                </small>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
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