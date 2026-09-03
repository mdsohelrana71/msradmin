@extends('layouts.admin')

@section('title', 'Product Inventory')

@section('content')
<div class="container">
    <div class="page-inner">
        <x-admin.breadcrumb
            :items="[
                [
                    'label' => 'Product Inventory',
                ],
            ]"
        />

        <x-admin.alert />

        <div class="card">
            <div class="card-header">
                <div class="d-flex align-items-center">
                    <div>
                        <h4 class="card-title mb-1">Product Inventory</h4>
                        <p class="text-muted mb-0">
                            Manage product inventory and stock levels
                        </p>
                    </div>

                    <div class="ms-auto d-flex align-items-center gap-2">
                        <x-admin.search
                            id="productInventorySearch"
                            placeholder="Search by product name or SKU..."
                        />

                        <x-admin.sort-dropdown
                            :options="[
                                'a_z' => 'A to Z',
                                'z_a' => 'Z to A',
                                'latest' => 'Latest',
                                'oldest' => 'Oldest',
                                'in_stock' => 'In Stock',
                                'low_stock' => 'Low Stock',
                                'out_of_stock' => 'Out of Stock',
                            ]"
                        />
                    </div>
                </div>
            </div>

            <div class="card-body">
                <div id="product-inventory-table">
                    @include('admin.Product-inventory.partials.table', [
                        'inventories' => $inventories,
                    ])
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
    $(document).ready(function () {
        function loadInventories(page = 1) {
            const search = $('#productInventorySearch').val();
            const sort = $('select[name="sort"]').val() || '';

            $.ajax({
                url: "{{ route('admin.product-inventory.index') }}",
                type: "GET",
                data: {
                    search: search,
                    sort: sort,
                    page: page
                },
                success: function (response) {
                    if (response.html) {
                        $('#product-inventory-table').html(response.html);
                    }
                },
                error: function (xhr) {
                    console.log(xhr.responseText);
                }
            });
        }

        let searchTimer;

        $('#productInventorySearch').on('keyup', function () {
            clearTimeout(searchTimer);

            searchTimer = setTimeout(function () {
                loadInventories();
            }, 400);
        });

        $(document).on('change', 'select[name="sort"]', function () {
            loadInventories();
        });

        $(document).on(
            'click',
            '#product-inventory-pagination a',
            function (e) {
                e.preventDefault();

                const page = new URL(
                    this.href
                ).searchParams.get('page');

                loadInventories(page);
            }
        );
    });
</script>
@endpush
@endsection