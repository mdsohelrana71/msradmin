@extends('layouts.admin')

@section('title', 'Blog Details')

@section('content')
<div class="container">
    <div class="page-inner">

        {{-- Page Header --}}
        <div class="page-header">

            <ul class="breadcrumbs">

                <li class="nav-home">
                    <a href="{{ route('admin.dashboard') }}">
                        <i class="icon-home"></i>
                    </a>
                </li>

                <li class="separator">
                    <i class="icon-arrow-right"></i>
                </li>

                <li class="nav-item">
                    <a href="{{ route('admin.blogs.index') }}">
                        Blogs
                    </a>
                </li>

                <li class="separator">
                    <i class="icon-arrow-right"></i>
                </li>

                <li class="nav-item">
                    <span>Blog Details</span>
                </li>

            </ul>

            <a
                href="{{ route('admin.blogs.index') }}"
                class="btn btn-secondary btn-round ms-auto"
            >
                <i class="fas fa-arrow-left me-1"></i>
                Back
            </a>

        </div>


        <div class="row">

            {{-- Main Content --}}
            <div class="col-lg-8">

                <div class="card">

                    {{-- Featured Image --}}
                    @if ($blog->featured_image)

                        <div class="card-body pb-0">

                            <img
                                src="{{ asset('storage/' . $blog->featured_image) }}"
                                alt="{{ $blog->title }}"
                                class="img-fluid rounded w-100"
                                style="
                                    max-height: 450px;
                                    object-fit: cover;
                                "
                            >

                        </div>

                    @endif


                    <div class="card-body">

                        {{-- Category + Status --}}
                        <div class="mb-3">

                            @if ($blog->category)

                                <span class="badge bg-info me-1">
                                    {{ $blog->category->name }}
                                </span>

                            @endif


                            @if ($blog->status)

                                <span class="badge bg-success">
                                    Published
                                </span>

                            @else

                                <span class="badge bg-secondary">
                                    Draft
                                </span>

                            @endif

                        </div>


                        {{-- Title --}}
                        <h1 class="fw-bold mb-3">
                            {{ $blog->title }}
                        </h1>


                        {{-- Meta --}}
                        <div class="text-muted mb-4">

                            @if ($blog->author)

                                <span>
                                    <i class="fas fa-user me-1"></i>
                                    {{ $blog->author->name }}
                                </span>

                            @endif


                            <span class="mx-2">
                                •
                            </span>


                            <span>
                                <i class="fas fa-calendar me-1"></i>
                                {{ $blog->created_at->format('d M Y') }}
                            </span>

                        </div>


                        {{-- Excerpt --}}
                        @if ($blog->excerpt)

                            <div class="alert alert-light border mb-4">

                                <strong class="d-block mb-2">
                                    Excerpt
                                </strong>

                                <p class="mb-0">
                                    {{ $blog->excerpt }}
                                </p>

                            </div>

                        @endif


                        {{-- Content --}}
                        <div class="blog-content">

                            <h5 class="mb-3">
                                Content
                            </h5>

                            <div>
                                {!! $blog->content !!}
                            </div>

                        </div>

                    </div>

                </div>

            </div>


            {{-- Sidebar --}}
            <div class="col-lg-4">

                {{-- Blog Information --}}
                <div class="card">

                    <div class="card-header">

                        <h4 class="card-title mb-0">
                            Blog Information
                        </h4>

                    </div>


                    <div class="card-body">

                        {{-- Title --}}
                        <div class="mb-3">

                            <small class="text-muted d-block mb-1">
                                Title
                            </small>

                            <strong>
                                {{ $blog->title }}
                            </strong>

                        </div>


                        {{-- Slug --}}
                        <div class="mb-3">

                            <small class="text-muted d-block mb-1">
                                Slug
                            </small>

                            <code>
                                {{ $blog->slug }}
                            </code>

                        </div>


                        {{-- Category --}}
                        <div class="mb-3">

                            <small class="text-muted d-block mb-1">
                                Category
                            </small>

                            {{ $blog->category?->name ?? '—' }}

                        </div>


                        {{-- Author --}}
                        <div class="mb-3">

                            <small class="text-muted d-block mb-1">
                                Author
                            </small>

                            {{ $blog->author?->name ?? '—' }}

                        </div>


                        {{-- Status --}}
                        <div class="mb-3">

                            <small class="text-muted d-block mb-1">
                                Status
                            </small>

                            @if ($blog->status)

                                <span class="badge bg-success">
                                    Published
                                </span>

                            @else

                                <span class="badge bg-secondary">
                                    Draft
                                </span>

                            @endif

                        </div>


                        {{-- Published At --}}
                        <div class="mb-3">

                            <small class="text-muted d-block mb-1">
                                Published At
                            </small>

                            @if ($blog->published_at)

                                {{ $blog->published_at->format('d M Y, h:i A') }}

                            @else

                                <span class="text-muted">
                                    Not published
                                </span>

                            @endif

                        </div>


                        {{-- Created At --}}
                        <div class="mb-3">

                            <small class="text-muted d-block mb-1">
                                Created At
                            </small>

                            {{ $blog->created_at->format('d M Y, h:i A') }}

                        </div>


                        {{-- Updated At --}}
                        <div class="mb-3">

                            <small class="text-muted d-block mb-1">
                                Updated At
                            </small>

                            {{ $blog->updated_at->format('d M Y, h:i A') }}

                        </div>


                        {{-- Actions --}}
                        <hr>

                        <div class="d-flex gap-2">

                            @can('blogs.edit')

                                <a
                                    href="{{ route('admin.blogs.edit', $blog) }}"
                                    class="btn btn-primary"
                                >
                                    <i class="fa fa-edit me-1"></i>
                                    Edit
                                </a>

                            @endcan


                            @can('blogs.delete')

                                <form
                                    action="{{ route('admin.blogs.destroy', $blog) }}"
                                    method="POST"
                                    onsubmit="return confirm('Are you sure you want to delete this blog?')"
                                >
                                    @csrf
                                    @method('DELETE')

                                    <button
                                        type="submit"
                                        class="btn btn-danger"
                                    >
                                        <i class="fa fa-trash me-1"></i>
                                        Delete
                                    </button>

                                </form>

                            @endcan

                        </div>

                    </div>

                </div>


                {{-- Featured Image Information --}}
                <div class="card mt-3">

                    <div class="card-header">

                        <h4 class="card-title mb-0">
                            Featured Image
                        </h4>

                    </div>

                    <div class="card-body">

                        @if ($blog->featured_image)

                            <img
                                src="{{ asset('storage/' . $blog->featured_image) }}"
                                alt="{{ $blog->title }}"
                                class="img-fluid rounded"
                            >

                            <div class="small text-muted mt-2">
                                {{ $blog->featured_image }}
                            </div>

                        @else

                            <div class="text-center py-4">

                                <i class="fas fa-image fa-2x text-muted mb-2"></i>

                                <p class="text-muted mb-0">
                                    No featured image
                                </p>

                            </div>

                        @endif

                    </div>

                </div>

            </div>

        </div>

    </div>
</div>
@endsection