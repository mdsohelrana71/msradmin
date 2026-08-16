@extends('layouts.admin')

@section('title', 'Brands')

@section('content')
<div class="container">
    <div class="page-inner">
        <x-admin.breadcrumb
            :items="[
                [
                    'label' => 'Brands',
                ],
            ]"
            :action="[
                'label' => 'Add Brand',
                'url' => route('admin.brands.create'),
                'icon' => 'fa fa-plus',
                'permission' => 'brands.create',
            ]"
        />
        <x-admin.alert />

        <div class="card">
            <div class="card-header">
                <div class="d-flex align-items-center">
                    <div>
                        <h4 class="card-title mb-1">Brands</h4>
                        <p class="text-muted mb-0">Manage all product brands</p>
                    </div>

                    <div class="ms-auto d-flex align-items-center gap-2">
                        <x-admin.search
                            id="brandSearch"
                            placeholder="Search brands..."
                        />

                        <div class="dropdown">
                            <button
                                class="btn btn-light border dropdown-toggle"
                                type="button"
                                data-bs-toggle="dropdown"
                                aria-expanded="false"
                            >
                                <i class="fa fa-sort me-1"></i>
                                Sort By
                            </button>

                            <ul class="dropdown-menu dropdown-menu-end">
                                <li>
                                    <a
                                        class="dropdown-item {{ request('sort') === 'a_z' ? 'active' : '' }}"
                                        href="{{ request()->fullUrlWithQuery(['sort' => 'a_z']) }}"
                                    >
                                        A to Z
                                    </a>
                                </li>

                                <li>
                                    <a
                                        class="dropdown-item {{ request('sort') === 'z_a' ? 'active' : '' }}"
                                        href="{{ request()->fullUrlWithQuery(['sort' => 'z_a']) }}"
                                    >
                                        Z to A
                                    </a>
                                </li>

                                <li>
                                    <a
                                        class="dropdown-item {{ request('sort') === 'latest' ? 'active' : '' }}"
                                        href="{{ request()->fullUrlWithQuery(['sort' => 'latest']) }}"
                                    >
                                        Latest
                                    </a>
                                </li>

                                <li>
                                    <a
                                        class="dropdown-item {{ request('sort') === 'oldest' ? 'active' : '' }}"
                                        href="{{ request()->fullUrlWithQuery(['sort' => 'oldest']) }}"
                                    >
                                        Oldest
                                    </a>
                                </li>

                                <li>
                                    <a
                                        class="dropdown-item {{ request('sort') === 'active' ? 'active' : '' }}"
                                        href="{{ request()->fullUrlWithQuery(['sort' => 'active']) }}"
                                    >
                                        Active
                                    </a>
                                </li>

                                <li>
                                    <a
                                        class="dropdown-item {{ request('sort') === 'inactive' ? 'active' : '' }}"
                                        href="{{ request()->fullUrlWithQuery(['sort' => 'inactive']) }}"
                                    >
                                        Inactive
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>

            <div class="card-body">
                <div id="brands-table">
                    @include('admin.Brand.partials.table', [
                        'brands' => $brands
                    ])
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
    $(document).ready(function () {
        function loadBrands(page = 1) {
            $.ajax({
                url: "{{ route('admin.brands.index') }}",
                type: "GET",
                data: {
                    search: $('#brandSearch').val(),
                    sort: "{{ request('sort') }}",
                    page: page
                },
                success: function (response) {
                    $('#brands-table').html(response.html);
                },
                error: function (xhr) {
                    console.log(xhr.responseText);
                }
            });
        }

        let searchTimer;

        $('#brandSearch').on('keyup', function () {
            clearTimeout(searchTimer);

            searchTimer = setTimeout(function () {
                loadBrands();
            }, 400);
        });

        $(document).on('click', '#brands-pagination a', function (e) {
            e.preventDefault();

            const page = new URL(this.href).searchParams.get('page');

            loadBrands(page);
        });
    });

    function confirmDelete(id) {
        const form = document.querySelector(`form[action$="/brands/${id}"]`);
        const modal = document.getElementById('deleteBrandModal');

        if (!modal || !form) return;

        modal.querySelector('form').action = form.action;
        new bootstrap.Modal(modal).show();
    }
</script>
@endpush
@endsection