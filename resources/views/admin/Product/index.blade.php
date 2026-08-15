@extends('layouts.admin')

@section('title', 'Products')

@section('content')
<div class="container">
    <div class="page-inner">
        <x-admin.breadcrumb
            :items="[
                [
                    'label' => 'Products',
                ],
            ]"
            :action="[
                'label' => 'Add Product',
                'url' => route('admin.products.create'),
                'icon' => 'fa fa-plus',
                'permission' => 'products.create',
            ]"
        />
        <x-admin.alert />

        <div class="card">
            <div class="card-header">
                <div class="d-flex align-items-center">
                    <div>
                        <h4 class="card-title mb-1">Products</h4>
                        <p class="text-muted mb-0">Manage all product posts</p>
                    </div>

                    <div class="ms-auto d-flex align-items-center gap-2">
                        <x-admin.search
                            id="productSearch"
                            placeholder="Search products..."
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
                                        class="dropdown-item {{ request('sort') === 'published' ? 'active' : '' }}"
                                        href="{{ request()->fullUrlWithQuery(['sort' => 'published']) }}"
                                    >
                                        Published
                                    </a>
                                </li>
                                <li>
                                    <a
                                        class="dropdown-item {{ request('sort') === 'draft' ? 'active' : '' }}"
                                        href="{{ request()->fullUrlWithQuery(['sort' => 'draft']) }}"
                                    >
                                        Draft
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>

            <div class="card-body">
                <div id="products-table">
                    @include('admin.Product.partials.table', [
                        'products' => $products
                    ])
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
    $(document).ready(function () {
        function loadProducts(page = 1) {
            $.ajax({
                url: "{{ route('admin.products.index') }}",
                type: "GET",
                data: {
                    search: $('#productSearch').val(),
                    page: page
                },
                success: function (response) {
                    $('#products-table').html(response.html);
                },
                error: function (xhr) {
                    console.log(xhr.responseText);
                }
            });
        }

        let searchTimer;

        $('#productSearch').on('keyup', function () {
            clearTimeout(searchTimer);

            searchTimer = setTimeout(function () {
                loadProducts();
            }, 400);
        });

        $(document).on('click', '#products-pagination a', function (e) {
            e.preventDefault();

            const page = new URL(this.href).searchParams.get('page');

            loadProducts(page);
        });
    });

    function confirmDelete(id) {
        const form = document.querySelector(`form[action$="/products/${id}"]`);
        const modal = document.getElementById('deleteProductModal');

        if (!modal || !form) return;

        modal.querySelector('form').action = form.action;
        new bootstrap.Modal(modal).show();
    }
</script>
@endpush
@endsection