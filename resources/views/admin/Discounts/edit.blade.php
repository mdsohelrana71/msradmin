@extends('layouts.admin')

@section('title', 'Edit Discount')

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
                    'label' => 'Edit Discount',
                ],
            ]"
        />

        <x-admin.alert />

        <div class="card">
            <div class="card-header">
                <div class="d-flex align-items-center">
                    <h4 class="card-title">Edit Discount</h4>

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
                @can('discounts.edit')
                    <form
                        action="{{ route('admin.discounts.update', $discount) }}"
                        method="POST"
                    >
                        @csrf
                        @method('PUT')

                        @include('admin.Discounts.partials.form', [
                            'discount' => $discount,
                        ])

                        <x-admin.form-actions
                            submitText="Update Discount"
                            :cancelUrl="route('admin.discounts.index')"
                        />
                    </form>
                @endcan
            </div>
        </div>
    </div>
</div>
@endsection