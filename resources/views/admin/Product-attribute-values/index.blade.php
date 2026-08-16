@extends('layouts.admin')

@section('title', 'Attribute Values')

@section('content')
<div class="container">
    <div class="page-inner">
        <x-admin.breadcrumb
            :items="[
                [
                    'label' => 'Product Attributes',
                    'url' => route('admin.product-attributes.index'),
                ],
                [
                    'label' => $product_attribute->name,
                    'url' => route(
                        'admin.product-attributes.values.index',
                        $product_attribute
                    ),
                ],
                [
                    'label' => 'Values',
                ],
            ]"
            :action="[
                'label' => 'Add Value',
                'url' => route(
                    'admin.product-attributes.values.create',
                    $product_attribute
                ),
                'icon' => 'fa fa-plus',
                'permission' => 'product-attributes.create',
            ]"
        />

        <x-admin.alert />

        <div class="card">
            <div class="card-header">
                <div class="d-flex align-items-center">
                    <div>
                        <h4 class="card-title mb-1">
                            {{ $product_attribute->name }} Values
                        </h4>

                        <p class="text-muted mb-0">
                            Manage values for this product attribute
                        </p>
                    </div>

                    <div class="ms-auto d-flex align-items-center gap-2">
                        <x-admin.search
                            id="attributeValueSearch"
                            placeholder="Search values..."
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
                <div id="attribute-values-table">
                    @include(
                        'admin.product-attribute-values.partials.table',
                        [
                            'values' => $values,
                            'product_attribute' => $product_attribute,
                        ]
                    )
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
    $(document).ready(function () {
        function loadValues(page = 1) {
            $.ajax({
                url: "{{ route(
                    'admin.product-attributes.values.index',
                    $product_attribute
                ) }}",
                type: "GET",
                data: {
                    search: $('#attributeValueSearch').val(),
                    sort: "{{ request('sort') }}",
                    page: page
                },
                success: function (response) {
                    if (response.html) {
                        $('#attribute-values-table').html(response.html);
                    }
                },
                error: function (xhr) {
                    console.log(xhr.responseText);
                }
            });
        }

        let searchTimer;

        $('#attributeValueSearch').on('keyup', function () {
            clearTimeout(searchTimer);

            searchTimer = setTimeout(function () {
                loadValues();
            }, 400);
        });

        $(document).on(
            'click',
            '#attribute-values-pagination a',
            function (e) {
                e.preventDefault();

                const page = new URL(this.href)
                    .searchParams
                    .get('page');

                loadValues(page);
            }
        );
    });
</script>
@endpush
@endsection