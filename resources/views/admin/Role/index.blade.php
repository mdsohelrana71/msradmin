@extends('layouts.admin')

@section('title', 'Roles')

@section('content')
<div class="container">
    <div class="page-inner">
        <div class="d-flex align-items-center justify-content-between">
            <x-admin.breadcrumb
                :items="[
                    [
                        'label' => 'Roles',
                    ],
                ]"
            />

            @can('roles.create')
                <a href="{{ route('admin.roles.create') }}" class="btn btn-primary btn-round mb-3">
                    <i class="fa fa-plus me-1"></i>
                    Add Role
                </a>
            @endcan
        </div>

        <x-admin.alert />

        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <div class="d-flex align-items-center">
                            <h4 class="card-title">All Roles</h4>

                            <x-admin.search
                                id="roleSearch"
                                placeholder="Search roles..."
                            />
                        </div>
                    </div>

                    <div class="card-body">
                        <div id="roles-table">
                            @include('admin.Role.partials.table', [
                                'roles' => $roles
                            ])
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
                    search: $('#roleSearch').val(),
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

        $('#roleSearch').on('keyup', function () {
            clearTimeout(searchTimer);

            searchTimer = setTimeout(function () {
                loadRoles();
            }, 400);
        });

        $(document).on('click', '#roles-pagination a', function (e) {
            e.preventDefault();

            const page = new URL(this.href).searchParams.get('page');

            loadRoles(page);
        });
    });
</script>
@endpush