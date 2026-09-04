@extends('layouts.admin')

@section('title', 'Edit Product Review')

@section('content')
<div class="container">
    <div class="page-inner">
        <x-admin.breadcrumb
            :items="[
                [
                    'label' => 'Product Reviews',
                    'url' => route('admin.product-reviews.index'),
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
                            <h4 class="card-title">
                                Edit Product Review
                            </h4>

                            <a
                                href="{{ route('admin.product-reviews.index') }}"
                                class="btn btn-secondary btn-round ms-auto"
                            >
                                Back
                            </a>
                        </div>
                    </div>

                    <div class="card-body">
                        <form
                            action="{{ route(
                                'admin.product-reviews.update',
                                $review
                            ) }}"
                            method="POST"
                            enctype="multipart/form-data"
                        >
                            @csrf
                            @method('PUT')

                            @include(
                                'admin.Product-reviews.partials.form',
                                [
                                    'review' => $review,
                                ]
                            )

                            <x-admin.form-actions
                                submitText="Update Review"
                                :cancelUrl="route('admin.product-reviews.index')"
                            />
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection