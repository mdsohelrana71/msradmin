<div class="table-responsive">
    <table class="table table-hover align-middle">
        <thead>
            <tr>
                <th width="60">#</th>
                <th width="90">Image</th>
                <th>Title</th>
                <th>Category</th>
                <th>Status</th>
                <th>Published</th>
                <th width="170">Action</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($blogs as $blog)
            <tr>
                <td>{{ $blogs->firstItem() + $loop->index }}</td>

                <td>
                    @if ($blog->featured_image)
                    <img
                        src="{{ asset('storage/' . $blog->featured_image) }}"
                        alt="{{ $blog->title }}"
                        class="rounded"
                        style="width:65px;height:50px;object-fit:cover;">
                    @else
                    <div
                        class="rounded bg-light d-flex align-items-center justify-content-center"
                        style="width:65px;height:50px;">
                        <i class="fas fa-image text-muted"></i>
                    </div>
                    @endif
                </td>

                <td>
                    <div class="fw-semibold">{{ $blog->title }}</div>
                    @if ($blog->slug)
                    <small class="text-muted">{{ $blog->slug }}</small>
                    @endif
                </td>

                <td>
                    @if ($blog->category)
                    <span class="badge bg-info">
                        {{ $blog->category->name }}
                    </span>
                    @else
                    <span class="text-muted">—</span>
                    @endif
                </td>

                <td>
                    @if ($blog->status === 1)
                    <span class="badge bg-success">Published</span>
                    @else
                    <span class="badge bg-warning">Draft</span>
                    @endif
                </td>

                <td>
                    @if ($blog->published_at)
                    <div>{{ $blog->published_at->format('d M Y') }}</div>
                    <small class="text-muted">
                        {{ $blog->published_at->format('h:i A') }}
                    </small>
                    @else
                    <span class="text-muted">—</span>
                    @endif
                </td>

                <td>
                    <div class="d-flex gap-1">
                        @can('blogs.view')
                        <a
                            href="{{ route('admin.blogs.show', $blog) }}"
                            class="btn btn-info btn-sm"
                            title="View"
                            data-bs-toggle="tooltip">
                            <i class="fa fa-eye"></i>
                        </a>
                        @endcan

                        @can('blogs.edit')
                        <a
                            href="{{ route('admin.blogs.edit', $blog) }}"
                            class="btn btn-primary btn-sm"
                            title="Edit"
                            data-bs-toggle="tooltip">
                            <i class="fa fa-edit"></i>
                        </a>
                        @endcan

                        @can('blogs.delete')
                        <form
                            id="deleteBlogForm{{ $blog->id }}"
                            action="{{ route('admin.blogs.destroy', $blog) }}"
                            method="POST"
                            class="d-inline">
                            @csrf
                            @method('DELETE')

                            <button
                                type="button"
                                class="btn btn-danger btn-sm"
                                title="Delete"
                                data-bs-toggle="modal"
                                data-bs-target="#deleteBlogModal{{ $blog->id }}">
                                <i class="fa fa-trash"></i>
                            </button>
                        </form>

                        <x-confirm-modal
                            id="deleteBlogModal{{ $blog->id }}"
                            formId="deleteBlogForm{{ $blog->id }}"
                            title="Delete Blog?"
                            message="Are you sure you want to delete this blog?"
                            confirmText="Yes, Delete"
                            confirmClass="btn-danger" />
                        @endcan
                    </div>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="7">
                    <div class="text-center py-5">
                        <i class="fas fa-newspaper fa-3x text-muted mb-3"></i>
                        <h5 class="text-muted">No blogs found</h5>

                        @can('blogs.create')
                        <a
                            href="{{ route('admin.blogs.create') }}"
                            class="btn btn-primary btn-sm mt-2">
                            <i class="fa fa-plus me-1"></i>
                            Create Blog
                        </a>
                        @endcan
                    </div>
                </td>
            </tr>
            @endforelse
        </tbody>
    </table>
</div>

<div class="mt-3" id="blogs-pagination">
    {{ $blogs->links('pagination::bootstrap-5') }}
</div>