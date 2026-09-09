<div class="table-responsive">
    <table class="table table-hover align-middle">
        <thead>
            <tr>
                <th width="60">#</th>
                <th>Email</th>
                <th>Status</th>
                <th>Subscribed At</th>
                <th width="140">Action</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($subscribers as $subscriber)
                <tr>
                    <td>{{ $subscribers->firstItem() + $loop->index }}</td>
                    <td>
                        <div class="fw-semibold">{{ $subscriber->email }}</div>
                    </td>
                    <td>
                        @if ($subscriber->status)
                            <span class="badge bg-success">Active</span>
                        @else
                            <span class="badge bg-warning">Inactive</span>
                        @endif
                    </td>
                    <td>
                        {{ $subscriber->subscribed_at?->format('d M Y h:i A') ?? '—' }}
                    </td>
                    <td>
                        <div class="d-flex gap-1">
                            @can('newsletter-subscribers.view')
                                <a href="{{ route('admin.newsletter-subscribers.show', $subscriber) }}"
                                    class="btn btn-info btn-sm"
                                    title="View"
                                    data-bs-toggle="tooltip">
                                    <i class="fa fa-eye"></i>
                                </a>
                            @endcan
                            @can('newsletter-subscribers.edit')
                                <a href="{{ route('admin.newsletter-subscribers.edit', $subscriber) }}"
                                    class="btn btn-primary btn-sm"
                                    title="Edit"
                                    data-bs-toggle="tooltip">
                                    <i class="fa fa-edit"></i>
                                </a>
                            @endcan
                            @can('newsletter-subscribers.delete')
                                <form id="deleteNewsletterSubscriberForm{{ $subscriber->id }}"
                                    action="{{ route('admin.newsletter-subscribers.destroy', $subscriber) }}"
                                    method="POST"
                                    class="d-inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="button"
                                        class="btn btn-danger btn-sm"
                                        title="Delete"
                                        data-bs-toggle="modal"
                                        data-bs-target="#deleteNewsletterSubscriberModal{{ $subscriber->id }}">
                                        <i class="fa fa-trash"></i>
                                    </button>
                                </form>
                                <x-confirm-modal
                                    id="deleteNewsletterSubscriberModal{{ $subscriber->id }}"
                                    formId="deleteNewsletterSubscriberForm{{ $subscriber->id }}"
                                    title="Delete Subscriber?"
                                    message="Are you sure you want to delete this newsletter subscriber?"
                                    confirmText="Yes, Delete"
                                    confirmClass="btn-danger"
                                />
                            @endcan
                        </div>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="5">
                        <div class="text-center py-5">
                            <i class="fas fa-envelope fa-3x text-muted mb-3"></i>
                            <h5 class="text-muted">No newsletter subscribers found</h5>
                        </div>
                    </td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>
<div class="mt-3" id="newsletter-subscribers-pagination">
    {{ $subscribers->links('pagination::bootstrap-5') }}
</div>