@extends('layouts.admin')

@section('title', 'Edit Profile')

@section('content')
<div class="container">
    <div class="page-inner">

        {{-- Breadcrumb --}}
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
                    <a href="{{ route('admin.accounts.index') }}">
                        My Profile
                    </a>
                </li>

                <li class="separator">
                    <i class="icon-arrow-right"></i>
                </li>
                <li class="nav-item">
                    <a href="{{ route('admin.accounts.edit', $user) }}">
                        Edit Profile
                    </a>
                </li>
            </ul>
        </div>


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

                            <button type="submit" class="btn btn-primary">Update Profile</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>

    </div>
</div>
@endsection