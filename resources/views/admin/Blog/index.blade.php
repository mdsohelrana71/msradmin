@extends('layouts.admin')

@section('title', 'Blogs')

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
                    <span>Blogs</span>
                </li>

            </ul>

            @can('blogs.create')
            <a
                href="{{ route('admin.blogs.create') }}"
                class="btn btn-primary btn-round ms-auto">
                <i class="fa fa-plus me-1"></i>
                Add Blog
            </a>
            @endcan

        </div>

        <x-admin.alert />

        {{-- Card --}}
        <div class="card">

            <div class="card-header">

                <div class="d-flex align-items-center">

                    <div>
                        <h4 class="card-title mb-1">
                            Blogs
                        </h4>

                        <p class="text-muted mb-0">
                            Manage all blog posts
                        </p>
                    </div>


                    {{-- Search --}}
                    <form
                        action="{{ route('admin.blogs.index') }}"
                        method="GET"
                        class="ms-auto">
                        <div class="input-group">

                            <input
                                type="text"
                                name="search"
                                value="{{ request('search') }}"
                                class="form-control"
                                placeholder="Search blog...">

                            <button
                                type="submit"
                                class="btn btn-primary">
                                <i class="fa fa-search"></i>
                            </button>

                        </div>
                    </form>

                </div>

            </div>


            <div class="card-body">

                <div class="table-responsive">

                    <table class="table table-hover align-middle">

                        <thead>
                            <tr>

                                <th width="60">#</th>

                                <th width="90">
                                    Image
                                </th>

                                <th>
                                    Title
                                </th>

                                <th>
                                    Category
                                </th>

                                <th>
                                    Status
                                </th>

                                <th>
                                    Published
                                </th>

                                <th width="170">
                                    Action
                                </th>

                            </tr>
                        </thead>


                        <tbody>

                            @forelse ($blogs as $blog)

                            <tr>

                                {{-- Number --}}
                                <td>
                                    {{ $blogs->firstItem() + $loop->index }}
                                </td>


                                {{-- Featured Image --}}
                                <td>

                                    @if ($blog->featured_image)

                                    <img
                                        src="{{ asset('storage/' . $blog->featured_image) }}"
                                        alt="{{ $blog->title }}"
                                        class="rounded"
                                        style="
                                                    width: 65px;
                                                    height: 50px;
                                                    object-fit: cover;
                                                ">

                                    @else

                                    <div
                                        class="rounded bg-light d-flex align-items-center justify-content-center"
                                        style="
                                                    width: 65px;
                                                    height: 50px;
                                                ">
                                        <i class="fas fa-image text-muted"></i>
                                    </div>

                                    @endif

                                </td>


                                {{-- Title --}}
                                <td>

                                    <div class="fw-semibold">
                                        {{ $blog->title }}
                                    </div>

                                    @if ($blog->slug)
                                    <small class="text-muted">
                                        {{ $blog->slug }}
                                    </small>
                                    @endif

                                </td>


                                {{-- Category --}}
                                <td>

                                    @if ($blog->category)

                                    <span class="badge bg-info">
                                        {{ $blog->category->name }}
                                    </span>

                                    @else

                                    <span class="text-muted">
                                        —
                                    </span>

                                    @endif

                                </td>


                                {{-- Status --}}
                                <td>

                                    @if ($blog->status)

                                    <span class="badge bg-success">
                                        Published
                                    </span>

                                    @else

                                    <span class="badge bg-secondary">
                                        Draft
                                    </span>

                                    @endif

                                </td>


                                {{-- Published --}}
                                <td>

                                    @if ($blog->published_at)

                                    <div>
                                        {{ $blog->published_at->format('d M Y') }}
                                    </div>

                                    <small class="text-muted">
                                        {{ $blog->published_at->format('h:i A') }}
                                    </small>

                                    @else

                                    <span class="text-muted">
                                        —
                                    </span>

                                    @endif

                                </td>


                                {{-- Actions --}}
                                <td>

                                    <div class="d-flex gap-1">

                                        @can('blogs.view')

                                        <a
                                            href="{{ route('admin.blogs.show', $blog) }}"
                                            class="btn btn-sm btn-info"
                                            title="View"
                                            data-bs-toggle="tooltip">
                                            <i class="fa fa-eye"></i>
                                        </a>

                                        @endcan


                                        @can('blogs.edit')

                                        <a
                                            href="{{ route('admin.blogs.edit', $blog) }}"
                                            class="btn btn-sm btn-primary"
                                            title="Edit"
                                            data-bs-toggle="tooltip">
                                            <i class="fa fa-edit"></i>
                                        </a>

                                        @endcan


                                        @can('blogs.delete')

                                        <form
                                            action="{{ route('admin.blogs.destroy', $blog) }}"
                                            method="POST"
                                            class="d-inline"
                                            onsubmit="return confirm('Are you sure you want to delete this blog?')">
                                            @csrf
                                            @method('DELETE')

                                            <button
                                                type="submit"
                                                class="btn btn-sm btn-danger"
                                                title="Delete"
                                                data-bs-toggle="tooltip">
                                                <i class="fa fa-trash"></i>
                                            </button>

                                        </form>

                                        @endcan
                                    </div>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="7">
                                    <div class="text-center py-5">
                                        <i class="fas fa-newspaper fa-3x text-muted mb-3"></i>
                                        <h5 class="text-muted">
                                            No blogs found
                                        </h5>
                                        @can('blogs.create')
                                        <a
                                            href="{{ route('admin.blogs.create') }}"
                                            class="btn btn-primary btn-sm mt-2">
                                            <i class="fa fa-plus me-1"></i>
                                            Create Blog
                                        </a>
                                        @endcan
                                    </div>
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                {{-- Pagination --}}
                @if ($blogs->hasPages())
                <div class="d-flex justify-content-end mt-3">
                    {{ $blogs->links() }}
                </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection