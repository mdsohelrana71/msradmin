@extends('layouts.admin')
@section('title', 'Blog Categories')
@section('content')

<div class="container">
    <div class="page-inner">
        <x-admin.breadcrumb
            :items="[
                [
                    'label' => 'Blog Categories',
                ],
            ]"
            :action="[
                'label' => 'Add Category',
                'url' => route('admin.blog-categories.create'),
                'icon' => 'fa fa-plus',
            ]"
        />
        <x-admin.alert />

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

                    <x-admin.search
                        id="categorySearch"
                        placeholder="Search category..."
                    />
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
