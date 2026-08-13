@extends('layouts.admin')

@section('title', 'View User')

@section('content')
<div class="container">
    <div class="page-inner">
        <x-admin.breadcrumb
            :items="[
                [
                    'label' => 'Users',
                    'url' => route('admin.users.index'),
                ],
                [
                    'label' => 'Show',
                ],
            ]"
        />
        <div class="row">
            <div class="col-md-12">
                <div class="card border-0 shadow-sm">
                    <div class="card-header bg-white border-bottom py-3">
                        <div class="d-flex align-items-center">
                            <div>
                                <h4 class="card-title mb-1">User Details</h4>
                                <small class="text-muted">View user account information</small>
                            </div>

                            <a href="{{ route('admin.users.index') }}" class="btn btn-secondary btn-round ms-auto">
                                <i class="fas fa-arrow-left me-1"></i>
                                Back
                            </a>
                        </div>
                    </div>

                    <div class="card-body p-4">

                        {{-- Profile --}}
                        <div class="text-center mb-4">
                            @if ($user->avatar)
                            <img
                                src="{{ asset('storage/' . $user->avatar) }}"
                                alt="{{ $user->name }}"
                                class="rounded-circle shadow"
                                style="width: 120px; height: 120px; object-fit: cover;">
                            @else
                            <div
                                class="rounded-circle bg-primary text-white d-inline-flex align-items-center justify-content-center shadow fw-bold"
                                style="width: 120px; height: 120px; font-size: 2rem;">
                                {{ collect(explode(' ', trim($user->name)))
                                ->filter()
                                ->take(2)
                                ->map(fn($word) => strtoupper(substr($word, 0, 1)))
                                ->implode('') }}
                            </div>
                            @endif
                        </div>

                        <div class="row g-4">

                            {{-- Personal Information --}}
                            <div class="col-md-6">
                                <div class="card border h-100 shadow-none">
                                    <div class="card-header bg-light">
                                        <h5 class="mb-0">
                                            <i class="fas fa-user me-2 text-primary"></i>
                                            Personal Information
                                        </h5>
                                    </div>

                                    <div class="card-body">

                                        <div class="mb-3">
                                            <small class="text-muted d-block">Full Name</small>
                                            <span class="fw-semibold">{{ $user->name }}</span>
                                        </div>

                                        <div class="mb-3">
                                            <small class="text-muted d-block">Email Address</small>
                                            <span class="fw-semibold">{{ $user->email }}</span>
                                        </div>

                                        <div class="mb-3">
                                            <small class="text-muted d-block">Phone Number</small>
                                            <span class="fw-semibold">{{ $user->phone ?? '-' }}</span>
                                        </div>

                                        <div>
                                            <small class="text-muted d-block">Address</small>
                                            <span class="fw-semibold">{{ $user->address ?? '-' }}</span>
                                        </div>

                                    </div>
                                </div>
                            </div>

                            {{-- Account Information --}}
                            <div class="col-md-6">
                                <div class="card border h-100 shadow-none">
                                    <div class="card-header bg-light">
                                        <h5 class="mb-0">
                                            <i class="fas fa-user-shield me-2 text-primary"></i>
                                            Account Information
                                        </h5>
                                    </div>

                                    <div class="card-body">

                                        <div class="mb-3">
                                            <small class="text-muted d-block">Role</small>
                                            <span class="badge bg-primary">
                                                {{ ucfirst(optional($user->assignedRole)->name ?? 'N/A') }}
                                            </span>
                                        </div>

                                        <div class="mb-3">
                                            <small class="text-muted d-block">Account Status</small>

                                            @if ($user->is_active)
                                            <span class="badge bg-success">
                                                <i class="fas fa-check-circle me-1"></i>
                                                Active
                                            </span>
                                            @else
                                            <span class="badge bg-danger">
                                                <i class="fas fa-times-circle me-1"></i>
                                                Inactive
                                            </span>
                                            @endif
                                        </div>

                                        <div class="mb-3">
                                            <small class="text-muted d-block">Created At</small>
                                            <span class="fw-semibold">
                                                {{ $user->created_at->format('Y-m-d H:i') }}
                                            </span>
                                        </div>

                                        <div>
                                            <small class="text-muted d-block">Last Updated</small>
                                            <span class="fw-semibold">
                                                {{ $user->updated_at->format('Y-m-d H:i') }}
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