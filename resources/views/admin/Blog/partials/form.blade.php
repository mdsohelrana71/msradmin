<div class="row g-3">

    {{-- Title --}}
    <div class="col-md-8">
        <div class="form-group">
            <label for="title">
                Blog Title <span class="text-danger">*</span>
            </label>

            <input
                type="text"
                name="title"
                id="title"
                class="form-control @error('title') is-invalid @enderror"
                value="{{ old('title', $blog->title ?? '') }}"
                placeholder="Enter blog title"
                required>

            @error('title')
            <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>
    </div>


    {{-- Category --}}
    <div class="col-md-4">
        <div class="form-group">
            <label for="category_id">
                Category <span class="text-danger">*</span>
            </label>

            <select
                name="category_id"
                id="category_id"
                class="form-select @error('category_id') is-invalid @enderror"
                required>
                <option value="">Select Category</option>

                @foreach ($categories as $category)
                <option
                    value="{{ $category->id }}"
                    {{ old('category_id', $blog->category_id ?? '') == $category->id ? 'selected' : '' }}>
                    {{ $category->name }}
                </option>
                @endforeach
            </select>

            @error('category_id')
            <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>
    </div>


    {{-- Excerpt --}}
    <div class="col-md-12">
        <div class="form-group">
            <label for="excerpt">Excerpt</label>

            <textarea
                name="excerpt"
                id="excerpt"
                rows="3"
                class="form-control @error('excerpt') is-invalid @enderror"
                placeholder="Write a short summary...">{{ old('excerpt', $blog->excerpt ?? '') }}</textarea>

            @error('excerpt')
            <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>
    </div>


    {{-- Content --}}
    <div class="col-md-12">
        <div class="form-group">
            <label for="content">
                Content <span class="text-danger">*</span>
            </label>

            <textarea
                name="content"
                id="content"
                rows="10"
                class="form-control @error('content') is-invalid @enderror"
                placeholder="Write your blog content..."
                required>{{ old('content', $blog->content ?? '') }}</textarea>

            @error('content')
            <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>
    </div>


    {{-- Featured Image --}}
    <div class="col-md-6">
        <div class="form-group">
            <label for="featured_image">
                Featured Image
            </label>

            <input
                type="file"
                name="featured_image"
                id="featured_image"
                class="form-control @error('featured_image') is-invalid @enderror"
                accept="image/*">

            @error('featured_image')
            <div class="invalid-feedback">{{ $message }}</div>
            @enderror

            @if (!empty($blog?->featured_image))
            <div class="mt-3">
                <img
                    src="{{ asset('storage/' . $blog->featured_image) }}"
                    alt="{{ $blog->title }}"
                    class="img-thumbnail"
                    style="width: 180px; height: 120px; object-fit: cover;">
            </div>
            @endif
        </div>
    </div>

    {{-- Status --}}
    <div class="col-md-3">
        <div class="form-group">
            <label for="status">
                Status <span class="text-danger">*</span>
            </label>

            <select
                name="status"
                id="status"
                class="form-select @error('status') is-invalid @enderror"
                required>
                <option
                    value="1"
                    {{ old('status', $blog->status ?? 1) == 1 ? 'selected' : '' }}>
                    Published
                </option>
                <option
                    value="0"
                    {{ old('status', $blog->status ?? 0) == 0 ? 'selected' : '' }}>
                    Draft
                </option>
            </select>
            @error('status')
            <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>
    </div>

    {{-- Published At --}}
    <div class="col-md-3">
        <div class="form-group">
            <label for="published_at">Published At</label>
            <input
                type="datetime-local"
                name="published_at"
                id="published_at"
                class="form-control"
                value="{{ old(
                    'published_at',
                    isset($blog->published_at)
                        ? $blog->published_at->format('Y-m-d\TH:i')
                        : ''
                ) }}">
        </div>
    </div>
</div>