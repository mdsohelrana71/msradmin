@extends('layouts.admin')

@section('title', 'Orders')

@section('content')
<div class="container">
    <div class="page-inner">
        <x-admin.breadcrumb
            :items="[
                [
                    'label' => 'Orders',
                ],
            ]"
        />

        <x-admin.alert />

        <div class="card">
            <div class="card-header">
                <div class="d-flex align-items-center">
                    <div>
                        <h4 class="card-title mb-1">
                            Orders
                        </h4>
                        <p class="text-muted mb-0">
                            Manage customer orders
                        </p>
                    </div>

                    <div class="ms-auto d-flex align-items-center gap-2">
                        <x-admin.search
                            id="orderSearch"
                            placeholder="Search by order number or customer..."
                        />

                        <x-admin.sort-dropdown
                            :options="[
                                'latest' => 'Latest',
                                'oldest' => 'Oldest',
                                'total_high' => 'Highest Total',
                                'total_low' => 'Lowest Total',
                                'pending' => 'Pending',
                                'confirmed' => 'Confirmed',
                                'processing' => 'Processing',
                                'shipped' => 'Shipped',
                                'delivered' => 'Delivered',
                                'cancelled' => 'Cancelled',
                            ]"
                        />
                    </div>
                </div>
            </div>

            <div class="card-body">
                <div id="orders-table">
                    @include('admin.Orders.partials.table', [
                        'orders' => $orders,
                    ])
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
    $(document).ready(function () {
        function loadOrders(page = 1) {
            $.ajax({
                url: "{{ route('admin.orders.index') }}",
                type: "GET",
                data: {
                    search: $('#orderSearch').val(),
                    sort: $('.sort-dropdown').val(),
                    page: page
                },
                success: function (response) {
                    if (response.html) {
                        $('#orders-table').html(response.html);
                    }
                },
                error: function (xhr) {
                    console.log(xhr.responseText);
                }
            });
        }

        let searchTimer;

        $('#orderSearch').on('keyup', function () {
            clearTimeout(searchTimer);

            searchTimer = setTimeout(function () {
                loadOrders();
            }, 400);
        });

        $(document).on('change', '.sort-dropdown', function () {
            loadOrders();
        });

        $(document).on(
            'click',
            '#orders-pagination a',
            function (e) {
                e.preventDefault();

                const page = new URL(this.href)
                    .searchParams
                    .get('page');

                loadOrders(page);
            }
        );
    });
</script>
@endpush
@endsection