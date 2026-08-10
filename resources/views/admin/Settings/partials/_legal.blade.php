<div class="settings-tab-pane" id="legal">
    <div class="card">
        <div class="card-header">
            <h4 class="card-title mb-1">
                Legal Settings
            </h4>
            <p class="text-muted mb-0">
                Manage your website legal information.
            </p>
        </div>

        <div class="card-body">
            <div class="form-group">
                <label for="privacy_policy_url">
                    Privacy Policy URL
                </label>
                <input type="url"
                       name="privacy_policy_url"
                       id="privacy_policy_url"
                       class="form-control"
                       value="{{ old('privacy_policy_url', $settings->privacy_policy_url ?? '') }}"
                       placeholder="https://example.com/privacy-policy">
            </div>

            <div class="form-group">
                <label for="terms_url">
                    Terms & Conditions URL
                </label>
                <input type="url"
                       name="terms_url"
                       id="terms_url"
                       class="form-control"
                       value="{{ old('terms_url', $settings->terms_url ?? '') }}"
                       placeholder="https://example.com/terms">
            </div>

            <div class="form-group mb-0">
                <label for="cookie_policy_url">
                    Cookie Policy URL
                </label>
                <input type="url"
                       name="cookie_policy_url"
                       id="cookie_policy_url"
                       class="form-control"
                       value="{{ old('cookie_policy_url', $settings->cookie_policy_url ?? '') }}"
                       placeholder="https://example.com/cookie-policy">
            </div>
        </div>
    </div>
</div>