@extends('layouts.admin')

@section('title', 'Create Product FAQ')

@section('content')
<div class="container">
    <div class="page-inner">
        <x-admin.breadcrumb
            :items="[
                [
                    'label' => 'Product FAQs',
                    'url' => route('admin.product-faqs.index'),
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
                                Create Product FAQ
                            </h4>
                            <a
                                href="{{ route('admin.product-faqs.index') }}"
                                class="btn btn-secondary btn-round ms-auto"
                            >
                                Back
                            </a>
                        </div>
                    </div>

                    <div class="card-body">
                        <form
                            action="{{ route('admin.product-faqs.store') }}"
                            method="POST"
                        >
                            @csrf

                            @include('admin.product-faqs.partials.form', [
                                'faq' => null,
                                'products' => $products,
                            ])

                            <x-admin.form-actions
                                submitText="Save FAQ"
                                :cancelUrl="route('admin.product-faqs.index')"
                            />
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection