<div class="row">
    <div class="col-md-8">
        <div class="mb-3">
            <label for="email" class="form-label">Email</label>
            <input type="email" name="email" id="email" class="form-control @error('email') is-invalid @enderror" value="{{ old('email', $newsletterSubscriber->email ?? '') }}" placeholder="Enter subscriber email">
            @error('email')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>
    </div>
    <div class="col-md-4">
        <div class="mb-3">
            <label class="form-label d-block">Status</label>
            <div class="form-check form-switch">
                <input type="hidden" name="status" value="0">
                <input type="checkbox" name="status" value="1" class="form-check-input" id="status" {{ old('status', $newsletterSubscriber->status ?? true) ? 'checked' : '' }}>
                <label class="form-check-label" for="status">Active</label>
            </div>
        </div>
    </div>
</div>