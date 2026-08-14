@extends('layouts.admin')

@section('title', 'Add Blog')

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
                    'label' => 'Add Blog',
                ],
            ]"
        />

        <x-admin.alert />

        <div class="card">
            <div class="card-header">
                <div class="d-flex align-items-center">
                    <h4 class="card-title">Add Blog</h4>
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
                @can('blogs.create')
                    <form
                        action="{{ route('admin.blogs.store') }}"
                        method="POST"
                        enctype="multipart/form-data"
                    >
                        @csrf

                        @include('admin.Blog.partials.form')

                        <x-admin.form-actions
                            submitText="Save Blog"
                            :cancelUrl="route('admin.blogs.index')"
                        />
                    </form>
                @endcan
            </div>
        </div>
    </div>
</div>
@endsection