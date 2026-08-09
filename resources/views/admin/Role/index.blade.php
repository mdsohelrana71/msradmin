@extends('layouts.admin')

@section('title', 'Roles')

@section('content')
<div class="container">
    <div class="page-inner">
        <div class="page-header">
            <ul class="breadcrumbs">
                <li class="nav-home">
                    <a href="{{ route('admin.dashboard') }}">
                        <i class="icon-home"></i>
                    </a>
                </li>
                <li class="separator">
                    <i class="icon-arrow-right"></i>
                </li>
                <li class="nav-item">
                    <a href="#">Roles</a>
                </li>
            </ul>
        </div>

        @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <div class="d-flex align-items-center">
                            <h4 class="card-title">All Roles</h4>
                            @can('create', App\Models\Role::class)
                            <a href="{{ route('admin.roles.create') }}" class="btn btn-primary btn-round ms-auto">
                                <i class="fa fa-plus"></i>
                                Add Role
                            </a>
                            @endcan
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="row mb-3 g-2">
                            <div class="col-md-4">
                                <input id="role-search" type="text" class="form-control" placeholder="Search roles" value="{{ request('search') }}">
                            </div>
                        </div>

                        <div id="roles-table">
                            @include('admin.Role.partials.table', ['roles' => $roles])
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    $(document).ready(function () {
        function loadRoles(page = 1) {
            $.ajax({
                url: "{{ route('admin.roles.index') }}",
                type: "GET",
                data: {
                    search: $('#role-search').val(),
                    per_page: $('#per-page').val(),
                    page: page
                },
                success: function (response) {
                    $('#roles-table').html(response.html);
                },
                error: function (xhr) {
                    console.log(xhr.responseText);
                }
            });
        }

        let searchTimer;

        $('#role-search').on('keyup', function () {
            clearTimeout(searchTimer);
            searchTimer = setTimeout(loadRoles, 400);
        });

        $('#per-page').on('change', function () {
            loadRoles();
        });

        $(document).on('click', '#roles-pagination a', function (e) {
            e.preventDefault();
            const page = new URL(this.href).searchParams.get('page');
            loadRoles(page);
        });
    });
</script>
@endpush
