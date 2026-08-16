@extends('layouts.admin')

@section('title', 'Create Product Attribute')

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
                    'label' => 'Create',
                ],
            ]"
        />

        <x-admin.alert />

        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <div class="d-flex align-items-center">
                            <h4 class="card-title">Create Product Attribute</h4>

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
                            action="{{ route('admin.product-attributes.store') }}"
                            method="POST"
                        >
                            @csrf

                            @include('admin.product-attributes.partials.form', [
                                'attribute' => null,
                            ])

                            <x-admin.form-actions
                                submitText="Save Attribute"
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