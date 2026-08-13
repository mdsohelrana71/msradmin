@extends('layouts.admin')

@section('title', 'Create Product Category')

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
                    'label' => 'Create Category',
                ],
            ]"
        />
        <div class="row justify-content-center">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-header">
                        <div class="d-flex align-items-center">
                            <h4 class="card-title">
                                Create Product Category
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
                            action="{{ route('admin.product-categories.store') }}"
                            method="POST"
                        >
                            @csrf

                            @include('admin.Product.Category.partials.form', [
                                'category' => null,
                                'categories' => $categories,
                                'selectedParent' => old('parent_id'),
                                'excludedIds' => [],
                            ])

                            <div class="mt-4">
                                <button
                                    type="submit"
                                    class="btn btn-primary"
                                >
                                    <i class="fa fa-save me-1"></i>
                                    Save Category
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