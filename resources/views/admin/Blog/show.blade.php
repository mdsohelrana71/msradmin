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

                        <h2 class="mb-2">{{ $blog->title }}</h2>

                        @if ($blog->slug)
                            <div class="text-muted mb-3">
                                <i class="fa fa-link me-1"></i>
                                {{ $blog->slug }}
                            </div>
                        @endif

                        @if ($blog->excerpt)
                            <div class="mb-4">
                                <h5>Short Description</h5>
                                <p class="text-muted mb-0">
                                    {{ $blog->excerpt }}
                                </p>
                            </div>
                        @endif

                        <div>
                            <h5 class="mb-3">Content</h5>

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
                        <div class="mb-3">
                            <label class="fw-semibold">SEO Title</label>
                            <div class="text-muted">
                                {{ $blog->meta_title ?: '—' }}
                            </div>
                        </div>

                        <div class="mb-3">
                            <label class="fw-semibold">SEO Description</label>
                            <div class="text-muted">
                                {{ $blog->meta_description ?: '—' }}
                            </div>
                        </div>

                        <div class="mb-3">
                            <label class="fw-semibold">SEO Keywords</label>
                            <div class="text-muted">
                                {{ $blog->meta_keywords ?: '—' }}
                            </div>
                        </div>

                        <div>
                            <label class="fw-semibold">Canonical URL</label>

                            @if ($blog->canonical_url)
                                <div>
                                    <a
                                        href="{{ $blog->canonical_url }}"
                                        target="_blank"
                                        rel="noopener noreferrer"
                                    >
                                        {{ $blog->canonical_url }}
                                        <i class="fa fa-external-link-alt ms-1"></i>
                                    </a>
                                </div>
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
                        <div class="mb-3">
                            <label class="fw-semibold d-block">Category</label>

                            @if ($blog->category)
                                <span class="badge bg-info">
                                    {{ $blog->category->name }}
                                </span>
                            @else
                                <span class="text-muted">—</span>
                            @endif
                        </div>

                        <div class="mb-3">
                            <label class="fw-semibold d-block">Status</label>

                            @if ($blog->status === 'published')
                                <span class="badge bg-success">Published</span>
                            @else
                                <span class="badge bg-secondary">Draft</span>
                            @endif
                        </div>

                        <div class="mb-3">
                            <label class="fw-semibold d-block">Published Date</label>

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

                        <div class="mb-3">
                            <label class="fw-semibold d-block">Tags</label>

                            @if ($blog->tags)
                                <div class="d-flex flex-wrap gap-1">
                                    @foreach (explode(',', $blog->tags) as $tag)
                                        <span class="badge bg-light text-dark">
                                            {{ trim($tag) }}
                                        </span>
                                    @endforeach
                                </div>
                            @else
                                <span class="text-muted">—</span>
                            @endif
                        </div>

                        <div class="mb-3">
                            <label class="fw-semibold d-block">Comments</label>

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

                        <div>
                            <label class="fw-semibold d-block">Created</label>
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