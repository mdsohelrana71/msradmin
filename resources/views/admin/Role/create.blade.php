@extends('layouts.admin')

@section('title', 'Create Role')

@section('content')
<div class="container">
    <div class="page-inner">
        <x-admin.breadcrumb
            :items="[
                [
                    'label' => 'Roles',
                    'url' => route('admin.roles.index'),
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
                            <h4 class="card-title">Create Role</h4>

                            <a
                                href="{{ route('admin.roles.index') }}"
                                class="btn btn-secondary btn-round ms-auto"
                            >
                                Back
                            </a>
                        </div>
                    </div>

                    <div class="card-body">
                        <form
                            action="{{ route('admin.roles.store') }}"
                            method="POST"
                        >
                            @csrf

                            @include('admin.Role.partials.form', [
                                'role' => null,
                                'permissions' => $permissions,
                            ])

                            <x-admin.form-actions
                                submitText="Save Role"
                                :cancelUrl="route('admin.roles.index')"
                            />
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection