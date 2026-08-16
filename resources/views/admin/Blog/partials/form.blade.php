<div class="row">
    <div class="col-lg-8">
        <div class="card border shadow-none mb-4">
            <div class="card-header">
                <h5 class="card-title mb-0">Blog Content</h5>
            </div>

            <div class="card-body">
                <div class="form-group mb-1">
                    <label for="title">
                        Title <span class="text-danger">*</span>
                    </label>
                    <input
                        type="text"
                        name="title"
                        id="title"
                        class="form-control @error('title') is-invalid @enderror"
                        value="{{ old('title', $blog->title ?? '') }}"
                        placeholder="Enter blog title"
                        required
                    >
                    @error('title')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group mb-1">
                    <label for="excerpt">Short Description</label>
                    <textarea
                        name="excerpt"
                        id="excerpt"
                        rows="4"
                        class="form-control @error('excerpt') is-invalid @enderror"
                        placeholder="Write a short description of the blog..."
                    >{{ old('excerpt', $blog->excerpt ?? '') }}</textarea>
                    @error('excerpt')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group mb-1">
                    <label for="content">
                        Content <span class="text-danger">*</span>
                    </label>

                    <textarea
                        name="content"
                        id="content"
                        class="form-control"
                        rows="15"
                    >{{ old('content', $blog->content ?? '') }}</textarea>
                    @error('content')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>
        </div>

        <div class="card border shadow-none mb-4">
            <div class="card-header">
                <h5 class="card-title mb-0">SEO Settings</h5>
            </div>

            <div class="card-body">
                <div class="form-group mb-1">
                    <label for="meta_title">SEO Title</label>
                    <input
                        type="text"
                        name="meta_title"
                        id="meta_title"
                        class="form-control @error('meta_title') is-invalid @enderror"
                        value="{{ old('meta_title', $blog->meta_title ?? '') }}"
                        placeholder="SEO title"
                    >
                    @error('meta_title')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group mb-1">
                    <label for="meta_description">SEO Description</label>
                    <textarea
                        name="meta_description"
                        id="meta_description"
                        rows="4"
                        class="form-control @error('meta_description') is-invalid @enderror"
                        placeholder="SEO meta description..."
                    >{{ old('meta_description', $blog->meta_description ?? '') }}</textarea>
                    @error('meta_description')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group mb-1">
                    <label for="meta_keywords">SEO Keywords</label>
                    <input
                        type="text"
                        name="meta_keywords"
                        id="meta_keywords"
                        class="form-control @error('meta_keywords') is-invalid @enderror"
                        value="{{ old('meta_keywords', $blog->meta_keywords ?? '') }}"
                        placeholder="Laravel, PHP, Web Development"
                    >
                    @error('meta_keywords')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group mb-0">
                    <label for="canonical_url">Canonical URL</label>
                    <input
                        type="url"
                        name="canonical_url"
                        id="canonical_url"
                        class="form-control @error('canonical_url') is-invalid @enderror"
                        value="{{ old('canonical_url', $blog->canonical_url ?? '') }}"
                        placeholder="https://example.com/blog/example"
                    >
                    @error('canonical_url')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>
        </div>
    </div>

    <div class="col-lg-4">
        <div class="card border shadow-none mb-4">
            <div class="card-header">
                <h5 class="card-title mb-0">Blog Settings</h5>
            </div>

            <div class="card-body">
                <div class="form-group mb-1">
                    <label class="form-label">
                        Category <span class="text-danger">*</span>
                    </label>

                    @php
                        $selectedCategory = old('category_id', $blog->category_id ?? null);
                    @endphp

                    <div class="category-tree">
                        @foreach ($categories->whereNull('parent_id') as $category)
                            @include('admin.Blog.partials.category-tree', [
                                'category' => $category,
                                'selectedCategory' => $selectedCategory,
                            ])
                        @endforeach
                    </div>

                    @error('category_id')
                        <div class="text-danger small mt-2">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group mb-1">
                    <label for="status">Status</label>
                    <select
                        name="status"
                        id="status"
                        class="form-select @error('status') is-invalid @enderror"
                    >
                        <option value="0" @selected(old('status', $blog->status ?? false) == false)>
                            Draft
                        </option>

                        <option value="1" @selected(old('status', $blog->status ?? false) == true)>
                            Published
                        </option>
                    </select>
                    @error('status')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group mb-1">
                    <label for="published_at">Published Date</label>
                    <input
                        type="datetime-local"
                        name="published_at"
                        id="published_at"
                        class="form-control @error('published_at') is-invalid @enderror"
                        value="{{ old(
                            'published_at',
                            isset($blog->published_at)
                                ? $blog->published_at->format('Y-m-d\TH:i')
                                : ''
                        ) }}"
                    >
                    @error('published_at')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group mb-1">
                    <label for="tags">Tags</label>

                    <div class="form-control gap-2"
                        id="tags-container"
                        style="min-height: 45px; cursor: text;"
                    >
                        @foreach ($blog->tags ?? [] as $tag)
                            <span class="badge bg-primary gap-1 tag-item">
                                {{ ucfirst($tag->name) }}

                                <button
                                    type="button"
                                    class="btn-close btn-close-white remove-tag"
                                    style="font-size: 8px;"
                                ></button>

                                <input
                                    type="hidden"
                                    name="tags[]"
                                    value="{{ $tag->id }}"
                                >
                            </span>
                        @endforeach

                        <input
                            type="text"
                            id="tag-input"
                            class="border-0 outline-none grow"
                            placeholder="Type a tag and press Enter..."
                            autocomplete="off"
                            style="min-width: 180px; outline: none;"
                        >
                    </div>

                    @error('tags')
                        <div class="invalid-feedback d-block">
                            {{ $message }}
                        </div>
                    @enderror
                </div>

                <div class="form-check">
                    <input
                        type="checkbox"
                        name="is_featured"
                        value="1"
                        id="is_featured"
                        class="form-check-input"
                        @checked(old('is_featured', $blog->is_featured ?? false))
                    >
                    <label class="form-check-label" for="is_featured">
                        Featured Blog
                    </label>
                </div>

                <div class="form-check">
                    <input
                        type="checkbox"
                        name="allow_comments"
                        value="1"
                        id="allow_comments"
                        class="form-check-input"
                        @checked(old('allow_comments', $blog->allow_comments ?? true))
                    >
                    <label class="form-check-label" for="allow_comments">
                        Allow Comments
                    </label>
                </div>
            </div>
        </div>

        <div class="card border shadow-none mb-4">
            <div class="card-header">
                <h5 class="card-title mb-0">Featured Image</h5>
            </div>

            <div class="card-body">
                @if (!empty($blog?->featured_image))
                    <div class="mb-1">
                        <img
                            src="{{ asset('storage/' . $blog->featured_image) }}"
                            alt="{{ $blog->title }}"
                            class="img-fluid rounded"
                        >
                    </div>
                @endif

                <input
                    type="file"
                    name="featured_image"
                    id="featured_image"
                    class="form-control @error('featured_image') is-invalid @enderror"
                    accept="image/*"
                >
                <small class="text-muted">
                    Recommended size: 1200 × 630px
                </small>
                @error('featured_image')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
        </div>

        <div class="card border shadow-none">
            <div class="card-header">
                <h5 class="card-title mb-0">Social Sharing</h5>
            </div>

            <div class="card-body">
                <label for="og_image" class="form-label">
                    Open Graph Image
                </label>

                @if (!empty($blog?->og_image))
                    <div class="mb-1">
                        <img
                            src="{{ asset('storage/' . $blog->og_image) }}"
                            alt="OG Image"
                            class="img-fluid rounded"
                        >
                    </div>
                @endif

                <input
                    type="file"
                    name="og_image"
                    id="og_image"
                    class="form-control @error('og_image') is-invalid @enderror"
                    accept="image/*"
                >

                <small class="text-muted">
                    Recommended size: 1200 × 630px
                </small>

                @error('og_image')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
        </div>
    </div>
</div>

@push('scripts')
    <script src="{{ asset('assets/js/plugin/ckeditor.js') }}"></script>
    <script src="{{ asset('assets/js/tags.js') }}"></script>

    <script>
        ClassicEditor
            .create(document.querySelector('#content'))
            .catch(error => {
                console.error(error);
            });
    </script>
@endpush