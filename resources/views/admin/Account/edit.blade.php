@extends('layouts.admin')
@section('title', 'Edit Profile')
@section('content')

<div class="container">
    <div class="page-inner">
        <x-admin.breadcrumb
            :items="[
                [
                    'label' => 'My Profile',
                    'url' => route('admin.accounts.index'),
                ],
                [
                    'label' => 'Edit Profile',
                ],
            ]"
        />
        <div class="row justify-content-center">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-header">
                        <div class="d-flex align-items-center">
                            <h4 class="card-title">Edit Profile</h4>
                            <a href="{{ route('admin.accounts.index') }}" class="btn btn-secondary btn-round ms-auto">Back</a>
                        </div>
                    </div>
                    <div class="card-body">
                        <form action="{{ route('admin.accounts.update', $user) }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            @method('PUT')

                            @include('admin.Account.partials.form', ['user' => $user])

                            <x-admin.form-actions
                                submitText="Update Profile"
                                :cancelUrl="route('admin.accounts.index')"
                            />
                        </form>
                    </div>
                </div>
            </div>
        </div>

    </div>
</div>
@endsection