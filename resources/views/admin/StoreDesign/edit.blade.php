@extends('layouts.admin')

@section('title', 'Edit Store Design')

@section('content')

<div class="container">
    <div class="page-inner">
        <x-admin.breadcrumb
            :items="[
                [
                    'label' => 'Store Design',
                    'url' => route('admin.store-designs.index'),
                ],
                [
                    'label' => $sectionData['label'],
                ],
            ]"
        />

        <x-admin.alert />

        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <div class="d-flex align-items-center">
                            <h4 class="card-title">{{ $sectionData['label'] }}</h4>

                            <a
                                href="{{ route('admin.store-designs.index') }}"
                                class="btn btn-secondary btn-round ms-auto"
                            >
                                Back
                            </a>
                        </div>
                    </div>

                    <div class="card-body">
                        <form
                            action="{{ route('admin.store-designs.update', $section) }}"
                            method="POST"
                        >
                            @csrf
                            @method('PUT')

                            @include('admin.StoreDesign.partials.form', [
                                'designs' => $designs,
                                'selectedDesign' => $selectedDesign,
                            ])

                            <x-admin.form-actions
                                submitText="Save Design"
                                :cancelUrl="route('admin.store-designs.index')"
                            />
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection