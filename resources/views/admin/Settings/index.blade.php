@extends('layouts.admin')

@section('title', 'Settings')

@section('content')
<div class="container">
    <div class="page-inner">

        {{-- Page Header --}}
        <div class="page-header">
            <ul class="breadcrumbs mb-3">
                <li class="nav-home">
                    <a href="{{ route('admin.dashboard') }}">
                        <i class="icon-home"></i>
                    </a>
                </li>

                <li class="separator">
                    <i class="icon-arrow-right"></i>
                </li>

                <li class="nav-item">
                    <a href="{{ route('admin.settings.index') }}">
                        Settings
                    </a>
                </li>
            </ul>
        </div>

        {{-- Success Message --}}
        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show">
                <i class="fas fa-check-circle me-2"></i>
                {{ session('success') }}

                <button type="button"
                        class="btn-close"
                        data-bs-dismiss="alert">
                </button>
            </div>
        @endif

        {{-- Validation Errors --}}
        @if($errors->any())
            <div class="alert alert-danger alert-dismissible fade show">
                <strong>
                    <i class="fas fa-exclamation-circle me-2"></i>
                    Please fix the following errors:
                </strong>
                <ul class="mb-0 mt-2">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
                <button type="button"
                        class="btn-close"
                        data-bs-dismiss="alert">
                </button>
            </div>
        @endif

        <div class="row">
            {{-- Settings Sidebar --}}
            <div class="col-lg-3 mb-4">
                @include('admin.settings.partials._sidebar')
            </div>

            {{-- Settings Content --}}
            <div class="col-lg-9">

                <form action="{{ route('admin.settings.update') }}"
                      method="POST"
                      enctype="multipart/form-data">

                    @csrf
                    @method('PUT')

                    {{-- General --}}
                    @include('admin.settings.partials._general')

                    {{-- Appearance --}}
                    @include('admin.settings.partials._appearance')

                    {{-- Email --}}
                    @include('admin.settings.partials._email')

                    {{-- Notifications --}}
                    @include('admin.settings.partials._notifications')

                    {{-- Security --}}
                    @include('admin.settings.partials._security')

                    {{-- API --}}
                    @include('admin.settings.partials._api')

                    {{-- SEO --}}
                    @include('admin.settings.partials._seo')

                    {{-- Social Media --}}
                    @include('admin.settings.partials._social')

                    {{-- Maintenance --}}
                    @include('admin.settings.partials._maintenance')

                    {{-- Legal --}}
                    @include('admin.settings.partials._legal')

                    {{-- Save Button --}}
                    @can('settings.edit')
                        <div class="">
                            <div class="card-body">
                                <div class="d-flex justify-content-end">
                                    <button type="submit"
                                            class="btn btn-primary">

                                        <i class="fas fa-save me-1"></i>
                                        Save Settings
                                    </button>
                                </div>
                            </div>
                        </div>
                    @endcan
                </form>
            </div>
        </div>
    </div>
</div>
@endsection