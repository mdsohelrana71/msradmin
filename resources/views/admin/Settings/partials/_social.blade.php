<div class="settings-tab-pane" id="social">
    <div class="card">
        <div class="card-header">
            <h4 class="card-title mb-1">
                Social Media Settings
            </h4>
            <p class="text-muted mb-0">
                Manage your social media profile links.
            </p>
        </div>

        <div class="card-body">
            <div class="form-group">
                <label for="facebook_url">
                    <i class="fab fa-facebook me-1"></i>
                    Facebook
                </label>
                <input type="url"
                       name="facebook_url"
                       id="facebook_url"
                       class="form-control"
                       value="{{ old('facebook_url', $settings->facebook_url ?? '') }}"
                       placeholder="https://facebook.com/username">

            </div>

            <div class="form-group">
                <label for="instagram_url">
                    <i class="fab fa-instagram me-1"></i>
                    Instagram
                </label>
                <input type="url"
                       name="instagram_url"
                       id="instagram_url"
                       class="form-control"
                       value="{{ old('instagram_url', $settings->instagram_url ?? '') }}"
                       placeholder="https://instagram.com/username">
            </div>

            <div class="form-group">
                <label for="youtube_url">
                    <i class="fab fa-youtube me-1"></i>
                    YouTube
                </label>
                <input type="url"
                       name="youtube_url"
                       id="youtube_url"
                       class="form-control"
                       value="{{ old('youtube_url', $settings->youtube_url ?? '') }}"
                       placeholder="https://youtube.com/@channel">
            </div>

            <div class="form-group mb-0">
                <label for="linkedin_url">
                    <i class="fab fa-linkedin me-1"></i>
                    LinkedIn
                </label>
                <input type="url"
                       name="linkedin_url"
                       id="linkedin_url"
                       class="form-control"
                       value="{{ old('linkedin_url', $settings->linkedin_url ?? '') }}"
                       placeholder="https://linkedin.com/company/...">
            </div>
        </div>
    </div>
</div>