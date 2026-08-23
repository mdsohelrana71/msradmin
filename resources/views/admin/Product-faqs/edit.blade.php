@extends('layouts.admin')

@section('title', 'Edit Product FAQ')

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
                                Edit Product FAQ
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
                            action="{{ route('admin.product-faqs.update', $faq) }}"
                            method="POST"
                        >
                            @csrf
                            @method('PUT')

                            @include('admin.product-faqs.partials.form', [
                                'faq' => $faq,
                                'products' => $products,
                            ])

                            <x-admin.form-actions
                                submitText="Update FAQ"
                                :cancelUrl="route('admin.product-faqs.index')"
                            />
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
    $(document).ready(function () {
        initializeProductSelect();
    });
</script>
@endpush

@endsection