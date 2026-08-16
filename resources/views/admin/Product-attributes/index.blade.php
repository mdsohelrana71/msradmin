@extends('layouts.admin')

@section('title', 'Product Attributes')

@section('content')
<div class="container">
    <div class="page-inner">
        <x-admin.breadcrumb
            :items="[
                [
                    'label' => 'Product Attributes',
                ],
            ]"
            :action="[
                'label' => 'Add Attribute',
                'url' => route('admin.product-attributes.create'),
                'icon' => 'fa fa-plus',
                'permission' => 'product-attributes.create',
            ]"
        />

        <x-admin.alert />

        <div class="card">
            <div class="card-header">
                <div class="d-flex align-items-center">
                    <div>
                        <h4 class="card-title mb-1">Product Attributes</h4>
                        <p class="text-muted mb-0">
                            Manage all product attributes
                        </p>
                    </div>

                    <div class="ms-auto d-flex align-items-center gap-2">
                        <x-admin.search
                            id="productAttributeSearch"
                            placeholder="Search attributes..."
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
                <div id="product-attributes-table">
                    @include('admin.product-attributes.partials.table', [
                        'attributes' => $attributes,
                    ])
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
    $(document).ready(function () {
        function loadAttributes(page = 1) {
            $.ajax({
                url: "{{ route('admin.product-attributes.index') }}",
                type: "GET",
                data: {
                    search: $('#productAttributeSearch').val(),
                    sort: "{{ request('sort') }}",
                    page: page
                },
                success: function (response) {
                    if (response.html) {
                        $('#product-attributes-table').html(response.html);
                    }
                },
                error: function (xhr) {
                    console.log(xhr.responseText);
                }
            });
        }

        let searchTimer;

        $('#productAttributeSearch').on('keyup', function () {
            clearTimeout(searchTimer);

            searchTimer = setTimeout(function () {
                loadAttributes();
            }, 400);
        });

        $(document).on(
            'click',
            '#product-attributes-pagination a',
            function (e) {
                e.preventDefault();

                const page = new URL(this.href).searchParams.get('page');

                loadAttributes(page);
            }
        );
    });

    function confirmDelete(id) {
        const form = document.querySelector(
            `form[action$="/product-attributes/${id}"]`
        );

        const modal = document.getElementById(
            'deleteProductAttributeModal'
        );

        if (!modal || !form) return;

        modal.querySelector('form').action = form.action;

        new bootstrap.Modal(modal).show();
    }
</script>
@endpush
@endsection