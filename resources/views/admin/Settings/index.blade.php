@extends('layouts.admin')

@section('title', 'Settings')

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
                    <a href="{{ route('admin.settings.index') }}">Settings</a>
                </li>
            </ul>
        </div>

        @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        @if($errors->any())
        <div class="alert alert-danger">
            <ul class="mb-0">
                @foreach($errors->all() as $error)
                <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
        @endif

        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <div class="d-flex align-items-center">
                            <h4 class="card-title">Settings</h4>
                        </div>
                    </div>
                    <div class="card-body">
                        <form action="{{ route('admin.settings.update') }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            @method('PUT')

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="site_name">Site Name</label>
                                        <input type="text" name="site_name" id="site_name" class="form-control" value="{{ old('site_name', $settings->site_name) }}">
                                    </div>

                                    <div class="form-group">
                                        <label for="site_email">Site Email</label>
                                        <input type="email" name="site_email" id="site_email" class="form-control" value="{{ old('site_email', $settings->site_email) }}">
                                    </div>

                                    <div class="form-group">
                                        <label for="site_phone">Site Phone</label>
                                        <input type="text" name="site_phone" id="site_phone" class="form-control" value="{{ old('site_phone', $settings->site_phone) }}">
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="site_logo">Site Logo</label>
                                        <input type="file" name="site_logo" id="site_logo" class="form-control">
                                        @if(!empty($settings->site_logo))
                                        <div class="mt-2">
                                            <img src="{{ asset($settings->site_logo) }}" alt="Site Logo" style="max-height: 80px;" />
                                        </div>
                                        @endif
                                    </div>

                                    <div class="form-group">
                                        <label for="site_favicon">Site Favicon</label>
                                        <input type="file" name="site_favicon" id="site_favicon" class="form-control">
                                        @if(!empty($settings->site_favicon))
                                        <div class="mt-2">
                                            <img src="{{ asset($settings->site_favicon) }}" alt="Site Favicon" style="max-height: 48px;" />
                                        </div>
                                        @endif
                                    </div>
                                </div>
                            </div>

                            @can('settings.edit')
                            <button type="submit" class="btn btn-primary mt-3">Save Settings</button>
                            @endcan
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection