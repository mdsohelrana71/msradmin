@extends('layouts.admin')
@section('title', 'Edit Product Category')
@section('content')

<div class="container">
    <div class="page-inner">
        <x-admin.breadcrumb
            :items="[
                [
                    'label' => 'Product Categories',
                    'url' => route('admin.product-categories.index'),
                ],
                [
                    'label' => 'Edit Category',
                ],
            ]"
        />
        <div class="row justify-content-center">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-header">
                        <div class="d-flex align-items-center">
                            <h4 class="card-title">
                                Edit Product Category
                            </h4>
                            <a
                                href="{{ route('admin.product-categories.index') }}"
                                class="btn btn-secondary btn-round ms-auto"
                            >
                                <i class="fa fa-arrow-left me-1"></i>
                                Back
                            </a>
                        </div>
                    </div>

                    <div class="card-body">
                        <form
                            action="{{ route('admin.product-categories.update', $category) }}"
                            method="POST"
                        >
                            @csrf
                            @method('PUT')

                            @include('admin.Product.Category.partials.form', [
                                'category' => $category,
                                'categories' => $categories,
                                'selectedParent' => old('parent_id', $category->parent_id),
                                'excludedIds' => $excludedIds,
                            ])

                            <div class="mt-4">
                                <button
                                    type="submit"
                                    class="btn btn-primary"
                                >
                                    <i class="fa fa-save me-1"></i>
                                    Update Category
                                </button>

                                <a
                                    href="{{ route('admin.product-categories.index') }}"
                                    class="btn btn-secondary"
                                >
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