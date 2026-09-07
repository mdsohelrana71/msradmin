@extends('layouts.admin')

@section('title', 'Edit Slider')

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
                    'label' => 'Edit Slider',
                ],
            ]"
        />

        <x-admin.alert />

        <div class="card">
            <div class="card-header">
                <div class="d-flex align-items-center">
                    <h4 class="card-title">Edit Slider</h4>
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
                @can('sliders.edit')
                    <form
                        action="{{ route('admin.sliders.update', $slider) }}"
                        method="POST"
                        enctype="multipart/form-data"
                    >
                        @csrf
                        @method('PUT')

                        @include('admin.Sliders.partials.form', [
                            'slider' => $slider
                        ])

                        <x-admin.form-actions
                            submitText="Update Slider"
                            :cancelUrl="route('admin.sliders.index')"
                        />
                    </form>
                @endcan
            </div>
        </div>
    </div>
</div>
@endsection