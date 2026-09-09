@extends('layouts.admin')

@section('title', 'Edit Promo')

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
                    'label' => 'Edit',
                ],
            ]"
        />

        <x-admin.alert />

        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <div class="d-flex align-items-center">
                            <h4 class="card-title">Edit Promo</h4>

                            <a
                                href="{{ route('admin.promos.index') }}"
                                class="btn btn-secondary btn-round ms-auto"
                            >
                                Back
                            </a>
                        </div>
                    </div>

                    <div class="card-body">
                        <form
                            action="{{ route('admin.promos.update', $promo) }}"
                            method="POST"
                        >
                            @csrf
                            @method('PUT')

                            @include('admin.Promos.partials.form', [
                                'promo' => $promo,
                            ])

                            <x-admin.form-actions
                                submitText="Update Promo"
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