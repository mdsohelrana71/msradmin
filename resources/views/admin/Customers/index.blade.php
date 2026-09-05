@extends('layouts.admin')

@section('title', 'Customers')

@section('content')
<div class="container">
    <div class="page-inner">
        <x-admin.breadcrumb
            :items="[
                [
                    'label' => 'Customers',
                ],
            ]"
        />

        <x-admin.alert />

        <div class="card">
            <div class="card-header">
                <div class="d-flex align-items-center">
                    <div>
                        <h4 class="card-title mb-1">
                            Customers
                        </h4>
                        <p class="text-muted mb-0">
                            Manage customer accounts
                        </p>
                    </div>

                    <div class="ms-auto d-flex align-items-center gap-2">
                        <x-admin.search
                            id="customerSearch"
                            placeholder="Search by name or email..."
                        />

                        <x-admin.sort-dropdown
                            :options="[
                                'latest' => 'Latest',
                                'oldest' => 'Oldest',
                                'name_asc' => 'Name A-Z',
                                'name_desc' => 'Name Z-A',
                                'active' => 'Active',
                                'inactive' => 'Inactive',
                            ]"
                        />
                    </div>
                </div>
            </div>

            <div class="card-body">
                <div id="customers-table">
                    @include('admin.Customers.partials.table', [
                        'customers' => $customers,
                    ])
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
    $(document).ready(function () {
        function loadCustomers(page = 1) {
            $.ajax({
                url: "{{ route('admin.customers.index') }}",
                type: "GET",
                data: {
                    search: $('#customerSearch').val(),
                    sort: $('.sort-dropdown').val(),
                    page: page
                },
                success: function (response) {
                    if (response.html) {
                        $('#customers-table').html(response.html);
                    }
                },
                error: function (xhr) {
                    console.log(xhr.responseText);
                }
            });
        }

        let searchTimer;

        $('#customerSearch').on('keyup', function () {
            clearTimeout(searchTimer);

            searchTimer = setTimeout(function () {
                loadCustomers();
            }, 400);
        });

        $(document).on('change', '.sort-dropdown', function () {
            loadCustomers();
        });

        $(document).on(
            'click',
            '#customers-pagination a',
            function (e) {
                e.preventDefault();

                const page = new URL(this.href)
                    .searchParams
                    .get('page');

                loadCustomers(page);
            }
        );
    });
</script>
@endpush
@endsection