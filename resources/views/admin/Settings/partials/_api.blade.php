<div class="settings-tab-pane" id="api">
    <div class="card">
        <div class="card-header">
            <h4 class="card-title mb-1">
                API Settings
            </h4>
            <p class="text-muted mb-0">
                Manage third-party API configuration.
            </p>
        </div>

        <div class="card-body">
            <div class="form-group">
                <label for="api_base_url">
                    API Base URL
                </label>
                <input type="url"
                       name="api_base_url"
                       id="api_base_url"
                       class="form-control"
                       value="{{ old('api_base_url', $settings->api_base_url ?? '') }}"
                       placeholder="https://api.example.com">
            </div>


            <div class="form-group">
                <label for="api_key">
                    API Key
                </label>
                <input type="password"
                       name="api_key"
                       id="api_key"
                       class="form-control"
                       placeholder="Enter API key">
            </div>

            <div class="form-group mb-0">
                <label for="api_timeout">
                    API Timeout
                </label>
                <div class="input-group">
                    <input type="number"
                           name="api_timeout"
                           id="api_timeout"
                           class="form-control"
                           value="{{ old('api_timeout', $settings->api_timeout ?? 30) }}"
                           min="1">

                    <span class="input-group-text">
                        Seconds
                    </span>
                </div>
            </div>
        </div>
    </div>
</div>