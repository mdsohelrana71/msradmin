<div class="table-responsive">
    <table class="display table table-striped table-hover">
        <thead>
            <tr>
                <th>Image</th>
                <th>Name</th>
                <th>Email</th>
                <th>Phone</th>
                <th>Role</th>
                <th>Status</th>
                <th>Created</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @forelse($users as $user)
                <tr>
                    <td>
                        @if ($user->avatar)
                            <img
                                src="{{ asset('storage/' . $user->avatar) }}"
                                alt="{{ $user->name }}"
                                class="rounded-circle"
                                width="40"
                                height="40"
                            >
                        @else
                            <div
                                class="rounded-circle bg-primary text-white d-flex align-items-center justify-content-center fw-bold"
                                style="width: 40px; height: 40px;"
                            >
                                {{ collect(explode(' ', trim($user->name)))
                                    ->filter()
                                    ->take(2)
                                    ->map(fn($word) => strtoupper(substr($word, 0, 1)))
                                    ->implode('') }}
                            </div>
                        @endif
                    </td>
                    <td>{{ ucfirst($user->name) }}</td>
                    <td>{{ $user->email }}</td>
                    <td>{{ $user->phone }}</td>
                    <td>{{ ucfirst(optional($user->assignedRole)->name ?? 'N/A') }}</td>
                    <td>{{ ucfirst($user->is_active ? 'Active' : 'Inactive') }}</td>
                    <td>{{ $user->created_at->format('Y-m-d') }}</td>
                    <td>
                        @can('view', $user)
                        <a href="{{ route('admin.users.show', $user) }}" class="btn btn-info btn-sm" title="View">
                            <i class="fa fa-eye"></i>
                        </a>
                        @endcan
                        @can('update', $user)
                        <a href="{{ route('admin.users.edit', $user) }}" class="btn btn-warning btn-sm" title="Edit">
                            <i class="fa fa-edit"></i>
                        </a>
                        @endcan
                        @can('delete', $user)
                        <form action="{{ route('admin.users.destroy', $user) }}" method="POST" class="d-inline-block" onsubmit="return confirm('Delete this user?');">
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
                    <td colspan="7" class="text-center">No users found.</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>

<div class="mt-3" id="users-pagination">
    {{ $users->links('pagination::bootstrap-5') }}
</div>
