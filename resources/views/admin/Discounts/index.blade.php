@extends('layouts.admin')

@section('title', 'Discounts')

@section('content')
<div class="container">
    <div class="page-inner">
        <x-admin.breadcrumb
            :items="[
                [
                    'label' => 'Discounts',
                ],
            ]"
            :action="[
                'label' => 'Add Discount',
                'url' => route('admin.discounts.create'),
                'icon' => 'fa fa-plus',
                'permission' => 'discounts.create',
            ]"
        />

        <x-admin.alert />

        <div class="card">
            <div class="card-header">
                <div class="d-flex align-items-center">
                    <div>
                        <h4 class="card-title mb-1">Discounts</h4>
                        <p class="text-muted mb-0">
                            Manage your store discounts
                        </p>
                    </div>

                    <div class="ms-auto d-flex align-items-center gap-2">
                        <x-admin.search
                            id="discountSearch"
                            placeholder="Search discounts..."
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
                <div id="discounts-table">
                    @include('admin.Discounts.partials.table', [
                        'discounts' => $discounts,
                    ])
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
    $(document).ready(function () {
        function loadDiscounts(page = 1) {
            $.ajax({
                url: "{{ route('admin.discounts.index') }}",
                type: "GET",
                data: {
                    search: $('#discountSearch').val(),
                    sort: "{{ request('sort') }}",
                    page: page
                },
                success: function (response) {
                    $('#discounts-table').html(response.html);
                },
                error: function (xhr) {
                    console.log(xhr.responseText);
                }
            });
        }

        let searchTimer;

        $('#discountSearch').on('keyup', function () {
            clearTimeout(searchTimer);

            searchTimer = setTimeout(function () {
                loadDiscounts();
            }, 400);
        });

        $(document).on(
            'click',
            '#discounts-pagination a',
            function (e) {
                e.preventDefault();

                const page = new URL(this.href)
                    .searchParams
                    .get('page');

                loadDiscounts(page);
            }
        );
    });

    function confirmDelete(id) {
        const form = document.querySelector(
            `form[action$="/discounts/${id}"]`
        );

        const modal = document.getElementById(
            'deleteDiscountModal'
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