@extends('layouts.admin')

@section('title', 'Edit Brand')

@section('content')

<div class="container">
    <div class="page-inner">
        <x-admin.breadcrumb
            :items="[
                [
                    'label' => 'Brands',
                    'url' => route('admin.brands.index'),
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
                            <h4 class="card-title">Edit Brand</h4>

                            <a
                                href="{{ route('admin.brands.index') }}"
                                class="btn btn-secondary btn-round ms-auto"
                            >
                                Back
                            </a>
                        </div>
                    </div>

                    <div class="card-body">
                        <form
                            action="{{ route('admin.brands.update', $brand) }}"
                            method="POST"
                            enctype="multipart/form-data"
                        >
                            @csrf
                            @method('PUT')

                            @include('admin.Brand.partials.form', [
                                'brand' => $brand,
                            ])

                            <x-admin.form-actions
                                submitText="Update Brand"
                                :cancelUrl="route('admin.brands.index')"
                            />
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection