@extends('layouts.admin')

@section('title', 'Add Coupon')

@section('content')
<div class="container">
    <div class="page-inner">
        <x-admin.breadcrumb
            :items="[
                [
                    'label' => 'Coupons',
                    'url' => route('admin.coupons.index'),
                ],
                [
                    'label' => 'Add Coupon',
                ],
            ]"
        />
        <x-admin.alert />
        <div class="card">
            <div class="card-header">
                <div class="d-flex align-items-center">
                    <h4 class="card-title">Add Coupon</h4>
                    <a
                        href="{{ route('admin.coupons.index') }}"
                        class="btn btn-secondary btn-round ms-auto"
                    >
                        <i class="fas fa-arrow-left me-1"></i>
                        Back
                    </a>
                </div>
            </div>
            <div class="card-body">
                @can('coupons.create')
                    <form
                        action="{{ route('admin.coupons.store') }}"
                        method="POST"
                    >
                        @csrf
                        @include('admin.Coupons.partials.form', [
                            'coupon' => null,
                        ])
                        <x-admin.form-actions
                            submitText="Save Coupon"
                            :cancelUrl="route('admin.coupons.index')"
                        />
                    </form>
                @endcan
            </div>
        </div>
    </div>
</div>
@endsection