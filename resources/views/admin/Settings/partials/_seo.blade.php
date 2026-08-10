<div class="settings-tab-pane" id="seo">
    <div class="card">
        <div class="card-header">
            <h4 class="card-title mb-1">
                SEO Settings
            </h4>
            <p class="text-muted mb-0">
                Manage search engine optimization settings.
            </p>
        </div>

        <div class="card-body">
            <div class="form-group">
                <label for="meta_title">
                    Meta Title
                </label>
                <input type="text"
                       name="meta_title"
                       id="meta_title"
                       class="form-control"
                       value="{{ old('meta_title', $settings->meta_title ?? '') }}"
                       placeholder="Website Meta Title">
            </div>

            <div class="form-group">
                <label for="meta_description">
                    Meta Description
                </label>
                <textarea name="meta_description"
                          id="meta_description"
                          rows="4"
                          class="form-control"
                          placeholder="Website meta description">{{ old('meta_description', $settings->meta_description ?? '') }}</textarea>
            </div>

            <div class="form-group mb-0">
                <label for="meta_keywords">
                    Meta Keywords
                </label>
                <textarea name="meta_keywords"
                          id="meta_keywords"
                          rows="3"
                          class="form-control"
                          placeholder="keyword1, keyword2, keyword3">{{ old('meta_keywords', $settings->meta_keywords ?? '') }}</textarea>
                <small class="text-muted">
                    Separate keywords with commas.
                </small>
            </div>
        </div>
    </div>
</div>