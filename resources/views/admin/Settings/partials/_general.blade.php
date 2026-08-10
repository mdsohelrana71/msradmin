<div class="settings-tab-pane active" id="general">
    <div class="card">
        <div class="card-header">
            <h4 class="card-title mb-1">
                General Settings
            </h4>
            <p class="text-muted mb-0">
                Manage your basic website information.
            </p>
        </div>

        <div class="card-body">
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="site_name">
                            Site Name
                        </label>
                        <input type="text"
                               name="site_name"
                               id="site_name"
                               class="form-control"
                               value="{{ old('site_name', $settings->site_name ?? '') }}"
                               placeholder="Enter site name">
                    </div>
                </div>


                <div class="col-md-6">
                    <div class="form-group">
                        <label for="site_email">
                            Site Email
                        </label>

                        <input type="email"
                               name="site_email"
                               id="site_email"
                               class="form-control"
                               value="{{ old('site_email', $settings->site_email ?? '') }}"
                               placeholder="example@email.com">
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="form-group">
                        <label for="site_phone">
                            Site Phone
                        </label>

                        <input type="text"
                            name="site_phone"
                            id="site_phone"
                            class="form-control"
                            value="{{ old('site_phone', $settings->site_phone ?? '') }}"
                            placeholder="+8801XXXXXXXXX">
                </div>
                </div>


                <div class="col-md-6">
                    <div class="form-group">
                        <label for="timezone">
                            Timezone
                        </label>

                        <select name="timezone"
                                id="timezone"
                                class="form-control">
                            <option value="Asia/Dhaka"
                                {{ old('timezone', $settings->timezone ?? 'Asia/Dhaka') === 'Asia/Dhaka' ? 'selected' : '' }}>
                                Asia/Dhaka
                            </option>
                            <option value="UTC"
                                {{ old('timezone', $settings->timezone ?? '') === 'UTC' ? 'selected' : '' }}>
                                UTC
                            </option>
                        </select>
                    </div>
                </div>

                <div class="col-md-12">
                    <div class="form-group">
                        <label for="site_description">
                            Site Description
                        </label>
                        <textarea 
                            name="site_description"
                            id="site_description"
                            rows="4"
                            class="form-control"
                            placeholder="Enter site description">{{ old('site_description', $settings->site_description ?? '') }}
                        </textarea>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>