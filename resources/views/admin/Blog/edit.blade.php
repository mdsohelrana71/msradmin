@extends('layouts.admin')

@section('title', 'Edit Blog')

@section('content')
<div class="container">
    <div class="page-inner">
        <x-admin.breadcrumb
            title="Edit Blog"
            :items="[
                ['label' => 'Blogs', 'url' => route('admin.blogs.index')],
                ['label' => 'Edit Blog'],
            ]"
        />

        <div class="card">
            <div class="card-header">
                <div class="d-flex align-items-center">
                    <h4 class="card-title">Edit Blog</h4>
                    <a href="{{ route('admin.blogs.index') }}" class="btn btn-secondary btn-round ms-auto">
                        <i class="fas fa-arrow-left me-1"></i> Back
                    </a>
                </div>
            </div>

            <div class="card-body">
                <form action="{{ route('admin.blogs.update', $blog) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')

                    @include('admin.Blog.partials.form', ['blog' => $blog])

                    <x-admin.form-actions
                        submit="Update Blog"
                        cancel="{{ route('admin.blogs.index') }}"
                    />
                </form>
            </div>
        </div>
    </div>
</div>
@endsection