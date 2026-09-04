@extends('layouts.admin')

@section('title', 'Product Compares')

@section('content')
<div class="container">
    <div class="page-inner">
        <x-admin.breadcrumb
            :items="[
                [
                    'label' => 'Product Compares',
                ],
            ]"
        />

        <x-admin.alert />

        <div class="card">
            <div class="card-header">
                <div class="d-flex align-items-center">
                    <div>
                        <h4 class="card-title mb-1">
                            Product Compares
                        </h4>
                        <p class="text-muted mb-0">
                            Manage customer product comparison lists
                        </p>
                    </div>

                    <div class="ms-auto d-flex align-items-center gap-2">
                        <x-admin.search
                            id="productCompareSearch"
                            placeholder="Search by product or customer..."
                        />

                        <x-admin.sort-dropdown
                            :options="[
                                'latest' => 'Latest',
                                'oldest' => 'Oldest',
                            ]"
                        />
                    </div>
                </div>
            </div>

            <div class="card-body">
                <div id="product-compares-table">
                    @include('admin.Product-compares.partials.table', [
                        'compares' => $compares,
                    ])
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
    $(document).ready(function () {
        function loadCompares(page = 1) {
            $.ajax({
                url: "{{ route('admin.product-compares.index') }}",
                type: "GET",
                data: {
                    search: $('#productCompareSearch').val(),
                    sort: $('.sort-dropdown').val(),
                    page: page
                },
                success: function (response) {
                    if (response.html) {
                        $('#product-compares-table').html(response.html);
                    }
                },
                error: function (xhr) {
                    console.log(xhr.responseText);
                }
            });
        }

        let searchTimer;

        $('#productCompareSearch').on('keyup', function () {
            clearTimeout(searchTimer);

            searchTimer = setTimeout(function () {
                loadCompares();
            }, 400);
        });

        $(document).on('change', '.sort-dropdown', function () {
            loadCompares();
        });

        $(document).on(
            'click',
            '#product-compares-pagination a',
            function (e) {
                e.preventDefault();

                const page = new URL(this.href)
                    .searchParams
                    .get('page');

                loadCompares(page);
            }
        );
    });
</script>
@endpush
@endsection