@extends('layouts.admin')

@section('title', 'Create Attribute Value')

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
                    'label' => $product_attribute->name,
                    'url' => route(
                        'admin.product-attributes.values.index',
                        $product_attribute
                    ),
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
                            <h4 class="card-title">
                                Create Attribute Value
                            </h4>

                            <a
                                href="{{ route(
                                    'admin.product-attributes.values.index',
                                    $product_attribute
                                ) }}"
                                class="btn btn-secondary btn-round ms-auto"
                            >
                                Back
                            </a>
                        </div>
                    </div>

                    <div class="card-body">
                        <form
                            action="{{ route(
                                'admin.product-attributes.values.store',
                                $product_attribute
                            ) }}"
                            method="POST"
                        >
                            @csrf

                            @include(
                                'admin.product-attribute-values.partials.form',
                                [
                                    'value' => null,
                                ]
                            )

                            <x-admin.form-actions
                                submitText="Save Value"
                                :cancelUrl="route(
                                    'admin.product-attributes.values.index',
                                    $product_attribute
                                )"
                            />
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection