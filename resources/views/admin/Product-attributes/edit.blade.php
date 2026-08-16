@extends('layouts.admin')

@section('title', 'Edit Product Attribute')

@section('content')
<div class="container">
    <div class="page-inner">
        <x-admin.breadcrumb
            :items="[
                [
                    'label' => 'Product Attributes',
                    'url' => route('admin.product-attributes.index'),
                ],
                [
                    'label' => 'Edit',
                ],
            ]"
        />

        <x-admin.alert />

        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <div class="d-flex align-items-center">
                            <h4 class="card-title">Edit Product Attribute</h4>

                            <a
                                href="{{ route('admin.product-attributes.index') }}"
                                class="btn btn-secondary btn-round ms-auto"
                            >
                                Back
                            </a>
                        </div>
                    </div>

                    <div class="card-body">
                        <form
                            action="{{ route('admin.product-attributes.update', $productAttribute) }}"
                            method="POST"
                        >
                            @csrf
                            @method('PUT')

                            @include('admin.product-attributes.partials.form', [
                                'attribute' => $productAttribute,
                            ])

                            <x-admin.form-actions
                                submitText="Update Attribute"
                                :cancelUrl="route('admin.product-attributes.index')"
                            />
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection