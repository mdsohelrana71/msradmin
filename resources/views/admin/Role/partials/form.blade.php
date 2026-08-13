<div class="row">
    <div class="col-md-6">
        <div class="form-group mb-3">
            <label for="name">Role Name</label>
            <input
                type="text"
                name="name"
                id="name"
                class="form-control"
                placeholder="Enter role name"
                value="{{ old('name', $role->name ?? '') }}"
                required
            >
        </div>
    </div>
</div>

<div class="row">
    <div class="col-md-12">
        <div class="form-group mb-3">
            <label>Permissions</label>

            <div class="table-responsive">
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th style="width: 25%;">Label</th>
                            <th>Permissions</th>
                        </tr>
                    </thead>

                    <tbody>
                        @php
                            $selectedPermissions = old(
                                'permission_ids',
                                isset($role)
                                    ? $role->permissions->pluck('id')->toArray()
                                    : []
                            );
                        @endphp

                        @foreach ($permissions->groupBy('group') as $group => $perms)
                            <tr>
                                <td class="align-middle">
                                    {{ $group ?? 'General' }}
                                </td>

                                <td>
                                    @foreach ($perms as $permission)
                                        <div class="form-check form-check-inline me-2">
                                            <input
                                                class="form-check-input"
                                                type="checkbox"
                                                name="permission_ids[]"
                                                value="{{ $permission->id }}"
                                                id="perm_{{ $permission->id }}"
                                                @checked(
                                                    in_array(
                                                        $permission->id,
                                                        $selectedPermissions
                                                    )
                                                )
                                            >

                                            <label
                                                class="form-check-label"
                                                for="perm_{{ $permission->id }}"
                                            >
                                                {{ $permission->name }}
                                            </label>
                                        </div>
                                    @endforeach
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>