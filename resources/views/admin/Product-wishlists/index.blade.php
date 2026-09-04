@extends('layouts.admin')

@section('title', 'Product Wishlists')

@section('content')
<div class="container">
    <div class="page-inner">
        <x-admin.breadcrumb
            :items="[
                [
                    'label' => 'Product Wishlists',
                ],
            ]"
        />

        <x-admin.alert />

        <div class="card">
            <div class="card-header">
                <div class="d-flex align-items-center">
                    <div>
                        <h4 class="card-title mb-1">
                            Product Wishlists
                        </h4>
                        <p class="text-muted mb-0">
                            Manage customer product wishlists
                        </p>
                    </div>

                    <div class="ms-auto d-flex align-items-center gap-2">
                        <x-admin.search
                            id="productWishlistSearch"
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
                <div id="product-wishlists-table">
                    @include('admin.Product-wishlists.partials.table', [
                        'wishlists' => $wishlists,
                    ])
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
    $(document).ready(function () {
        function loadWishlists(page = 1) {
            $.ajax({
                url: "{{ route('admin.product-wishlists.index') }}",
                type: "GET",
                data: {
                    search: $('#productWishlistSearch').val(),
                    sort: "{{ request('sort') }}",
                    page: page
                },
                success: function (response) {
                    if (response.html) {
                        $('#product-wishlists-table').html(response.html);
                    }
                },
                error: function (xhr) {
                    console.log(xhr.responseText);
                }
            });
        }

        let searchTimer;

        $('#productWishlistSearch').on('keyup', function () {
            clearTimeout(searchTimer);

            searchTimer = setTimeout(function () {
                loadWishlists();
            }, 400);
        });

        $(document).on(
            'click',
            '#product-wishlists-pagination a',
            function (e) {
                e.preventDefault();

                const page = new URL(this.href)
                    .searchParams
                    .get('page');

                loadWishlists(page);
            }
        );
    });
</script>
@endpush
@endsection