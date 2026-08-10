<div class="settings-tab-pane" id="email">
    <div class="card">
        <div class="card-header">
            <h4 class="card-title mb-1">
                Email Settings
            </h4>
            <p class="text-muted mb-0">
                Configure your outgoing email settings.
            </p>
        </div>

        <div class="card-body">
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="mail_host">Mail Host</label>
                        <input type="text"
                               name="mail_host"
                               id="mail_host"
                               class="form-control"
                               value="{{ old('mail_host', $settings->mail_host ?? '') }}"
                               placeholder="smtp.example.com">
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="form-group">
                        <label for="mail_port">Mail Port</label>
                        <input type="number"
                               name="mail_port"
                               id="mail_port"
                               class="form-control"
                               value="{{ old('mail_port', $settings->mail_port ?? 587) }}"
                               placeholder="587">
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="form-group">
                        <label for="mail_username">Mail Username</label>
                        <input type="text"
                               name="mail_username"
                               id="mail_username"
                               class="form-control"
                               value="{{ old('mail_username', $settings->mail_username ?? '') }}"
                               placeholder="username">
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="form-group">
                        <label for="mail_password">Mail Password</label>
                        <input type="password"
                               name="mail_password"
                               id="mail_password"
                               class="form-control"
                               placeholder="Leave blank to keep current password">
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="form-group">
                        <label for="mail_encryption">Mail Encryption</label>
                        <select name="mail_encryption"
                                id="mail_encryption"
                                class="form-control">
                            <option value="tls"
                                {{ old('mail_encryption', $settings->mail_encryption ?? 'tls') === 'tls' ? 'selected' : '' }}>
                                TLS
                            </option>
                            <option value="ssl"
                                {{ old('mail_encryption', $settings->mail_encryption ?? '') === 'ssl' ? 'selected' : '' }}>
                                SSL
                            </option>
                            <option value=""
                                {{ old('mail_encryption', $settings->mail_encryption ?? '') === '' ? 'selected' : '' }}>
                                None
                            </option>
                        </select>
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="form-group">
                        <label for="mail_from_name">From Name</label>

                        <input type="text"
                               name="mail_from_name"
                               id="mail_from_name"
                               class="form-control"
                               value="{{ old('mail_from_name', $settings->mail_from_name ?? '') }}"
                               placeholder="Your Website">
                    </div>
                </div>

                <div class="col-md-12">
                    <div class="form-group">
                        <label for="mail_from_address">From Email Address</label>

                        <input type="email"
                               name="mail_from_address"
                               id="mail_from_address"
                               class="form-control"
                               value="{{ old('mail_from_address', $settings->mail_from_address ?? '') }}"
                               placeholder="noreply@example.com">
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>