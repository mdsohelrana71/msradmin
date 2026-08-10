<div class="settings-tab-pane" id="maintenance">
    <div class="card">
        <div class="card-header">
            <h4 class="card-title mb-1">
                Maintenance Settings
            </h4>
            <p class="text-muted mb-0">
                Temporarily disable public access to the website.
            </p>
        </div>

        <div class="card-body">
            <div class="form-check form-switch mb-4">
                <input type="hidden"
                       name="maintenance_mode"
                       value="0">
                <input class="form-check-input"
                       type="checkbox"
                       name="maintenance_mode"
                       value="1"
                       id="maintenance_mode"
                       {{ old('maintenance_mode', $settings->maintenance_mode ?? false) ? 'checked' : '' }}>
                <label class="form-check-label"
                       for="maintenance_mode">
                    <strong>Enable Maintenance Mode</strong>
                    <div class="text-muted small">
                        The public website will show a maintenance page.
                    </div>
                </label>
            </div>

            <div class="form-group mb-0">
                <label for="maintenance_message">
                    Maintenance Message
                </label>
                <textarea name="maintenance_message"
                          id="maintenance_message"
                          rows="4"
                          class="form-control"
                          placeholder="We are currently performing maintenance. Please check back later.">{{ old('maintenance_message', $settings->maintenance_message ?? '') }}</textarea>
            </div>
        </div>
    </div>
</div>