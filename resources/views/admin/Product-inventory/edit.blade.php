@extends('layouts.admin')

@section('title', 'Edit Product Inventory')

@section('content')
<div class="container">
    <div class="page-inner">
        <x-admin.breadcrumb
            :items="[
                [
                    'label' => 'Product Inventory',
                    'url' => route('admin.product-inventory.index'),
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
                            <h4 class="card-title">Edit Product Inventory</h4>

                            <a
                                href="{{ route('admin.product-inventory.index') }}"
                                class="btn btn-secondary btn-round ms-auto"
                            >
                                Back
                            </a>
                        </div>
                    </div>

                    <div class="card-body">
                        <form
                            action="{{ route('admin.product-inventory.update', $inventory) }}"
                            method="POST"
                        >
                            @csrf
                            @method('PUT')

                            @include('admin.Product-inventory.partials.form', [
                                'inventory' => $inventory,
                            ])

                            <x-admin.form-actions
                                submitText="Update Inventory"
                                :cancelUrl="route('admin.product-inventory.index')"
                            />
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection