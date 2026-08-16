@extends('layouts.admin')

@section('title', 'Add Product')

@section('content')
<div class="container">
    <div class="page-inner">
        <x-admin.breadcrumb
            :items="[
                [
                    'label' => 'Products',
                    'url' => route('admin.products.index'),
                ],
                [
                    'label' => 'Add Product',
                ],
            ]"
        />

        <x-admin.alert />

        <div class="card">
            <div class="card-header">
                <div class="d-flex align-items-center">
                    <h4 class="card-title">Add Product</h4>

                    <a
                        href="{{ route('admin.products.index') }}"
                        class="btn btn-secondary btn-round ms-auto"
                    >
                        <i class="fas fa-arrow-left me-1"></i>
                        Back
                    </a>
                </div>
            </div>

            <div class="card-body">
                @can('products.create')
                    <form
                        action="{{ route('admin.products.store') }}"
                        method="POST"
                        enctype="multipart/form-data"
                    >
                        @csrf

                        @include('admin.Product.partials.form', [
                            'product' => null,
                        ])

                        <x-admin.form-actions
                            submitText="Save Product"
                            :cancelUrl="route('admin.products.index')"
                        />
                    </form>
                @endcan
            </div>
        </div>
    </div>
</div>
@endsection