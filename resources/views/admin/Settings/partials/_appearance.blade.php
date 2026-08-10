<div class="settings-tab-pane" id="appearance">
    <div class="card">
        <div class="card-header">
            <h4 class="card-title mb-1">
                Appearance Settings
            </h4>
            <p class="text-muted mb-0">
                Manage your website branding and appearance.
            </p>
        </div>

        <div class="card-body">
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="site_logo">
                            Site Logo
                        </label>
                        <input type="file"
                               name="site_logo"
                               id="site_logo"
                               class="form-control">
                        @if(!empty($settings->site_logo))
                            <div class="settings-image-preview mt-3">
                                <img src="{{ asset($settings->site_logo) }}"
                                     alt="Site Logo">
                            </div>
                        @endif
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="form-group">
                        <label for="site_favicon">
                            Site Favicon
                        </label>
                        <input type="file"
                               name="site_favicon"
                               id="site_favicon"
                               class="form-control">

                        @if(!empty($settings->site_favicon))
                            <div class="settings-favicon-preview mt-3">
                                <img src="{{ asset($settings->site_favicon) }}"
                                     alt="Site Favicon">
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>