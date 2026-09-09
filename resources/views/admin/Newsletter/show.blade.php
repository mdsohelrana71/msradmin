@extends('layouts.admin')
@section('title', 'View Subscriber')
@section('content')
    <div class="container">
        <div class="page-inner">
            <x-admin.breadcrumb :items="[
                [
                    'label' => 'Newsletter Subscribers',
                    'url' => route('admin.newsletter-subscribers.index'),
                ],
                [
                    'label' => 'View Subscriber',
                ],
            ]" />
            <x-admin.alert />
            <div class="card">
                <div class="card-header">
                    <div class="d-flex align-items-center">
                        <h4 class="card-title">View Subscriber</h4>
                        <a href="{{ route('admin.newsletter-subscribers.index') }}" class="btn btn-secondary btn-round ms-auto">
                            <i class="fas fa-arrow-left me-1"></i>
                            Back
                        </a>
                    </div>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-8">
                            <div class="mb-3">
                                <label class="form-label">Email</label>
                                <div class="form-control bg-light">
                                    {{ $newsletterSubscriber->email }}
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="mb-3">
                                <label class="form-label">Status</label>
                                <div>
                                    <span class="badge bg-{{ $newsletterSubscriber->status ? 'success' : 'secondary' }}">
                                        {{ $newsletterSubscriber->status ? 'Active' : 'Inactive' }}
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label">Subscribed At</label>
                                <div class="form-control bg-light">
                                    {{ $newsletterSubscriber->subscribed_at?->format('d M Y h:i A') ?? '—' }}
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label">Unsubscribed At</label>
                                <div class="form-control bg-light">
                                    {{ $newsletterSubscriber->unsubscribed_at?->format('d M Y h:i A') ?? '—' }}
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label">Created At</label>
                                <div class="form-control bg-light">
                                    {{ $newsletterSubscriber->created_at?->format('d M Y h:i A') ?? '—' }}
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label">Updated At</label>
                                <div class="form-control bg-light">
                                    {{ $newsletterSubscriber->updated_at?->format('d M Y h:i A') ?? '—' }}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection