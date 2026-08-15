@extends('layouts.admin')

@section('title', 'View Blog')

@section('content')
<div class="container">
    <div class="page-inner">
        <x-admin.breadcrumb
            :items="[
                [
                    'label' => 'Blogs',
                    'url' => route('admin.blogs.index'),
                ],
                [
                    'label' => 'View Blog',
                ],
            ]"
            :action="[
                'label' => 'Edit Blog',
                'url' => route('admin.blogs.edit', $blog),
                'icon' => 'fa fa-edit',
                'permission' => 'blogs.edit',
            ]"
        />

        <x-admin.alert />

        <div class="row">
            <div class="col-lg-8">
                <div class="card border shadow-none mb-4">
                    <div class="card-header">
                        <h4 class="card-title mb-0">Blog Details</h4>
                    </div>

                    <div class="card-body">
                        @if ($blog->featured_image)
                            <div class="mb-4">
                                <img
                                    src="{{ asset('storage/' . $blog->featured_image) }}"
                                    alt="{{ $blog->title }}"
                                    class="img-fluid rounded"
                                    style="max-height: 400px; width: 100%; object-fit: cover;"
                                >
                            </div>
                        @endif

                        {{-- Title --}}
                        <div class="border rounded p-3 mb-3">
                            <h6 class="text-muted mb-2">
                                <i class="fa fa-tag me-1"></i>
                                Title
                            </h6>

                            <h2 class="mb-0">
                                {{ $blog->title }}
                            </h2>
                        </div>

                        {{-- Blog URL --}}
                        @if ($blog->slug)
                            <div class="border rounded p-3 mb-3">
                                <h6 class="text-muted mb-2">
                                    <i class="fa fa-link me-1"></i>
                                    Blog URL
                                </h6>

                                <a
                                    href="{{ url('blog/' . $blog->slug) }}"
                                    target="_blank"
                                    rel="noopener noreferrer"
                                    class="text-primary text-break"
                                >
                                    {{ url('blog/' . $blog->slug) }}
                                </a>
                            </div>
                        @endif

                        {{-- Short Description --}}
                        @if ($blog->excerpt)
                            <div class="border rounded p-3 mb-3">
                                <h6 class="text-muted mb-2">
                                    <i class="fa fa-align-left me-1"></i>
                                    Short Description
                                </h6>

                                <p class="mb-0 text-muted">
                                    {{ $blog->excerpt }}
                                </p>
                            </div>
                        @endif

                        {{-- Content --}}
                        <div class="border rounded p-3">
                            <h6 class="text-muted mb-3">
                                <i class="fa fa-file-alt me-1"></i>
                                Content
                            </h6>

                            <div class="blog-content">
                                {!! $blog->content !!}
                            </div>
                        </div>
                    </div>
                </div>

                <div class="card border shadow-none mb-4">
                    <div class="card-header">
                        <h5 class="card-title mb-0">SEO Information</h5>
                    </div>

                    <div class="card-body">
                        {{-- SEO Title --}}
                        <div class="border rounded p-3 mb-3">
                            <h6 class="text-muted mb-2">
                                <i class="fa fa-tag me-1"></i>
                                SEO Title
                            </h6>

                            <div class="mb-0">
                                {{ $blog->meta_title ?: '—' }}
                            </div>
                        </div>

                        {{-- SEO Description --}}
                        <div class="border rounded p-3 mb-3">
                            <h6 class="text-muted mb-2">
                                <i class="fa fa-align-left me-1"></i>
                                SEO Description
                            </h6>

                            <div class="text-muted mb-0">
                                {{ $blog->meta_description ?: '—' }}
                            </div>
                        </div>

                        {{-- SEO Keywords --}}
                        <div class="border rounded p-3 mb-3">
                            <h6 class="text-muted mb-2">
                                <i class="fa fa-tags me-1"></i>
                                SEO Keywords
                            </h6>

                            <div class="text-muted mb-0">
                                {{ $blog->meta_keywords ?: '—' }}
                            </div>
                        </div>

                        {{-- Canonical URL --}}
                        <div class="border rounded p-3">
                            <h6 class="text-muted mb-2">
                                <i class="fa fa-link me-1"></i>
                                Canonical URL
                            </h6>

                            @if ($blog->canonical_url)
                                <a
                                    href="{{ $blog->canonical_url }}"
                                    target="_blank"
                                    rel="noopener noreferrer"
                                    class="text-primary text-break"
                                >
                                    {{ $blog->canonical_url }}
                                    <i class="fa fa-external-link-alt ms-1"></i>
                                </a>
                            @else
                                <div class="text-muted">—</div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-lg-4">
                <div class="card border shadow-none mb-4">
                    <div class="card-header">
                        <h5 class="card-title mb-0">Blog Information</h5>
                    </div>

                    <div class="card-body">
                        {{-- Category --}}
                        <div class="border rounded p-3 mb-3">
                            <h6 class="text-muted mb-2">
                                <i class="fa fa-folder me-1"></i>
                                Category
                            </h6>

                            @if ($blog->category)
                                <span class="badge bg-info">
                                    {{ $blog->category->name }}
                                </span>
                            @else
                                <span class="text-muted">—</span>
                            @endif
                        </div>

                        {{-- Status --}}
                        <div class="border rounded p-3 mb-3">
                            <h6 class="text-muted mb-2">
                                <i class="fa fa-circle-check me-1"></i>
                                Status
                            </h6>

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

                        {{-- Published Date --}}
                        <div class="border rounded p-3 mb-3">
                            <h6 class="text-muted mb-2">
                                <i class="fa fa-calendar me-1"></i>
                                Published Date
                            </h6>

                            @if ($blog->published_at)
                                <div>
                                    {{ $blog->published_at->format('d M Y') }}
                                </div>

                                <small class="text-muted">
                                    {{ $blog->published_at->format('h:i A') }}
                                </small>
                            @else
                                <span class="text-muted">—</span>
                            @endif
                        </div>

                        {{-- Tags --}}
                        <div class="border rounded p-3 mb-3">
                            <h6 class="text-muted mb-2">
                                <i class="fa fa-tags me-1"></i>
                                Tags
                            </h6>

                            @if ($blog->tags->isNotEmpty())
                                <div class="gap-2">
                                    @foreach ($blog->tags as $tag)
                                        <span class="badge bg-light text-dark">
                                            {{ ucfirst($tag->name) }}
                                        </span>
                                    @endforeach
                                </div>
                            @else
                                <span class="text-muted">—</span>
                            @endif
                        </div>
                        {{-- Comments --}}
                        <div class="border rounded p-3 mb-3">
                            <h6 class="text-muted mb-2">
                                <i class="fa fa-comments me-1"></i>
                                Comments
                            </h6>

                            @if ($blog->allow_comments)
                                <span class="badge bg-success">
                                    Allowed
                                </span>
                            @else
                                <span class="badge bg-secondary">
                                    Disabled
                                </span>
                            @endif
                        </div>

                        {{-- Created --}}
                        <div class="border rounded p-3">
                            <h6 class="text-muted mb-2">
                                <i class="fa fa-clock me-1"></i>
                                Created
                            </h6>

                            <div>
                                {{ $blog->created_at->format('d M Y, h:i A') }}
                            </div>
                        </div>
                    </div>
                </div>

                <div class="card border shadow-none mb-4">
                    <div class="card-header">
                        <h5 class="card-title mb-0">Open Graph Image</h5>
                    </div>

                    <div class="card-body">
                        @if ($blog->og_image)
                            <img
                                src="{{ asset('storage/' . $blog->og_image) }}"
                                alt="OG Image"
                                class="img-fluid rounded"
                            >
                        @else
                            <div class="text-center py-4 text-muted">
                                <i class="fas fa-image fa-2x mb-2"></i>
                                <div>No OG image</div>
                            </div>
                        @endif
                    </div>
                </div>

                <div class="card border shadow-none">
                    <div class="card-header">
                        <h5 class="card-title mb-0">Actions</h5>
                    </div>

                    <div class="card-body">
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

                            <a
                                href="{{ route('admin.blogs.index') }}"
                                class="btn btn-light"
                            >
                                <i class="fa fa-arrow-left me-1"></i>
                                Back
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection