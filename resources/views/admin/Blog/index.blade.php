@extends('layouts.admin')

@section('title', 'Blogs')

@section('content')
<div class="container">
    <div class="page-inner">
        <x-admin.breadcrumb
            :items="[
                [
                    'label' => 'Blogs',
                ],
            ]"
            :action="[
                'label' => 'Add Blog',
                'url' => route('admin.blogs.create'),
                'icon' => 'fa fa-plus',
                'permission' => 'blogs.create',
            ]"
        />
        <x-admin.alert />

        <div class="card">
            <div class="card-header">
                <div class="d-flex align-items-center">
                    <div>
                        <h4 class="card-title mb-1">Blogs</h4>
                        <p class="text-muted mb-0">Manage all blog posts</p>
                    </div>

                    <div class="ms-auto d-flex align-items-center gap-2">
                        <x-admin.search
                            id="blogSearch"
                            placeholder="Search blogs..."
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
                <div id="blogs-table">
                    @include('admin.Blog.partials.table', [
                        'blogs' => $blogs
                    ])
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
    $(document).ready(function () {
        function loadBlogs(page = 1) {
            $.ajax({
                url: "{{ route('admin.blogs.index') }}",
                type: "GET",
                data: {
                    search: $('#blogSearch').val(),
                    page: page
                },
                success: function (response) {
                    $('#blogs-table').html(response.html);
                },
                error: function (xhr) {
                    console.log(xhr.responseText);
                }
            });
        }

        let searchTimer;

        $('#blogSearch').on('keyup', function () {
            clearTimeout(searchTimer);

            searchTimer = setTimeout(function () {
                loadBlogs();
            }, 400);
        });

        $(document).on('click', '#blogs-pagination a', function (e) {
            e.preventDefault();

            const page = new URL(this.href).searchParams.get('page');

            loadBlogs(page);
        });
    });

    function confirmDelete(id) {
        const form = document.querySelector(`form[action$="/blogs/${id}"]`);
        const modal = document.getElementById('deleteBlogModal');

        if (!modal || !form) return;

        modal.querySelector('form').action = form.action;
        new bootstrap.Modal(modal).show();
    }
</script>
@endpush
@endsection