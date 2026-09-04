<div class="row">
    <div class="col-md-6 mb-4">
        <label class="form-label text-muted small">
            Product
        </label>

        <div class="d-flex align-items-center">
            @if ($review->product?->thumbnail)
                <img
                    src="{{ asset('storage/' . $review->product->thumbnail) }}"
                    alt="{{ $review->product->name }}"
                    class="rounded me-3"
                    style="width:55px;height:55px;object-fit:cover;"
                >
            @else
                <div
                    class="rounded bg-light d-flex align-items-center justify-content-center me-3"
                    style="width:55px;height:55px;"
                >
                    <i class="fas fa-image text-muted"></i>
                </div>
            @endif

            <div>
                <div class="fw-semibold">
                    {{ $review->product?->name ?? '—' }}
                </div>

                @if ($review->product?->sku)
                    <small class="text-muted">
                        SKU: {{ $review->product->sku }}
                    </small>
                @endif
            </div>
        </div>
    </div>

    <div class="col-md-6 mb-4">
        <label class="form-label text-muted small">
            Customer
        </label>

        <div class="fw-medium">
            {{ $review->user?->name ?? '—' }}
        </div>

        @if ($review->user?->email)
            <small class="text-muted">
                {{ $review->user->email }}
            </small>
        @endif
    </div>

    <div class="col-md-6 mb-4">
        <label class="form-label text-muted small">
            Rating
        </label>

        <div class="text-warning">
            @for ($i = 1; $i <= 5; $i++)
                <i class="fa fa-star{{ $i <= $review->rating ? '' : '-o' }}"></i>
            @endfor

            <span class="text-muted ms-2">
                {{ $review->rating }}/5
            </span>
        </div>
    </div>

    <div class="col-md-6 mb-4">
        <label class="form-label text-muted small">
            Review Title
        </label>

        <div class="fw-medium">
            {{ $review->title ?: '—' }}
        </div>
    </div>

    <div class="col-md-12 mb-4">
        <label class="form-label text-muted small">
            Review
        </label>

        <div class="border rounded p-3 bg-light">
            {!! nl2br(e($review->review ?: 'No review text provided.')) !!}
        </div>

        <small class="text-muted">
            Customer review cannot be edited.
        </small>
    </div>

    <div class="col-md-6 mb-4">
        <label class="form-label">
            Verified
        </label>

        <div class="form-check form-switch mt-2">
            <input
                type="hidden"
                name="is_verified"
                value="0"
            >

            <input
                type="checkbox"
                name="is_verified"
                value="1"
                class="form-check-input"
                id="is_verified"
                {{ old('is_verified', $review->is_verified) ? 'checked' : '' }}
            >

            <label
                class="form-check-label"
                for="is_verified"
            >
                Verified Purchase
            </label>
        </div>
    </div>

    <div class="col-md-6 mb-4">
        <label class="form-label">
            Status <span class="text-danger">*</span>
        </label>

        <div class="form-check form-switch mt-2">
            <input
                type="hidden"
                name="status"
                value="0"
            >

            <input
                type="checkbox"
                name="status"
                value="1"
                class="form-check-input"
                id="status"
                {{ old('status', $review->status) ? 'checked' : '' }}
            >

            <label
                class="form-check-label"
                for="status"
            >
                Active
            </label>
        </div>

        @error('status')
            <div class="text-danger small mt-1">
                {{ $message }}
            </div>
        @enderror
    </div>

    @if ($review->images->isNotEmpty())
        <div class="col-md-12 mb-4">
            <label class="form-label text-muted small">
                Review Images
            </label>

            <div class="d-flex flex-wrap gap-3">
                @foreach ($review->images as $image)
                    <div
                        class="position-relative"
                        style="width:120px;"
                    >
                        <img
                            src="{{ asset('storage/' . $image->image) }}"
                            alt="Review image"
                            class="rounded border"
                            style="width:120px;height:120px;object-fit:cover;"
                        >

                        <div class="form-check mt-2">
                            <input
                                type="checkbox"
                                name="removed_image_ids[]"
                                value="{{ $image->id }}"
                                class="form-check-input"
                                id="removeImage{{ $image->id }}"
                            >

                            <label
                                class="form-check-label small"
                                for="removeImage{{ $image->id }}"
                            >
                                Remove
                            </label>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    @endif

    <div class="col-md-12 mb-4">
        <label for="images" class="form-label">
            Add Review Images
        </label>

        <input
            type="file"
            name="images[]"
            id="images"
            class="form-control @error('images') is-invalid @enderror"
            accept=".jpg,.jpeg,.png,.webp"
            multiple
        >

        <small class="text-muted">
            JPG, JPEG, PNG or WEBP. Maximum 2MB per image.
        </small>

        @error('images')
            <div class="invalid-feedback">
                {{ $message }}
            </div>
        @enderror
    </div>
</div>