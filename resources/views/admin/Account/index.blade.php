@extends('layouts.admin')

@section('title', 'My Profile')

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
                    <a href="{{ route('admin.accounts.index') }}">
                        My Profile
                    </a>
                </li>
            </ul>
        </div>

        <div class="row justify-content-center">
            <div class="col-12">
                <div class="card border-0 shadow-sm">
                    {{-- Profile Header --}}
                    <div class="card-body p-4">
                        <div class="d-flex align-items-center">
                            {{-- Avatar --}}
                            <div
                                class="rounded-circle bg-primary text-white d-flex align-items-center justify-content-center me-4"
                                style="width: 90px; height: 90px; font-size: 30px;">
                                @if(!empty($user->avatar))
                                <img
                                    src="{{ asset('storage/' . $user->avatar) }}"
                                    alt="{{ $user->name }}"
                                    class="rounded-circle"
                                    style="width: 90px; height: 90px; object-fit: cover;">
                                @else
                                {{ collect(explode(' ', trim($user->name)))
                                        ->filter()
                                        ->take(2)
                                        ->map(fn($word) => strtoupper(substr($word, 0, 1)))
                                        ->implode('') }}
                                @endif
                            </div>

                            {{-- Name --}}
                            <div>
                                <h3 class="fw-bold mb-1">
                                    {{ ucfirst($user->name) }}
                                </h3>
                                <p class="text-muted mb-2">
                                    {{ $user->email }}
                                </p>
                                <span class="badge bg-primary px-3 py-2">
                                    <i class="fa fa-user me-1"></i>
                                    {{ ucfirst(optional($user->assignedRole)->name ?? $user->role) }}
                                </span>
                                <span class="badge bg-success px-3 py-2 ms-1">
                                    <i class="fa fa-check-circle me-1"></i>
                                    {{ $user->is_active ? 'Active' : 'Inactive' }}
                                </span>
                            </div>

                            {{-- Edit Button --}}
                            <div class="ms-auto">
                                <a
                                    href="{{ route('admin.accounts.edit', $user) }}"
                                    class="btn btn-primary btn-round">
                                    <i class="fa fa-edit me-1"></i>
                                    Edit Profile
                                </a>
                            </div>
                        </div>
                    </div>

                    {{-- Divider --}}
                    <div class="border-top"></div>

                    {{-- Account Information --}}
                    <div class="card-body p-4">
                        <div class="d-flex align-items-center mb-4">
                            <div
                                class="rounded-circle bg-primary text-white d-flex align-items-center justify-content-center me-3"
                                style="width: 42px; height: 42px;">
                                <i class="fa fa-user"></i>
                            </div>
                            <div>
                                <h5 class="fw-bold mb-0">
                                    Account Information
                                </h5>
                                <small class="text-muted">
                                    Your personal account details
                                </small>
                            </div>
                        </div>

                        <div class="row g-4">
                            {{-- Name --}}
                            <div class="col-md-6">
                                <div class="border rounded-3 p-3 h-100">
                                    <div class="d-flex align-items-center">
                                        <div
                                            class="rounded-circle bg-primary text-white d-flex align-items-center justify-content-center me-3"
                                            style="width: 38px; height: 38px;">
                                            <i class="fa fa-user"></i>
                                        </div>
                                        <div>
                                            <small class="text-muted d-block">
                                                Full Name
                                            </small>

                                            <span class="fw-semibold">
                                                {{ ucfirst($user->name) }}
                                            </span>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            {{-- Email --}}
                            <div class="col-md-6">
                                <div class="border rounded-3 p-3 h-100">
                                    <div class="d-flex align-items-center">
                                        <div
                                            class="rounded-circle bg-info text-white d-flex align-items-center justify-content-center me-3"
                                            style="width: 38px; height: 38px;">
                                            <i class="fa fa-envelope"></i>
                                        </div>
                                        <div>
                                            <small class="text-muted d-block">
                                                Email Address
                                            </small>

                                            <span class="fw-semibold">
                                                {{ $user->email }}
                                            </span>
                                        </div>
                                    </div>
                                </div>
                            </div>


                            {{-- Phone --}}
                            <div class="col-md-6">
                                <div class="border rounded-3 p-3 h-100">
                                    <div class="d-flex align-items-center">
                                        <div
                                            class="rounded-circle bg-success text-white d-flex align-items-center justify-content-center me-3"
                                            style="width: 38px; height: 38px;">
                                            <i class="fa fa-phone"></i>
                                        </div>
                                        <div>
                                            <small class="text-muted d-block">
                                                Phone Number
                                            </small>

                                            <span class="fw-semibold">
                                                {{ $user->phone ?? 'Not provided' }}
                                            </span>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            {{-- Role --}}
                            <div class="col-md-6">
                                <div class="border rounded-3 p-3 h-100">
                                    <div class="d-flex align-items-center">
                                        <div
                                            class="rounded-circle bg-warning text-white d-flex align-items-center justify-content-center me-3"
                                            style="width: 38px; height: 38px;">
                                            <i class="fa fa-id-badge"></i>
                                        </div>

                                        <div>
                                            <small class="text-muted d-block">
                                                Role
                                            </small>

                                            <span class="fw-semibold">
                                                {{ ucfirst(optional($user->assignedRole)->name ?? $user->role) }}
                                            </span>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            {{-- Account Status --}}
                            <div class="col-md-6">
                                <div class="border rounded-3 p-3 h-100">
                                    <div class="d-flex align-items-center">
                                        <div
                                            class="rounded-circle bg-success text-white d-flex align-items-center justify-content-center me-3"
                                            style="width: 38px; height: 38px;">
                                            <i class="fa fa-check"></i>
                                        </div>

                                        <div>
                                            <small class="text-muted d-block">
                                                Account Status
                                            </small>

                                            <span class="fw-semibold">
                                                {{ $user->is_active ? 'Active' : 'Inactive' }}
                                            </span>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            {{-- Joined --}}
                            <div class="col-md-6">
                                <div class="border rounded-3 p-3 h-100">
                                    <div class="d-flex align-items-center">
                                        <div
                                            class="rounded-circle bg-secondary text-white d-flex align-items-center justify-content-center me-3"
                                            style="width: 38px; height: 38px;">
                                            <i class="fa fa-calendar"></i>
                                        </div>
                                        <div>
                                            <small class="text-muted d-block">
                                                Address
                                            </small>

                                            <span class="fw-semibold">
                                                {{ $user->address ?? 'Not provided' }}
                                            </span>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            {{-- Joined --}}
                            <div class="col-md-6">
                                <div class="border rounded-3 p-3 h-100">
                                    <div class="d-flex align-items-center">
                                        <div
                                            class="rounded-circle bg-secondary text-white d-flex align-items-center justify-content-center me-3"
                                            style="width: 38px; height: 38px;">
                                            <i class="fa fa-calendar"></i>
                                        </div>
                                        <div>
                                            <small class="text-muted d-block">
                                                Member Since
                                            </small>

                                            <span class="fw-semibold">
                                                {{ $user->created_at->format('Y-m-d') }}
                                            </span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection