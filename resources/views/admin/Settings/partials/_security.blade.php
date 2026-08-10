<div class="settings-tab-pane" id="security">
    <div class="card">
        <div class="card-header">
            <h4 class="card-title mb-1">
                Security Settings
            </h4>
            <p class="text-muted mb-0">
                Manage application security options.
            </p>
        </div>

        <div class="card-body">
            <div class="form-check form-switch mb-4">
                <input type="hidden"
                       name="email_verification"
                       value="0">
                <input class="form-check-input"
                       type="checkbox"
                       name="email_verification"
                       value="1"
                       id="email_verification"
                       {{ old('email_verification', $settings->email_verification ?? false) ? 'checked' : '' }}>

                <label class="form-check-label"
                       for="email_verification">
                    <strong>Require Email Verification</strong>
                    <div class="text-muted small">
                        Require users to verify their email address.
                    </div>
                </label>
            </div>

            <div class="form-check form-switch mb-4">
                <input type="hidden"
                       name="two_factor_auth"
                       value="0">
                <input class="form-check-input"
                       type="checkbox"
                       name="two_factor_auth"
                       value="1"
                       id="two_factor_auth"
                       {{ old('two_factor_auth', $settings->two_factor_auth ?? false) ? 'checked' : '' }}>

                <label class="form-check-label"
                       for="two_factor_auth">
                    <strong>Two-Factor Authentication</strong>
                    <div class="text-muted small">
                        Add an additional security layer to user accounts.
                    </div>
                </label>
            </div>

            <div class="form-check form-switch">
                <input type="hidden"
                       name="login_activity"
                       value="0">
                <input class="form-check-input"
                       type="checkbox"
                       name="login_activity"
                       value="1"
                       id="login_activity"
                       {{ old('login_activity', $settings->login_activity ?? false) ? 'checked' : '' }}>

                <label class="form-check-label"
                       for="login_activity">
                    <strong>Login Activity Tracking</strong>
                    <div class="text-muted small">
                        Keep track of user login activity.
                    </div>
                </label>
            </div>
        </div>
    </div>
</div>