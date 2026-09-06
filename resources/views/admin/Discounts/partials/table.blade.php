<div class="table-responsive">
    <table class="table table-hover align-middle">
        <thead>
            <tr>
                <th width="60">#</th>
                <th>Discount</th>
                <th>Type</th>
                <th>Value</th>
                <th>Products</th>
                <th>Categories</th>
                <th>Status</th>
                <th width="170">Action</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($discounts as $discount)
                <tr>
                    <td>{{ $discounts->firstItem() + $loop->index }}</td>
                    <td>
                        <div class="fw-semibold">
                            {{ $discount->name }}
                        </div>
                        <small class="text-muted">
                            Priority: {{ $discount->priority }}
                        </small>
                    </td>
                    <td>
                        <span class="badge bg-light text-dark">
                            {{ ucfirst($discount->type) }}
                        </span>
                    </td>
                    <td>
                        <div class="fw-semibold">
                            @if ($discount->type === 'percentage')
                                {{ number_format($discount->value, 2) }}%
                            @else
                                {{ number_format($discount->value, 2) }}
                            @endif
                        </div>

                        @if ($discount->maximum_discount !== null)
                            <small class="text-muted">
                                Max: {{ number_format($discount->maximum_discount, 2) }}
                            </small>
                        @endif
                    </td>
                    <td>
                        <span class="badge bg-info">
                            {{ $discount->products_count }}
                        </span>
                    </td>
                    <td>
                        <span class="badge bg-secondary">
                            {{ $discount->categories_count }}
                        </span>
                    </td>
                    <td>
                        @if ($discount->status)
                            <span class="badge bg-success">
                                Active
                            </span>
                        @else
                            <span class="badge bg-warning">
                                Inactive
                            </span>
                        @endif

                        @if ($discount->allow_coupon)
                            <span class="badge bg-info d-block mt-1">
                                Coupon Allowed
                            </span>
                        @endif
                    </td>
                    <td>
                        <div class="d-flex gap-1">
                            @can('discounts.view')
                                <a
                                    href="{{ route('admin.discounts.show', $discount) }}"
                                    class="btn btn-info btn-sm"
                                    title="View"
                                    data-bs-toggle="tooltip"
                                >
                                    <i class="fa fa-eye"></i>
                                </a>
                            @endcan

                            @can('discounts.edit')
                                <a
                                    href="{{ route('admin.discounts.edit', $discount) }}"
                                    class="btn btn-primary btn-sm"
                                    title="Edit"
                                    data-bs-toggle="tooltip"
                                >
                                    <i class="fa fa-edit"></i>
                                </a>

                                <form
                                    action="{{ route('admin.discounts.toggle-status', $discount) }}"
                                    method="POST"
                                    class="d-inline"
                                >
                                    @csrf
                                    @method('PATCH')

                                    <button
                                        type="submit"
                                        class="btn {{ $discount->status ? 'btn-warning' : 'btn-success' }} btn-sm"
                                        title="{{ $discount->status ? 'Deactivate' : 'Activate' }}"
                                        data-bs-toggle="tooltip"
                                    >
                                        <i class="fa {{ $discount->status ? 'fa-ban' : 'fa-check' }}"></i>
                                    </button>
                                </form>
                            @endcan

                            @can('discounts.delete')
                                <form
                                    id="deleteDiscountForm{{ $discount->id }}"
                                    action="{{ route('admin.discounts.destroy', $discount) }}"
                                    method="POST"
                                    class="d-inline"
                                >
                                    @csrf
                                    @method('DELETE')

                                    <button
                                        type="button"
                                        class="btn btn-danger btn-sm"
                                        title="Delete"
                                        data-bs-toggle="modal"
                                        data-bs-target="#deleteDiscountModal{{ $discount->id }}"
                                    >
                                        <i class="fa fa-trash"></i>
                                    </button>
                                </form>

                                <x-confirm-modal
                                    id="deleteDiscountModal{{ $discount->id }}"
                                    formId="deleteDiscountForm{{ $discount->id }}"
                                    title="Delete Discount?"
                                    message="Are you sure you want to delete this discount?"
                                    confirmText="Yes, Delete"
                                    confirmClass="btn-danger"
                                />
                            @endcan
                        </div>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="8">
                        <div class="text-center py-5">
                            <i class="fas fa-percent fa-3x text-muted mb-3"></i>

                            <h5 class="text-muted">
                                No discounts found
                            </h5>

                            @can('discounts.create')
                                <a
                                    href="{{ route('admin.discounts.create') }}"
                                    class="btn btn-primary btn-sm mt-2"
                                >
                                    <i class="fa fa-plus me-1"></i>
                                    Create Discount
                                </a>
                            @endcan
                        </div>
                    </td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>

<div class="mt-3" id="discounts-pagination">
    {{ $discounts->links('pagination::bootstrap-5') }}
</div>