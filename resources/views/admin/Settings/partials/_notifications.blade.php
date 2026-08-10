<div class="settings-tab-pane" id="notifications">
    <div class="card">
        <div class="card-header">
            <h4 class="card-title mb-1">
                Notification Settings
            </h4>
            <p class="text-muted mb-0">
                Manage application notification preferences.
            </p>
        </div>

        <div class="card-body">
            <div class="form-check form-switch mb-4">
                <input type="hidden"
                       name="email_notifications"
                       value="0">
                <input class="form-check-input"
                       type="checkbox"
                       name="email_notifications"
                       value="1"
                       id="email_notifications"
                       {{ old('email_notifications', $settings->email_notifications ?? false) ? 'checked' : '' }}>

                <label class="form-check-label"
                       for="email_notifications">
                    <strong>Email Notifications</strong>
                    <div class="text-muted small">
                        Receive important notifications through email.
                    </div>
                </label>
            </div>

            <div class="form-check form-switch mb-4">
                <input type="hidden"
                       name="login_notifications"
                       value="0">
                <input class="form-check-input"
                       type="checkbox"
                       name="login_notifications"
                       value="1"
                       id="login_notifications"
                       {{ old('login_notifications', $settings->login_notifications ?? false) ? 'checked' : '' }}>

                <label class="form-check-label"
                       for="login_notifications">
                    <strong>Login Notifications</strong>
                    <div class="text-muted small">
                        Get notified when an account logs in.
                    </div>
                </label>
            </div>

            <div class="form-check form-switch">
                <input type="hidden"
                       name="system_notifications"
                       value="0">

                <input class="form-check-input"
                       type="checkbox"
                       name="system_notifications"
                       value="1"
                       id="system_notifications"
                       {{ old('system_notifications', $settings->system_notifications ?? false) ? 'checked' : '' }}>

                <label class="form-check-label" for="system_notifications">
                    <strong>System Notifications</strong>
                    <div class="text-muted small">
                        Receive important system and application notifications.
                    </div>
                </label>
            </div>
        </div>
    </div>
</div>