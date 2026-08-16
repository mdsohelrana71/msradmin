@extends('layouts.admin')

@section('title', 'Create Brand')

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
                            <h4 class="card-title">Create Brand</h4>

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
                            action="{{ route('admin.brands.store') }}"
                            method="POST"
                            enctype="multipart/form-data"
                        >
                            @csrf

                            @include('admin.Brand.partials.form', [
                                'brand' => null,
                            ])

                            <x-admin.form-actions
                                submitText="Save Brand"
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