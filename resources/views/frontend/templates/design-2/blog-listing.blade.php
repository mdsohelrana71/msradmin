@extends('frontend.layouts.app')

@section('title', 'Blog')

@push('styles')
    <link rel="stylesheet" href="{{ app(\App\Services\Frontend\DesignManager::class)->getTemplateCss('blog-listing') }}">
    <link rel="stylesheet" href="{{ app(\App\Services\Frontend\DesignManager::class)->getSectionCss('blog_card') }}">
@endpush

@section('content')
    <!-- Breadcrumb Section Begin -->
    <section class="breadcrumb-section set-bg">
        <div class="container">
            <div class="row">
                <div class="col-lg-12 text-center">
                    <div class="breadcrumb__text">
                        <h2>Blog</h2>
                        <div class="breadcrumb__option">
                            <a href="{{ url('/') }}">Home</a>
                            <span>Blog</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- Breadcrumb Section End -->

    <!-- Blog Section Begin -->
    <section class="blog spad">
        <div class="container">
            <div class="row">
                <div class="col-lg-4 col-md-5">
                    <div class="blog__sidebar">
                        {{-- Search --}}
                        <div class="blog__sidebar__search">
                            <form action="{{ route('blog.index') }}" method="GET">
                                <input type="text" name="search" value="{{ request('search') }}" placeholder="Search...">
                                <button type="submit">
                                    <span class="icon_search"></span>
                                </button>
                            </form>
                        </div>

                        {{-- Categories --}}
                        <div class="blog__sidebar__item">
                            <h4>Categories</h4>
                            <ul>
                                <li>
                                    <a href="{{ route('blog.index') }}">All</a>
                                </li>
                                @foreach ($blogCategories ?? [] as $category)
                                    <li>
                                        <a href="{{ route('blog.index', ['category' => $category->slug]) }}">
                                            {{ $category->name }}
                                            @if (isset($category->blogs_count))
                                                ({{ $category->blogs_count }})
                                            @endif
                                        </a>
                                    </li>
                                @endforeach
                            </ul>
                        </div>

                        {{-- Recent News --}}
                        <div class="blog__sidebar__item">
                            <h4>Recent News</h4>
                            <div class="blog__sidebar__recent">
                                @foreach ($recentBlogs ?? [] as $recentBlog)
                                    <a href="{{ route('blog.show', ['blog' => $recentBlog->slug]) }}" class="blog__sidebar__recent__item">
                                        <div class="blog__sidebar__recent__item__pic">
                                            <img src="{{ asset('storage/' . $recentBlog->featured_image) }}" alt="{{ $recentBlog->title }}" loading="lazy">
                                        </div>
                                        <div class="blog__sidebar__recent__item__text">
                                            <h6>{{ \Illuminate\Support\Str::limit($recentBlog->title, 45) }}</h6>
                                            <span>{{ optional($recentBlog->published_at)->format('M d, Y') }}</span>
                                        </div>
                                    </a>
                                @endforeach
                            </div>
                        </div>

                        {{-- Tags --}}
                        <div class="blog__sidebar__item">
                            <h4>Search By</h4>
                            <div class="blog__sidebar__item__tags">
                                @foreach ($blogTags ?? [] as $tag)
                                    <a href="{{ route('blog.index', ['tag' => $tag->slug]) }}">
                                        {{ $tag->name }}
                                    </a>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Blog Listing --}}
                <div class="col-lg-8 col-md-7">
                    <div class="row">
                        @forelse ($blogs as $blog)
                            <div class="col-lg-6 col-md-6 col-sm-6">
                                @include($blogCardView, ['blog' => $blog])
                            </div>
                        @empty
                            <div class="col-lg-12">
                                <p class="text-center">No blogs found.</p>
                            </div>
                        @endforelse

                        {{-- Pagination --}}
                        @if ($blogs instanceof \Illuminate\Contracts\Pagination\LengthAwarePaginator)
                            <div class="col-lg-12">
                                <div class="product__pagination blog__pagination">
                                    {{ $blogs->withQueryString()->links('pagination::bootstrap-5') }}
                                </div>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- Blog Section End -->
@endsection