@extends('layouts.admin')

@section('title', 'Coupons')

@section('content')
<div class="container">
    <div class="page-inner">
        <x-admin.breadcrumb
            :items="[
                [
                    'label' => 'Coupons',
                ],
            ]"
            :action="[
                'label' => 'Add Coupon',
                'url' => route('admin.coupons.create'),
                'icon' => 'fa fa-plus',
                'permission' => 'coupons.create',
            ]"
        />

        <x-admin.alert />

        <div class="card">
            <div class="card-header">
                <div class="d-flex align-items-center">
                    <div>
                        <h4 class="card-title mb-1">Coupons</h4>
                        <p class="text-muted mb-0">
                            Manage your store coupons
                        </p>
                    </div>
                    <div class="ms-auto d-flex align-items-center gap-2">
                        <x-admin.search
                            id="couponSearch"
                            placeholder="Search coupons..."
                        />
                        <x-admin.sort-dropdown
                            :options="[
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
                <div id="coupons-table">
                    @include('admin.Coupons.partials.table', [
                        'coupons' => $coupons,
                    ])
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
$(document).ready(function () {
    function loadCoupons(page = 1) {
        $.ajax({
            url: "{{ route('admin.coupons.index') }}",
            type: "GET",
            data: {
                search: $('#couponSearch').val(),
                sort: $('.sort-dropdown').val(),
                page: page
            },
            success: function (response) {
                $('#coupons-table').html(response.html);
            },
            error: function (xhr) {
                console.log(xhr.responseText);
            }
        });
    }

    let searchTimer;

    $('#couponSearch').on('keyup', function () {
        clearTimeout(searchTimer);
        searchTimer = setTimeout(function () {
            loadCoupons();
        }, 400);
    });

    $(document).on('change', '.sort-dropdown', function () {
        loadCoupons();
    });

    $(document).on('click', '#coupons-pagination a', function (e) {
        e.preventDefault();

        const page = new URL(this.href).searchParams.get('page');

        loadCoupons(page);
    });
});
</script>
@endpush
@endsection