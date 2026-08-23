@extends('layouts.admin')

@section('title', 'Product FAQs')

@section('content')
<div class="container">
    <div class="page-inner">
        <x-admin.breadcrumb
            :items="[
                [
                    'label' => 'Product FAQs',
                ],
            ]"
            :action="[
                'label' => 'Add FAQ',
                'url' => route('admin.product-faqs.create'),
                'icon' => 'fa fa-plus',
                'permission' => 'product-faqs.create',
            ]"
        />

        <x-admin.alert />

        <div class="card">
            <div class="card-header">
                <div class="d-flex align-items-center">
                    <div>
                        <h4 class="card-title mb-1">
                            Product FAQs
                        </h4>
                        <p class="text-muted mb-0">
                            Manage product frequently asked questions
                        </p>
                    </div>
                    <div class="ms-auto d-flex align-items-center gap-2">
                        <x-admin.search
                            id="productFaqSearch"
                            placeholder="Search FAQs..."
                        />
                        <x-admin.sort-dropdown
                            :options="[
                                'a_z' => 'A to Z',
                                'z_a' => 'Z to A',
                                'latest' => 'Latest',
                                'oldest' => 'Oldest',
                                'active' => 'Active',
                                'inactive' => 'Inactive',
                            ]"
                        />
                    </div>
                </div>
            </div>

            <div class="card-body">
                <div id="product-faqs-table">
                    @include('admin.product-faqs.partials.table', [
                        'faqs' => $faqs,
                    ])
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
    $(document).ready(function () {
        function loadFaqs(page = 1) {
            $.ajax({
                url: "{{ route('admin.product-faqs.index') }}",
                type: "GET",
                data: {
                    search: $('#productFaqSearch').val(),
                    sort: "{{ request('sort') }}",
                    page: page
                },
                success: function (response) {
                    if (response.html) {
                        $('#product-faqs-table').html(response.html);
                    }
                },
                error: function (xhr) {
                    console.log(xhr.responseText);
                }
            });
        }

        let searchTimer;

        $('#productFaqSearch').on('keyup', function () {
            clearTimeout(searchTimer);

            searchTimer = setTimeout(function () {
                loadFaqs();
            }, 400);
        });

        $(document).on(
            'click',
            '#product-faqs-pagination a',
            function (e) {
                e.preventDefault();

                const page = new URL(this.href)
                    .searchParams
                    .get('page');

                loadFaqs(page);
            }
        );
    });
</script>
@endpush

@endsection