<div class="card border-0 shadow-sm h-100">
    <img src="{{ asset('storage/' . ltrim($blog->featured_image, '/')) }}"
        class="card-img-top blog-img" alt="Blog Image">

    <div class="card-body">
        <small class="text-muted">
            <i class="far fa-calendar-alt me-1"></i>
            {{ $blog->published_at }}
        </small>

        <h5 class="card-title mt-3">
            {{ $blog->title }}
        </h5>

        <p class="card-text text-muted">
            {{ $blog->excerpt }}
        </p>

        <a href="{{ route('blog.show', $blog) }}"
            class="btn btn-outline-primary btn-sm">
            Read More
        </a>
    </div>
</div>