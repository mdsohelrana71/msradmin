<div class="table-responsive">
    <table class="table table-hover align-middle">
        <thead>
            <tr>
                <th width="60">#</th>
                <th width="90">Logo</th>
                <th>Brand</th>
                <th>Status</th>
                <th>Description</th>
                <th width="170">Action</th>
            </tr>
        </thead>

        <tbody>
            @forelse ($brands as $brand)
                <tr>
                    <td>{{ $brands->firstItem() + $loop->index }}</td>

                    <td>
                        @if ($brand->logo)
                            <img src="{{ asset('storage/' . $brand->logo) }}" alt="{{ $brand->name }}" class="rounded"
                                style="width:65px;height:50px;object-fit:contain;">
                        @else
                            <div class="rounded bg-light d-flex align-items-center justify-content-center"
                                style="width:65px;height:50px;">
                                <i class="fas fa-tags text-muted"></i>
                            </div>
                        @endif
                    </td>

                    <td>
                        <div class="fw-semibold">{{ $brand->name }}</div>

                        @if ($brand->slug)
                            <small class="text-muted">{{ $brand->slug }}</small>
                        @endif
                    </td>

                    <td>
                        @if ($brand->status)
                            <span class="badge bg-success">Active</span>
                        @else
                            <span class="badge bg-warning">Inactive</span>
                        @endif
                    </td>

                    <td>
                        @if ($brand->description)
                            <span class="text-muted">
                                {{ Str::limit($brand->description, 50) }}
                            </span>
                        @else
                            <span class="text-muted">—</span>
                        @endif
                    </td>

                    <td>
                        <div class="d-flex gap-1">
                            @can('brands.view')
                                <a href="{{ route('admin.brands.show', $brand) }}" class="btn btn-info btn-sm"
                                    title="View" data-bs-toggle="tooltip">
                                    <i class="fa fa-eye"></i>
                                </a>
                            @endcan

                            @can('brands.edit')
                                <a href="{{ route('admin.brands.edit', $brand) }}" class="btn btn-primary btn-sm"
                                    title="Edit" data-bs-toggle="tooltip">
                                    <i class="fa fa-edit"></i>
                                </a>
                            @endcan

                            @can('brands.delete')
                                <form id="deleteBrandForm{{ $brand->id }}"
                                    action="{{ route('admin.brands.destroy', $brand) }}" method="POST" class="d-inline">
                                    @csrf
                                    @method('DELETE')

                                    <button type="button" class="btn btn-danger btn-sm" title="Delete"
                                        data-bs-toggle="modal" data-bs-target="#deleteBrandModal{{ $brand->id }}">
                                        <i class="fa fa-trash"></i>
                                    </button>
                                </form>

                                <x-confirm-modal id="deleteBrandModal{{ $brand->id }}"
                                    formId="deleteBrandForm{{ $brand->id }}" title="Delete Brand?"
                                    message="Are you sure you want to delete this brand?" confirmText="Yes, Delete"
                                    confirmClass="btn-danger" />
                            @endcan
                        </div>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="6">
                        <div class="text-center py-5">
                            <i class="fas fa-tags fa-3x text-muted mb-3"></i>

                            <h5 class="text-muted">No brands found</h5>

                            @can('brands.create')
                                <a href="{{ route('admin.brands.create') }}" class="btn btn-primary btn-sm mt-2">
                                    <i class="fa fa-plus me-1"></i>
                                    Create Brand
                                </a>
                            @endcan
                        </div>
                    </td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>

<div class="mt-3" id="brands-pagination">
    {{ $brands->links('pagination::bootstrap-5') }}
</div>
