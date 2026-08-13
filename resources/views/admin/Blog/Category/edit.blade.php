@extends('layouts.admin')
@section('title', 'Edit Blog Category')
@section('content')

<div class="container">
    <div class="page-inner">
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
                    <a href="{{ route('admin.blog-categories.index') }}">
                        Blog Categories
                    </a>
                </li>
                <li class="separator">
                    <i class="icon-arrow-right"></i>
                </li>
                <li class="nav-item">
                    <span>Edit Category</span>
                </li>
            </ul>
        </div>

        <div class="row justify-content-center">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-header">
                        <div class="d-flex align-items-center">
                            <h4 class="card-title">
                                Edit Blog Category
                            </h4>
                            <a
                                href="{{ route(
                                    'admin.blog-categories.index'
                                ) }}"
                                class="btn btn-secondary btn-round ms-auto">
                                Back
                            </a>
                        </div>
                    </div>

                    <div class="card-body">
                        <form
                            action="{{ route(
                                'admin.blog-categories.update',
                                $category
                            ) }}"
                            method="POST">
                            @csrf
                            @method('PUT')
                            @include('admin.Blog.Category.partials.form', [
                                'category' => $category,
                                'categories' => $categories,
                                'selectedParent' => old('parent_id', $category->parent_id),
                                'excludedIds' => $excludedIds,
                            ])
                            <div class="mt-4">
                                <button
                                    type="submit"
                                    class="btn btn-primary">
                                    <i class="fa fa-save me-1"></i>
                                    Update Category
                                </button>
                                <a
                                    href="{{ route(
                                        'admin.blog-categories.index'
                                    ) }}"
                                    class="btn btn-secondary">
                                    Cancel
                                </a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection