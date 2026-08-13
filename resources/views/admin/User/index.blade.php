@extends('layouts.admin')

@section('title', 'Users')

@section('content')
<div class="container">
    <div class="page-inner">
        <x-admin.breadcrumb
            :items="[
                [
                    'label' => 'Users',
                ],
            ]"
        />
        <x-admin.alert />

        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <div class="d-flex align-items-center">
                            <h4 class="card-title">All Users</h4>
                            @can('users.create')
                            <a href="{{ route('admin.users.create') }}" class="btn btn-primary btn-round ms-auto">
                                <i class="fa fa-plus"></i>
                                Add User
                            </a>
                            @endcan
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="row mb-3 g-2">
                            <div class="col-md-4">
                                <input id="user-search" type="text" class="form-control" placeholder="Search name, email or phone" value="{{ request('search') }}">
                            </div>
                            <div class="col-md-2">
                                <select id="user-role" class="form-select">
                                    <option value="">All roles</option>
                                    @foreach($roles as $role)
                                        <option value="{{ $role->id }}" @if(request('role_id') == $role->id) selected @endif>{{ $role->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-2">
                                <select id="user-status" class="form-select">
                                    <option value="">All status</option>
                                    <option value="active" @if(request('status')=='active') selected @endif>Active</option>
                                    <option value="inactive" @if(request('status')=='inactive') selected @endif>Inactive</option>
                                </select>
                            </div>
                            <div class="col-md-2">
                                <select id="user-sort" class="form-select">
                                    <option value="">Sort by</option>
                                    <option value="name_asc" @if(request('sort')=='name_asc') selected @endif>Name A - Z</option>
                                    <option value="name_desc" @if(request('sort')=='name_desc') selected @endif>Name Z - A</option>
                                    <option value="latest" @if(request('sort')=='latest') selected @endif>Latest</option>
                                    <option value="oldest" @if(request('sort')=='oldest') selected @endif>Oldest</option>
                                </select>
                            </div>
                            <div class="col-md-2">
                                <select id="per-page" class="form-select">
                                    <option value="10" @if((int)request('per_page',10)===10) selected @endif>10</option>
                                    <option value="15" @if((int)request('per_page',10)===15) selected @endif>15</option>
                                    <option value="30" @if((int)request('per_page',10)===30) selected @endif>30</option>
                                </select>
                            </div>
                        </div>

                        <div id="users-table">
                            @include('admin.User.partials.table', ['users' => $users])
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

        function loadUsers(page = 1) {

            $.ajax({
                url: "{{ route('admin.users.index') }}",
                type: "GET",

                data: {
                    search: $('#user-search').val(),
                    role_id: $('#user-role').val(),
                    status: $('#user-status').val(),
                    sort: $('#user-sort').val(),
                    per_page: $('#per-page').val(),
                    page: page
                },

                success: function (response) {
                    $('#users-table').html(response.html);
                },

                error: function (xhr) {
                    console.log(xhr.responseText);
                }
            });
        }

        // Search
        let searchTimer;

        $('#user-search').on('keyup', function () {
            clearTimeout(searchTimer);

            searchTimer = setTimeout(function () {
                loadUsers();
            }, 400);
        });

        // Filters
        $('#user-role, #user-status, #user-sort, #per-page').on('change', function () {
            loadUsers();
        });

        // Pagination
        $(document).on('click', '#users-pagination a', function (e) {
            e.preventDefault();

            let page = new URL(this.href).searchParams.get('page');

            loadUsers(page);
        });

    });
</script>
@endpush
