@extends('layouts.admin')

@section('title', 'Blog Categories')

@section('content')

<div class="container">
    <div class="page-inner">

        {{-- Header --}}
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
                    <span>Blog Categories</span>
                </li>

            </ul>

            <a
                href="{{ route('admin.blog-categories.create') }}"
                class="btn btn-primary btn-round ms-auto"
            >
                <i class="fa fa-plus me-1"></i>
                Add Category
            </a>

        </div>


        {{-- Success --}}
        @if (session('success'))

            <div
                class="alert alert-success alert-dismissible fade show position-fixed top-0 end-0 m-3 shadow"
                style="z-index: 9999; min-width: 300px;"
                role="alert"
            >
                <i class="fas fa-check-circle me-2"></i>
                {{ session('success') }}

                <button
                    type="button"
                    class="btn-close"
                    data-bs-dismiss="alert"
                ></button>
            </div>

        @endif


        {{-- Validation Error --}}
        @if ($errors->has('category'))

            <div class="alert alert-danger">
                {{ $errors->first('category') }}
            </div>

        @endif


        <div class="card">

            <div class="card-header">

                <div class="d-flex align-items-center">

                    <div>
                        <h4 class="card-title mb-1">
                            Blog Categories
                        </h4>

                        <p class="text-muted mb-0">
                            Manage your blog category hierarchy.
                        </p>
                    </div>

                </div>

            </div>


            <div class="card-body p-0">

                @if ($categories->isNotEmpty())

                    <div class="category-tree">

                        @include(
                            'admin.Blog.Category.partials.tree',
                            ['categories' => $categories]
                        )

                    </div>

                @else

                    <div class="text-center py-5">

                        <i class="fas fa-folder-open fa-3x text-muted mb-3"></i>

                        <h5>
                            No categories found
                        </h5>

                        <a
                            href="{{ route('admin.blog-categories.create') }}"
                            class="btn btn-primary mt-2"
                        >
                            <i class="fa fa-plus me-1"></i>
                            Create Category
                        </a>

                    </div>

                @endif

            </div>

        </div>

    </div>
</div>

@endsection


@push('styles')
<style>

.category-row {
    min-height: 58px;
    padding: 10px 18px;

    display: flex;
    align-items: center;
    justify-content: space-between;

    border-bottom: 1px solid #eeeeee;
}

.category-left {
    display: flex;
    align-items: center;
    gap: 10px;
}


/* Checkbox */

.category-checkbox {
    width: 18px;
    height: 18px;
    cursor: pointer;
}

.category-label {
    margin: 0;
    cursor: pointer;
    font-weight: 500;
}


/* Expand Button */

.category-toggle {
    width: 30px;
    height: 30px;

    border: 1px solid #ddd;
    border-radius: 5px;

    background: #fff;

    display: flex;
    align-items: center;
    justify-content: center;

    cursor: pointer;
}

.category-toggle:hover {
    background: #f5f5f5;
}

.category-toggle i {
    font-size: 12px;
}


/* No Child Placeholder */

.category-toggle-placeholder {
    width: 30px;
}


/* Nested Category */

.category-children {
    margin-left: 38px;

    border-left: 1px solid #e5e5e5;
}


/* Actions */

.category-actions {
    display: flex;
    align-items: center;
    gap: 5px;
}

</style>
@endpush


@push('scripts')
<script>

document.addEventListener('DOMContentLoaded', function () {

    document
        .querySelectorAll('.category-toggle')
        .forEach(function (button) {

            const targetSelector =
                button.getAttribute('data-bs-target');

            const target =
                document.querySelector(targetSelector);

            if (!target) {
                return;
            }

            target.addEventListener(
                'shown.bs.collapse',
                function () {

                    const icon =
                        button.querySelector('i');

                    icon.classList.remove('fa-plus');
                    icon.classList.add('fa-minus');

                }
            );

            target.addEventListener(
                'hidden.bs.collapse',
                function () {

                    const icon =
                        button.querySelector('i');

                    icon.classList.remove('fa-minus');
                    icon.classList.add('fa-plus');

                }
            );

        });

});

</script>
@endpush