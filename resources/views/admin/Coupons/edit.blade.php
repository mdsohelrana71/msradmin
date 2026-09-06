@extends('layouts.admin')

@section('title', 'Edit Coupon')

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
                    'label' => 'Edit Coupon',
                ],
            ]"
        />
        <x-admin.alert />
        <div class="card">
            <div class="card-header">
                <div class="d-flex align-items-center">
                    <h4 class="card-title">Edit Coupon</h4>
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
                @can('coupons.edit')
                    <form
                        action="{{ route('admin.coupons.update', $coupon) }}"
                        method="POST"
                    >
                        @csrf
                        @method('PUT')
                        @include('admin.Coupons.partials.form', [
                            'coupon' => $coupon,
                        ])
                        <x-admin.form-actions
                            submitText="Update Coupon"
                            :cancelUrl="route('admin.coupons.index')"
                        />
                    </form>
                @endcan
            </div>
        </div>
    </div>
</div>
@endsection