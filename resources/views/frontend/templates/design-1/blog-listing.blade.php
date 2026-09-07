@extends('frontend.layouts.app')

@section('title', 'Blog')
@push('styles')
    <link rel="stylesheet" href="{{ asset('frontend/css/design-1/pages.css') }}">
@endpush
@section('content')
    <section class="py-5">
        <div class="main">
            <div class="container">
                <div class="text-center mb-5">
                    <h1 class="display-5 fw-bold">Blogs</h1>
                </div>
                <div class="row">
                    <div class="col-lg-12">
                        <div class="content-area">
                            <div class="mb-5">
                                <h2 class="fw-bold mb-3">Latest Blogs</h2>
                                <p class="text-muted">
                                    Discover fashion trends, shopping guides, product tips, and the latest updates from our
                                    store.
                                </p>
                            </div>

                            <div class="row g-4">
                                @foreach ($blogs as $blog)
                                    <div class="col-md-6">
                                        <div class="card border-0 shadow-sm h-100">
                                            <img src="{{ asset('storage/' . ltrim($blog->featured_image, '/')) }}"
                                                class="card-img-top blog-img" alt="Blog Image">

                                            <div class="card-body">
                                                <small class="text-muted">
                                                    <i class="far fa-calendar-alt me-1"></i>
                                                    {{$blog->published_at}}
                                                </small>

                                                <h5 class="card-title mt-3">
                                                    {{$blog->title}}
                                                </h5>

                                                <p class="card-text text-muted">
                                                    {{$blog->excerpt}}
                                                </p>

                                                <a href="{{ route('blog.show', $blog) }}" class="btn btn-outline-primary btn-sm">
                                                    Read More
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
