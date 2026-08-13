@extends('layouts.admin')

@section('title', 'Create User')

@section('content')
<div class="container">
    <div class="page-inner">
        <x-admin.breadcrumb
            :items="[
                [
                    'label' => 'Users',
                    'url' => route('admin.users.index'),
                ],
                [
                    'label' => 'Create',
                ],
            ]"
        />

        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <div class="d-flex align-items-center">
                            <h4 class="card-title">Create User</h4>
                            <a href="{{ route('admin.users.index') }}" class="btn btn-secondary btn-round ms-auto">Back</a>
                        </div>
                    </div>
                    <div class="card-body">
                        @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul class="mb-0">
                                @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                        @endif

                        <form action="{{ route('admin.users.store') }}" method="POST" enctype="multipart/form-data">
                            @csrf

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group mb-3">
                                        <label for="name">Name</label>
                                        <input type="text" name="name" id="name" class="form-control" placeholder="Enter full name" value="{{ old('name') }}" required>
                                    </div>

                                    <div class="form-group mb-3">
                                        <label for="email">Email</label>
                                        <input type="email" name="email" id="email" class="form-control" placeholder="Enter email address" value="{{ old('email') }}" required>
                                    </div>

                                    <div class="form-group mb-3">
                                        <label for="role_id">Role</label>
                                        <select name="role_id" id="role_id" class="form-select">
                                            <option value="">Select role</option>
                                            @foreach($roles as $role)
                                                <option value="{{ $role->id }}" @if(old('role_id') == $role->id) selected @endif>{{ $role->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>

                                    <div class="form-group mb-3">
                                        <label for="phone">Phone</label>
                                        <input type="text" name="phone" id="phone" class="form-control" placeholder="Enter phone number" value="{{ old('phone') }}">
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group mb-3">
                                        <label for="avatar">Avatar</label>
                                        <input type="file" name="avatar" id="avatar" class="form-control">
                                    </div>

                                    <div class="form-group mb-3">
                                        <label for="is_active">Status</label>
                                        <select name="is_active" id="is_active" class="form-select">
                                            <option value="1" @if(old('is_active','1')=='1' ) selected @endif>Active</option>
                                            <option value="0" @if(old('is_active')==='0' ) selected @endif>Inactive</option>
                                        </select>
                                    </div>

                                    <div class="form-group mb-3">
                                        <label for="password">Password</label>
                                        <input type="password" name="password" id="password" class="form-control" placeholder="Enter a secure password" required>
                                    </div>

                                    <div class="form-group mb-3">
                                        <label for="address">Address</label>
                                        <textarea name="address" id="address" class="form-control">{{ old('address') }}</textarea>
                                    </div>
                                </div>
                            </div>

                            <button type="submit" class="btn btn-primary">Create User</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection