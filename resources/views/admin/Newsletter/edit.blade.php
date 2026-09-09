@extends('layouts.admin')
@section('title', 'Edit Subscriber')
@section('content')
    <div class="container">
        <div class="page-inner">
            <x-admin.breadcrumb
                :items="[
                    [
                        'label' => 'Newsletter Subscribers',
                        'url' => route('admin.newsletter-subscribers.index'),
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
                                <h4 class="card-title">Edit Subscriber</h4>
                                <a href="{{ route('admin.newsletter-subscribers.index') }}" class="btn btn-secondary btn-round ms-auto">
                                    Back
                                </a>
                            </div>
                        </div>
                        <div class="card-body">
                            <form action="{{ route('admin.newsletter-subscribers.update', $newsletterSubscriber) }}" method="POST">
                                @csrf
                                @method('PUT')
                                @include('admin.Newsletter.partials.form', [
                                    'newsletterSubscriber' => $newsletterSubscriber,
                                ])
                                <x-admin.form-actions
                                    submitText="Update Subscriber"
                                    :cancelUrl="route('admin.newsletter-subscribers.index')"
                                />
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection