<div class="blog__item">
    <div class="blog__item__pic">
        <img src="{{ $blog->featured_image ? asset($blog->featured_image) : asset('frontend/images/blog/blog-2.jpg') }}" alt="{{ $blog->title }}">
    </div>
    <div class="blog__item__text">
        <ul>
            <li><i class="fa fa-calendar-o"></i> {{ $blog->published_at?->format('M d,Y') ?? $blog->created_at->format('M d,Y') }}</li>
            <li><i class="fa fa-comment-o"></i> {{ $blog->comments_count ?? 0 }}</li>
        </ul>
        <h5>
            <a href="{{ route('blog.show', $blog->slug) }}">{{ $blog->title }}</a>
        </h5>
        <p>{{ \Illuminate\Support\Str::limit(strip_tags($blog->excerpt ?? $blog->content), 120) }}</p>
    </div>
</div>