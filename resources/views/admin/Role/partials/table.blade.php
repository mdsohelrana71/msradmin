<div class="table-responsive">
    <table class="display table table-striped table-hover">
        <thead>
            <tr>
                <th>Name</th>
                <th>Created</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @forelse($roles as $role)
                <tr>
                    <td>{{ ucfirst($role->name) }}</td>
                    <td>{{ $role->created_at->format('Y-m-d') }}</td>
                    <td>
                        @can('roles.view')
                        <a href="{{ route('admin.roles.show', $role) }}" class="btn btn-info btn-sm" title="View">
                            <i class="fa fa-eye"></i>
                        </a>
                        @endcan

                        @can('update', $role)
                        <a href="{{ route('admin.roles.edit', $role) }}" class="btn btn-warning btn-sm" title="Edit">
                            <i class="fa fa-edit"></i>
                        </a>
                        @endcan

                        @can('delete', $role)
                        <form action="{{ route('admin.roles.destroy', $role) }}" method="POST" class="d-inline-block" onsubmit="return confirm('Delete this role?');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger btn-sm" title="Delete">
                                <i class="fa fa-trash"></i>
                            </button>
                        </form>
                        @endcan
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="3" class="text-center">No roles found.</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>

<div class="mt-3" id="roles-pagination">
    {{ $roles->links('pagination::bootstrap-5') }}
</div>
