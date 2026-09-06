@extends('layouts.admin')

@section('title', 'Add Discount')

@section('content')
<div class="container">
    <div class="page-inner">
        <x-admin.breadcrumb
            :items="[
                [
                    'label' => 'Discounts',
                    'url' => route('admin.discounts.index'),
                ],
                [
                    'label' => 'Add Discount',
                ],
            ]"
        />

        <x-admin.alert />

        <div class="card">
            <div class="card-header">
                <div class="d-flex align-items-center">
                    <h4 class="card-title">Add Discount</h4>

                    <a
                        href="{{ route('admin.discounts.index') }}"
                        class="btn btn-secondary btn-round ms-auto"
                    >
                        <i class="fas fa-arrow-left me-1"></i>
                        Back
                    </a>
                </div>
            </div>

            <div class="card-body">
                @can('discounts.create')
                    <form
                        action="{{ route('admin.discounts.store') }}"
                        method="POST"
                    >
                        @csrf

                        @include('admin.Discounts.partials.form', [
                            'discount' => null,
                        ])

                        <x-admin.form-actions
                            submitText="Save Discount"
                            :cancelUrl="route('admin.discounts.index')"
                        />
                    </form>
                @endcan
            </div>
        </div>
    </div>
</div>
@endsection