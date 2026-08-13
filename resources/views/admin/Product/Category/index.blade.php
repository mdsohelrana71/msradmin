@extends('layouts.admin')
@section('title', 'Product Categories')
@section('content')
<div class="container">
    <div class="page-inner">

        {{-- Header --}}
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
                    <span>Product Categories</span>
                </li>
            </ul>

            <a href="{{ route('admin.product-categories.create') }}" class="btn btn-primary btn-round ms-auto">
                <i class="fa fa-plus me-1"></i>
                Add Category
            </a>
        </div>

        {{-- Success Alert --}}
        @if (session('success'))
            <div class="alert alert-success alert-dismissible fade show position-fixed top-0 end-0 m-3 shadow"
                id="successAlert"
                style="z-index: 9999; min-width: 300px;"
                role="alert">
                <i class="fas fa-check-circle me-2"></i>
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        {{-- Error Alert --}}
        @if ($errors->has('category'))
            <div class="alert alert-danger">
                {{ $errors->first('category') }}
            </div>
        @endif

        {{-- Category Card --}}
        <div class="card">
            <div class="card-header">
                <div class="d-flex align-items-center">
                    <div>
                        <h4 class="card-title mb-1">
                            Product Categories
                        </h4>
                        <p class="text-muted mb-0">
                            Manage your product category hierarchy.
                        </p>
                    </div>
                </div>
            </div>

            <div class="card-body p-0">
                @if ($categories->isNotEmpty())
                    <div class="category-tree">
                        @include('admin.Product.Category.partials.tree', [
                            'categories' => $categories
                        ])
                    </div>
                @else
                    <div class="text-center py-5">
                        <i class="fas fa-folder-open fa-3x text-muted mb-3"></i>
                        <h5>No categories found</h5>
                        <p class="text-muted">
                            Start by creating your first product category.
                        </p>
                        <a href="{{ route('admin.product-categories.create') }}" class="btn btn-primary mt-2">
                            <i class="fa fa-plus me-1"></i>
                            Create Category
                        </a>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection