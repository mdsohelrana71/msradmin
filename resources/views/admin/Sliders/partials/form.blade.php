<div class="row">
    <div class="col-md-8">
        <div class="mb-3">
            <label for="title" class="form-label">Title</label>
            <input type="text" name="title" id="title" class="form-control @error('title') is-invalid @enderror" value="{{ old('title', $slider->title ?? '') }}" placeholder="Enter slider title">
            @error('title')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="mb-3">
            <label for="subtitle" class="form-label">Subtitle</label>
            <textarea name="subtitle" id="subtitle" rows="4" class="form-control @error('subtitle') is-invalid @enderror" placeholder="Enter slider subtitle">{{ old('subtitle', $slider->subtitle ?? '') }}</textarea>
            @error('subtitle')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="row">
            <div class="col-md-6">
                <div class="mb-3">
                    <label for="button_text" class="form-label">Button Text</label>
                    <input type="text" name="button_text" id="button_text" class="form-control @error('button_text') is-invalid @enderror" value="{{ old('button_text', $slider->button_text ?? '') }}" placeholder="e.g. Shop Now">
                    @error('button_text')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            <div class="col-md-6">
                <div class="mb-3">
                    <label for="button_url" class="form-label">Button URL</label>
                    <input type="text" name="button_url" id="button_url" class="form-control @error('button_url') is-invalid @enderror" value="{{ old('button_url', $slider->button_url ?? '') }}" placeholder="e.g. /products">
                    @error('button_url')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-4">
                <div class="mb-3">
                    <label for="sort_order" class="form-label">Sort Order</label>
                    <input type="number" name="sort_order" id="sort_order" min="0" class="form-control @error('sort_order') is-invalid @enderror" value="{{ old('sort_order', $slider->sort_order ?? 0) }}">
                    @error('sort_order')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            <div class="col-md-8">
                <div class="mb-3">
                    <label class="form-label d-block">Status</label>
                    <div class="form-check form-switch">
                        <input type="hidden" name="status" value="0">
                        <input type="checkbox" name="status" value="1" class="form-check-input" id="status" {{ old('status', $slider->status ?? true) ? 'checked' : '' }}>
                        <label class="form-check-label" for="status">Active</label>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-6">
                <div class="mb-3">
                    <label for="start_at" class="form-label">Start At</label>
                    <input type="datetime-local" name="start_at" id="start_at" class="form-control @error('start_at') is-invalid @enderror" value="{{ old('start_at', isset($slider->start_at) ? $slider->start_at->format('Y-m-d\TH:i') : '') }}">
                    @error('start_at')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            <div class="col-md-6">
                <div class="mb-3">
                    <label for="end_at" class="form-label">End At</label>
                    <input type="datetime-local" name="end_at" id="end_at" class="form-control @error('end_at') is-invalid @enderror" value="{{ old('end_at', isset($slider->end_at) ? $slider->end_at->format('Y-m-d\TH:i') : '') }}">
                    @error('end_at')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-4">
        <div class="mb-4">
            <label for="image" class="form-label">Desktop Image @if(!isset($slider))<span class="text-danger">*</span>@endif</label>
            <input type="file" name="image" id="image" class="form-control @error('image') is-invalid @enderror" accept="image/jpeg,image/png,image/webp">
            @error('image')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror

            @if(isset($slider) && $slider->image)
                <div class="mt-2">
                    <img src="{{ asset('storage/' . $slider->image) }}" alt="{{ $slider->title }}" class="img-fluid rounded border" style="max-height: 180px;">
                </div>
            @endif
            <small class="text-muted">Recommended: 1920 × 700px</small>
        </div>

        <div class="mb-3">
            <label for="mobile_image" class="form-label">Mobile Image</label>
            <input type="file" name="mobile_image" id="mobile_image" class="form-control @error('mobile_image') is-invalid @enderror" accept="image/jpeg,image/png,image/webp">
            @error('mobile_image')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror

            @if(isset($slider) && $slider->mobile_image)
                <div class="mt-2">
                    <img src="{{ asset('storage/' . $slider->mobile_image) }}" alt="{{ $slider->title }}" class="img-fluid rounded border" style="max-height: 180px;">
                </div>
            @endif
            <small class="text-muted">Recommended: 768 × 900px</small>
        </div>
    </div>
</div>