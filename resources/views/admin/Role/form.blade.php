<div class="form-group">
    <label for="name">Role Name</label>
    <input type="text" name="name" id="name" class="form-control @error('name') is-invalid @enderror" value="{{ old('name', $role->name ?? '') }}" placeholder="Enter role name">
    @error('name')
        <div class="invalid-feedback">{{ $message }}</div>
    @enderror
</div>

<div class="form-group mt-4">
    <label for="permission_ids">Permissions</label>
    <select name="permission_ids[]" id="permission_ids" class="form-control @error('permission_ids') is-invalid @enderror" multiple>
        @foreach($permissions as $permission)
            <option value="{{ $permission->id }}" {{ in_array($permission->id, old('permission_ids', $role->permissions->pluck('id')->toArray() ?? [])) ? 'selected' : '' }}>
                {{ $permission->name }}
            </option>
        @endforeach
    </select>
    @error('permission_ids')
        <div class="invalid-feedback">{{ $message }}</div>
    @enderror
</div>
