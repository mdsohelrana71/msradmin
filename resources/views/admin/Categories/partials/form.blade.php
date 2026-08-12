<div class="row g-3">
    <div class="col-md-6">
        <div class="form-group">
            <label for="name">Full Name</label>
            <input type="text" name="name" id="name" class="form-control" value="{{ old('name', $user->name) }}" required>
        </div>
    </div>

    <div class="col-md-6">
        <div class="form-group">
            <label for="email">Email Address</label>
            <input type="email" name="email" id="email" class="form-control" value="{{ old('email', $user->email) }}" required>
        </div>
    </div>

    <div class="col-md-6">
        <div class="form-group">
            <label for="phone">Phone Number</label>
            <input type="text" name="phone" id="phone" class="form-control" value="{{ old('phone', $user->phone) }}">
        </div>
    </div>

    <div class="col-md-6">
        <div class="form-group">
            <label for="address">Address</label>
            <input type="text" name="address" id="address" class="form-control" value="{{ old('address', $user->address) }}">
        </div>
    </div>

    <div class="col-md-6">
        <div class="form-group">
            <label for="password">Password</label>
            <input type="password" name="password" id="password" class="form-control" placeholder="Leave blank to keep current password">
        </div>
    </div>

    <div class="col-md-6">
        <div class="form-group">
            <label for="avatar">Avatar</label>
            <input type="file" name="avatar" id="avatar" class="form-control">
            @if(!empty($user->avatar))
                <div class="mt-2">
                    <img src="{{ asset('storage/' . $user->avatar) }}" alt="Avatar" style="max-height: 80px;" class="rounded-circle" />
                </div>
            @endif
        </div>
    </div>
</div>
