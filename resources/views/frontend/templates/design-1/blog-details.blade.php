@extends('frontend.layouts.app')

@section('title', $blog->title)

@section('content')
<section class="py-5">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-9">
                <span class="text-muted small">Blog</span>
                <h1 class="display-5 fw-bold mt-2 mb-4">
                    {{ $blog->title }}
                </h1>

                <div class="bg-light rounded mb-5 d-flex align-items-center justify-content-center" style="height:400px;">
                    <span class="text-muted">Blog Image</span>
                </div>

                <div class="blog-content">
                    {!! $blog->content !!}
                </div>
            </div>
        </div>
    </div>
</section>
@endsection