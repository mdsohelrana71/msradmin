<div class="table-responsive">
    <table class="table table-hover align-middle">
        <thead>
            <tr>
                <th width="60">#</th>
                <th>Promo</th>
                <th>Description</th>
                <th>Buttons</th>
                <th>Status</th>
                <th>Schedule</th>
                <th width="170">Action</th>
            </tr>
        </thead>

        <tbody>
            @forelse ($promos as $promo)
                <tr>
                    <td>{{ $promos->firstItem() + $loop->index }}</td>

                    <td>
                        <div class="fw-semibold">{{ $promo->title }}</div>

                        <small class="text-muted">
                            Order: {{ $promo->sort_order }}
                        </small>
                    </td>

                    <td>
                        @if ($promo->description)
                            <span class="text-muted">
                                {{ Str::limit($promo->description, 60) }}
                            </span>
                        @else
                            <span class="text-muted">—</span>
                        @endif
                    </td>

                    <td>
                        <span class="badge bg-info">
                            {{ $promo->buttons->count() }}
                            {{ Str::plural('Button', $promo->buttons->count()) }}
                        </span>
                    </td>

                    <td>
                        @if ($promo->status)
                            <span class="badge bg-success">Active</span>
                        @else
                            <span class="badge bg-warning">Inactive</span>
                        @endif
                    </td>

                    <td>
                        @if ($promo->start_date || $promo->end_date)
                            <div class="small">
                                @if ($promo->start_date)
                                    <div>
                                        <span class="text-muted">Start:</span>
                                        {{ $promo->start_date->format('d M Y, h:i A') }}
                                    </div>
                                @endif

                                @if ($promo->end_date)
                                    <div>
                                        <span class="text-muted">End:</span>
                                        {{ $promo->end_date->format('d M Y, h:i A') }}
                                    </div>
                                @endif
                            </div>
                        @else
                            <span class="text-muted">No schedule</span>
                        @endif
                    </td>

                    <td>
                        <div class="d-flex gap-1">
                            @can('promos.view')
                                <a href="{{ route('admin.promos.show', $promo) }}" class="btn btn-info btn-sm"
                                    title="View" data-bs-toggle="tooltip">
                                    <i class="fa fa-eye"></i>
                                </a>
                            @endcan

                            @can('promos.edit')
                                <a href="{{ route('admin.promos.edit', $promo) }}" class="btn btn-primary btn-sm"
                                    title="Edit" data-bs-toggle="tooltip">
                                    <i class="fa fa-edit"></i>
                                </a>
                            @endcan

                            @can('promos.delete')
                                <form id="deletePromoForm{{ $promo->id }}"
                                    action="{{ route('admin.promos.destroy', $promo) }}" method="POST" class="d-inline">
                                    @csrf
                                    @method('DELETE')

                                    <button type="button" class="btn btn-danger btn-sm" title="Delete"
                                        data-bs-toggle="modal" data-bs-target="#deletePromoModal{{ $promo->id }}">
                                        <i class="fa fa-trash"></i>
                                    </button>
                                </form>

                                <x-confirm-modal id="deletePromoModal{{ $promo->id }}"
                                    formId="deletePromoForm{{ $promo->id }}" title="Delete Promo?"
                                    message="Are you sure you want to delete this promo?" confirmText="Yes, Delete"
                                    confirmClass="btn-danger" />
                            @endcan
                        </div>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="7">
                        <div class="text-center py-5">
                            <i class="fas fa-bullhorn fa-3x text-muted mb-3"></i>

                            <h5 class="text-muted">No promos found</h5>

                            @can('promos.create')
                                <a href="{{ route('admin.promos.create') }}" class="btn btn-primary btn-sm mt-2">
                                    <i class="fa fa-plus me-1"></i>
                                    Create Promo
                                </a>
                            @endcan
                        </div>
                    </td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>

<div class="mt-3" id="promos-pagination">
    {{ $promos->links('pagination::bootstrap-5') }}
</div>