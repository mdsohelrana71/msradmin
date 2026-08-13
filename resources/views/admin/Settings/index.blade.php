@extends('layouts.admin')

@section('title', 'Settings')

@section('content')
<div class="container">
    <div class="page-inner">
        <div class="page-header d-flex justify-content-between align-items-center">
            <x-admin.breadcrumb
                :items="[
                    [
                        'label' => 'Settings',
                        'url' => route('admin.settings.index'),
                    ],
                ]"
            />

            <form action="{{ route('admin.cache.clear') }}" method="POST" id="clearCacheForm" class="mb-3">
                @csrf
                <button
                    type="button"
                    class="btn btn-danger btn-round"
                    data-bs-toggle="modal"
                    data-bs-target="#clearCacheModal"
                >
                    <i class="fas fa-trash me-1"></i>
                    Clear Cache
                </button>

                <x-confirm-modal
                    id="clearCacheModal"
                    formId="clearCacheForm"
                    title="Clear Cache?"
                    message="Are you sure you want to clear all application cache?"
                    confirmText="Yes, Clear Cache"
                    confirmClass="btn-danger"
                />
            </form>
        </div>
        <x-admin.alert />

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