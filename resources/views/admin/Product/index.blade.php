@extends('layouts.admin')

@section('title', 'Products')

@section('content')
<div class="container">
    <div class="page-inner">
        <x-admin.breadcrumb
            :items="[
                [
                    'label' => 'Products',
                ],
            ]"
            :action="[
                'label' => 'Add Product',
                'url' => route('admin.products.create'),
                'icon' => 'fa fa-plus',
                'permission' => 'products.create',
            ]"
        />

        <x-admin.alert />

        <div class="card">
            <div class="card-header">
                <div class="d-flex align-items-center">
                    <div>
                        <h4 class="card-title mb-1">Products</h4>
                        <p class="text-muted mb-0">
                            Manage all products
                        </p>
                    </div>

                    <div class="ms-auto d-flex align-items-center gap-2">
                        <x-admin.search
                            id="productSearch"
                            placeholder="Search products..."
                        />
                        <x-admin.sort-dropdown
                            :items="[
                                ['value' => 'a_z', 'label' => 'A to Z'],
                                ['value' => 'z_a', 'label' => 'Z to A'],
                                ['value' => 'latest', 'label' => 'Latest'],
                                ['value' => 'oldest', 'label' => 'Oldest'],
                                ['value' => 'price_low', 'label' => 'Price: Low to High'],
                                ['value' => 'price_high', 'label' => 'Price: High to Low'],
                                ['value' => 'stock_low', 'label' => 'Stock: Low to High'],
                                ['value' => 'stock_high', 'label' => 'Stock: High to Low'],
                                ['value' => 'featured', 'label' => 'Featured'],
                                ['value' => 'active', 'label' => 'Active'],
                                ['value' => 'inactive', 'label' => 'Inactive'],
                            ]"
                        />
                    </div>
                </div>
            </div>

            <div class="card-body">
                <div id="products-table">
                    @include('admin.Product.partials.table', [
                        'products' => $products,
                    ])
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
    $(document).ready(function () {
        function loadProducts(page = 1) {
            $.ajax({
                url: "{{ route('admin.products.index') }}",
                type: "GET",
                data: {
                    search: $('#productSearch').val(),
                    sort: "{{ request('sort') }}",
                    page: page
                },
                success: function (response) {
                    $('#products-table').html(response.html);
                },
                error: function (xhr) {
                    console.log(xhr.responseText);
                }
            });
        }

        let searchTimer;

        $('#productSearch').on('keyup', function () {
            clearTimeout(searchTimer);

            searchTimer = setTimeout(function () {
                loadProducts();
            }, 400);
        });

        $(document).on(
            'click',
            '#products-pagination a',
            function (e) {
                e.preventDefault();

                const page = new URL(this.href)
                    .searchParams
                    .get('page');

                loadProducts(page);
            }
        );
    });

    function confirmDelete(id) {
        const form = document.querySelector(
            `form[action$="/products/${id}"]`
        );

        const modal = document.getElementById(
            'deleteProductModal'
        );

        if (!modal || !form) {
            return;
        }

        modal.querySelector('form').action = form.action;

        new bootstrap.Modal(modal).show();
    }
</script>
@endpush
@endsection