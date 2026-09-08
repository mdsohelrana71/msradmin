<div class="card border-0 shadow-sm h-100 blog-card overflow-hidden">
    <div class="position-relative">
        <a href="{{ route('blog.show', $blog) }}">
            <img src="{{ asset('storage/' . ltrim($blog->featured_image, '/')) }}" class="card-img-top blog-img"
                alt="{{ $blog->title }}">
        </a>
        {{-- Optional: date badge on image --}}
        <span class="badge bg-white text-dark position-absolute top-0 start-0 m-3 shadow-sm rounded-pill px-3 py-2">
            <i class="far fa-calendar-alt me-1"></i>
            {{ $blog->published_at }}
        </span>
    </div>

    <div class="card-body d-flex flex-column p-4">
        <h5 class="card-title fw-semibold mb-2 line-clamp-2">
            {{ $blog->title }}
        </h5>

        <p class="card-text text-muted mb-4 grow line-clamp-3">
            {{ Str::limit($blog->excerpt, 100) }}
        </p>

        <a href="{{ route('blog.show', $blog) }}" class="btn btn-outline-primary btn-sm align-self-start px-4">
            Read More
            <i class="fas fa-arrow-right ms-2"></i>
        </a>
    </div>
</div>
