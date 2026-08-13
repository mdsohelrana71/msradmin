@extends('layouts.admin')
@section('title', 'Blog Categories')
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
                    <span>Blog Categories</span>
                </li>
            </ul>
            <a
                href="{{ route('admin.blog-categories.create') }}"
                class="btn btn-primary btn-round ms-auto">
                <i class="fa fa-plus me-1"></i>
                Add Category
            </a>
        </div>

        @if (session('success'))
            <div
                class="alert alert-success alert-dismissible fade show position-fixed top-0 end-0 m-3 shadow"
                id="successAlert"
                style="z-index: 9999; min-width: 300px;"
                role="alert">
                <i class="fas fa-check-circle me-2"></i>
                {{ session('success') }}
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
                            Blog Categories
                        </h4>
                        <p class="text-muted mb-0">
                            Manage your blog category hierarchy.
                        </p>
                    </div>

                    <div class="ms-auto" style="width: 300px;">
                        <div class="input-group">
                            <span class="input-group-text">
                                <i class="fa fa-search"></i>
                            </span>

                            <input
                                type="text"
                                id="categorySearch"
                                class="form-control"
                                placeholder="Search category..."
                                autocomplete="off"
                            >

                            <button
                                type="button"
                                id="clearCategorySearch"
                                class="btn btn-light d-none"
                                title="Clear search"
                            >
                                <i class="fa fa-times"></i>
                            </button>
                        </div>
                    </div>
                </div>
            </div>

            <div class="card-body p-0">
                @if ($categories->isNotEmpty())
                    <div class="category-tree">
                        @include(
                        'admin.Blog.Category.partials.tree',
                        [
                        'categories' => $categories
                        ]
                        )
                    </div>
                @else
                    <div class="text-center py-5">
                        <i class="fas fa-folder-open fa-3x text-muted mb-3"></i>
                        <h5>
                            No categories found
                        </h5>
                        <a
                            href="{{ route('admin.blog-categories.create') }}"
                            class="btn btn-primary mt-2">
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
