@extends('frontend.layouts.app')

@section('title', 'Blog')

@section('content')
<section class="py-5">
    <div class="container">
        <div class="mb-5">
            <h1 class="fw-bold mb-2">Our Blog</h1>
            <p class="text-muted mb-0">Latest news and articles.</p>
        </div>

        <div class="row g-4">
            @forelse ($blogs as $blog)
                <div class="col-md-6 col-lg-4">
                    <article class="card border-0 shadow-sm h-100">
                        <div class="ratio ratio-16x9 bg-light">
                            <div class="d-flex align-items-center justify-content-center text-muted">
                                Blog Image
                            </div>
                        </div>
                        <div class="card-body">
                            <h5 class="fw-bold">
                                <a href="{{ route('blog.show', $blog) }}" class="text-dark text-decoration-none">
                                    {{ $blog->title }}
                                </a>
                            </h5>
                            <a href="{{ route('blog.show', $blog) }}" class="btn btn-outline-dark btn-sm mt-3">
                                Read More
                            </a>
                        </div>
                    </article>
                </div>
            @empty
                <div class="col-12">
                    <div class="alert alert-info">
                        No blog posts found.
                    </div>
                </div>
            @endforelse
        </div>

        <div class="mt-5">
            {{ $blogs->links() }}
        </div>
    </div>
</section>
@endsection