@extends('frontend.layouts.app')

@section('title', 'Blog')
@push('styles')
    <link rel="stylesheet" href="{{ app(\App\Services\Frontend\DesignManager::class)->getTemplateCss('blog-listing') }}">
    <link rel="stylesheet" href="{{ app(\App\Services\Frontend\DesignManager::class)->getSectionCss('blog_card') }}">
@endpush
@section('content')
    <section class="py-5">
        <div class="main">
            <div class="container">
                <div class="text-center mb-5">
                    <h1 class="display-6 fw-bold">Explore Our Blogs</h1>
                </div>
                <div class="row">
                    <div class="col-lg-12">
                        <div class="content-area">
                            <div class="row g-4">
                                @forelse ($blogs as $blog)
                                    <div class="col-6 col-lg-4">
                                        @include($blogCardView, ['blog' => $blog])
                                    </div>
                                @empty
                                    <div class="col-12">
                                        <p class="text-center">No blogs found.</p>
                                    </div>
                                @endforelse
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
