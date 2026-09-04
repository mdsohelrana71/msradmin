@extends('layouts.admin')

@section('title', 'Product Reviews')

@section('content')
<div class="container">
    <div class="page-inner">
        <x-admin.breadcrumb
            :items="[
                [
                    'label' => 'Product Reviews',
                ],
            ]"
        />

        <x-admin.alert />

        <div class="card">
            <div class="card-header">
                <div class="d-flex align-items-center">
                    <div>
                        <h4 class="card-title mb-1">
                            Product Reviews
                        </h4>
                        <p class="text-muted mb-0">
                            Manage product reviews and ratings
                        </p>
                    </div>

                    <div class="ms-auto d-flex align-items-center gap-2">
                        <x-admin.search
                            id="productReviewSearch"
                            placeholder="Search by product, user or review..."
                        />

                        <x-admin.sort-dropdown
                            :options="[
                                'rating_high' => 'Highest Rating',
                                'rating_low' => 'Lowest Rating',
                                'verified' => 'Verified',
                                'unverified' => 'Unverified',
                                'active' => 'Active',
                                'inactive' => 'Inactive',
                                'latest' => 'Latest',
                                'oldest' => 'Oldest',
                            ]"
                        />
                    </div>
                </div>
            </div>

            <div class="card-body">
                <div id="product-reviews-table">
                    @include('admin.Product-reviews.partials.table', [
                        'reviews' => $reviews,
                    ])
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
    $(document).ready(function () {
        function loadReviews(page = 1) {
            $.ajax({
                url: "{{ route('admin.product-reviews.index') }}",
                type: "GET",
                data: {
                    search: $('#productReviewSearch').val(),
                    sort: "{{ request('sort') }}",
                    page: page
                },
                success: function (response) {
                    if (response.html) {
                        $('#product-reviews-table').html(response.html);
                    }
                },
                error: function (xhr) {
                    console.log(xhr.responseText);
                }
            });
        }

        let searchTimer;

        $('#productReviewSearch').on('keyup', function () {
            clearTimeout(searchTimer);

            searchTimer = setTimeout(function () {
                loadReviews();
            }, 400);
        });

        $(document).on(
            'click',
            '#product-reviews-pagination a',
            function (e) {
                e.preventDefault();

                const page = new URL(this.href)
                    .searchParams
                    .get('page');

                loadReviews(page);
            }
        );
    });
</script>
@endpush
@endsection