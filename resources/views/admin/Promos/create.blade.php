@extends('layouts.admin')

@section('title', 'Create Promo')

@section('content')
<div class="container">
    <div class="page-inner">
        <x-admin.breadcrumb
            :items="[
                [
                    'label' => 'Promos',
                    'url' => route('admin.promos.index'),
                ],
                [
                    'label' => 'Create',
                ],
            ]"
        />

        <x-admin.alert />

        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <div class="d-flex align-items-center">
                            <h4 class="card-title">Create Promo</h4>

                            <a
                                href="{{ route('admin.promos.index') }}"
                                class="btn btn-secondary btn-round ms-auto"
                            >
                                Back
                            </a>
                        </div>
                    </div>

                    <div class="card-body">
                        <form action="{{ route('admin.promos.store') }}" method="POST">
                            @csrf

                            @include('admin.Promos.partials.form', [
                                'promo' => null,
                            ])

                            <x-admin.form-actions
                                submitText="Save Promo"
                                :cancelUrl="route('admin.promos.index')"
                            />
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection