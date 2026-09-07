@extends('layouts.admin')

@section('title', 'Add Slider')

@section('content')
<div class="container">
    <div class="page-inner">
        <x-admin.breadcrumb
            :items="[
                [
                    'label' => 'Sliders',
                    'url' => route('admin.sliders.index'),
                ],
                [
                    'label' => 'Add Slider',
                ],
            ]"
        />

        <x-admin.alert />

        <div class="card">
            <div class="card-header">
                <div class="d-flex align-items-center">
                    <h4 class="card-title">Add Slider</h4>
                    <a
                        href="{{ route('admin.sliders.index') }}"
                        class="btn btn-secondary btn-round ms-auto"
                    >
                        <i class="fas fa-arrow-left me-1"></i>
                        Back
                    </a>
                </div>
            </div>

            <div class="card-body">
                @can('sliders.create')
                    <form
                        action="{{ route('admin.sliders.store') }}"
                        method="POST"
                        enctype="multipart/form-data"
                    >
                        @csrf

                        @include('admin.Sliders.partials.form')

                        <x-admin.form-actions
                            submitText="Save Slider"
                            :cancelUrl="route('admin.sliders.index')"
                        />
                    </form>
                @endcan
            </div>
        </div>
    </div>
</div>
@endsection