@extends('layouts.admin')

@section('title', 'Edit Blog')

@section('content')
<div class="container">
    <div class="page-inner">

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
                    <span>Edit Blog</span>
                </li>

            </ul>
        </div>

        @if ($errors->any())
            <div class="alert alert-danger">
                <ul class="mb-0">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <div class="card">

            <div class="card-header">
                <div class="d-flex align-items-center">

                    <h4 class="card-title">
                        Edit Blog
                    </h4>

                    <a
                        href="{{ route('admin.blogs.index') }}"
                        class="btn btn-secondary btn-round ms-auto"
                    >
                        <i class="fas fa-arrow-left me-1"></i>
                        Back
                    </a>

                </div>
            </div>

            <div class="card-body">

                <form
                    action="{{ route('admin.blogs.update', $blog) }}"
                    method="POST"
                    enctype="multipart/form-data"
                >
                    @csrf
                    @method('PUT')

                    @include(
                        'admin.Blog.partials.form',
                        ['blog' => $blog]
                    )

                    <div class="mt-4">

                        <button
                            type="submit"
                            class="btn btn-primary"
                        >
                            <i class="fas fa-save me-1"></i>
                            Update Blog
                        </button>

                        <a
                            href="{{ route('admin.blogs.index') }}"
                            class="btn btn-light ms-2"
                        >
                            Cancel
                        </a>

                    </div>

                </form>

            </div>

        </div>

    </div>
</div>
@endsection