<section class="py-5">
    <div class="main">
        <div class="container">
            <!-- Breadcrumb -->
            <nav aria-label="breadcrumb" class="mb-3">
                <ol class="breadcrumb small mb-0">
                    <li class="breadcrumb-item">
                        <a href="{{ route('home') }}" class="text-muted text-decoration-none">Home</a>
                    </li>
                    <li class="breadcrumb-item">
                        <a href="{{ route('blog.index') }}" class="text-muted text-decoration-none">Blogs</a>
                    </li>
                    <li class="breadcrumb-item active">{{ $blog->title }}</li>
                </ol>
            </nav>
            <div class="text-center">
            </div>
            <div class="row">
                <div class="col-lg-12">
                    <div class="content-area">
                        <!-- Featured Image -->
                        @if ($blog->featured_image)
                            <img src="{{ asset('storage/' . $blog->featured_image) }}"
                                class="img-fluid rounded mb-4 blog-banner" alt="{{ $blog->title }}">
                        @endif
                        <!-- Meta -->
                        <div class="mb-3 text-muted small">
                            @if ($blog->published_at)
                                <span>
                                    <i class="far fa-calendar-alt me-1"></i>
                                    {{ $blog->published_at->format('F d, Y') }}
                                </span>
                            @endif
                            <span class="mx-3">|</span>
                            <span>
                                <i class="far fa-user me-1"></i>
                                {{ $blog->author->name }}
                            </span>
                            <span class="mx-3">|</span>
                            <span>
                                <i class="far fa-folder me-1"></i>
                                {{ $blog->category->name }}
                            </span>
                        </div>
                        <!-- Title -->
                        <h1 class="fw-bold mb-4">
                            {{ $blog->title }}
                        </h1>
                        <!-- Content -->
                        <div class="text-muted blog-content">
                            {!! $blog->content !!}
                        </div>
                        <!-- Tags -->
                        @if ($blog->tags->count())
                            <div class="mt-4">
                                <h6 class="fw-bold mb-3">Tags</h6>
                                @foreach ($blog->tags as $tag)
                                    <a href="#" class="btn btn-outline-secondary btn-sm me-2 mb-2">
                                        {{ $tag->name }}
                                    </a>
                                @endforeach
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
