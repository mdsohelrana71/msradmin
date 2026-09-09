@extends('layouts.admin')

@section('title', 'Promos')

@section('content')
<div class="container">
    <div class="page-inner">
        <x-admin.breadcrumb
            :items="[
                [
                    'label' => 'Promos',
                ],
            ]"
            :action="[
                'label' => 'Add Promo',
                'url' => route('admin.promos.create'),
                'icon' => 'fa fa-plus',
                'permission' => 'promos.create',
            ]"
        />
        <x-admin.alert />

        <div class="card">
            <div class="card-header">
                <div class="d-flex align-items-center">
                    <div>
                        <h4 class="card-title mb-1">Promos</h4>
                        <p class="text-muted mb-0">Manage all promotional banners</p>
                    </div>

                    <div class="ms-auto d-flex align-items-center gap-2">
                        <x-admin.search
                            id="promoSearch"
                            placeholder="Search promos..."
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
                <div id="promos-table">
                    @include('admin.Promos.partials.table', [
                        'promos' => $promos
                    ])
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
    $(document).ready(function () {
        function loadPromos(page = 1) {
            $.ajax({
                url: "{{ route('admin.promos.index') }}",
                type: "GET",
                data: {
                    search: $('#promoSearch').val(),
                    sort: $('[name="sort"]').val(),
                    page: page
                },
                success: function (response) {
                    $('#promos-table').html(response.html);
                },
                error: function (xhr) {
                    console.log(xhr.responseText);
                }
            });
        }

        let searchTimer;
        $('#promoSearch').on('keyup', function () {
            clearTimeout(searchTimer);
            searchTimer = setTimeout(function () {
                loadPromos();
            }, 400);
        });

        $(document).on('change', '[name="sort"]', function () {
            loadPromos();
        });

        $(document).on('click', '#promos-pagination a', function (e) {
            e.preventDefault();
            const page = new URL(this.href).searchParams.get('page');
            loadPromos(page);
        });
    });
</script>
@endpush
@endsection