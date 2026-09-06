<div class="table-responsive">
    <table class="table table-hover align-middle">
        <thead>
            <tr>
                <th width="60">#</th>
                <th>Code</th>
                <th>Type</th>
                <th>Value</th>
                <th>Minimum Order</th>
                <th>Usage</th>
                <th>Status</th>
                <th width="170">Action</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($coupons as $coupon)
                <tr>
                    <td>{{ $coupons->firstItem() + $loop->index }}</td>
                    <td>
                        <div class="fw-semibold">
                            {{ $coupon->code }}
                        </div>
                        @if ($coupon->starts_at || $coupon->ends_at)
                            <small class="text-muted">
                                @if ($coupon->starts_at)
                                    From: {{ $coupon->starts_at->format('d M Y H:i') }}
                                @endif
                                @if ($coupon->ends_at)
                                    <br>Until: {{ $coupon->ends_at->format('d M Y H:i') }}
                                @endif
                            </small>
                        @endif
                    </td>
                    <td>
                        <span class="badge bg-light text-dark">
                            {{ ucfirst($coupon->type) }}
                        </span>
                    </td>
                    <td>
                        <div class="fw-semibold">
                            @if ($coupon->type === 'percentage')
                                {{ number_format($coupon->value, 2) }}%
                            @else
                                {{ number_format($coupon->value, 2) }}
                            @endif
                        </div>
                        @if ($coupon->maximum_discount !== null)
                            <small class="text-muted">
                                Max: {{ number_format($coupon->maximum_discount, 2) }}
                            </small>
                        @endif
                    </td>
                    <td>
                        {{ number_format($coupon->minimum_order_amount, 2) }}
                    </td>
                    <td>
                        <div>
                            Used:
                            <span class="fw-semibold">
                                0
                            </span>
                        </div>
                        @if ($coupon->usage_limit)
                            <small class="text-muted">
                                Limit: {{ $coupon->usage_limit }}
                            </small>
                        @else
                            <small class="text-muted">
                                Unlimited
                            </small>
                        @endif
                    </td>
                    <td>
                        @if ($coupon->status)
                            <span class="badge bg-success">
                                Active
                            </span>
                        @else
                            <span class="badge bg-warning">
                                Inactive
                            </span>
                        @endif
                    </td>
                    <td>
                        <div class="d-flex gap-1">
                            @can('coupons.view')
                                <a
                                    href="{{ route('admin.coupons.show', $coupon) }}"
                                    class="btn btn-info btn-sm"
                                    title="View"
                                    data-bs-toggle="tooltip"
                                >
                                    <i class="fa fa-eye"></i>
                                </a>
                            @endcan

                            @can('coupons.edit')
                                <a
                                    href="{{ route('admin.coupons.edit', $coupon) }}"
                                    class="btn btn-primary btn-sm"
                                    title="Edit"
                                    data-bs-toggle="tooltip"
                                >
                                    <i class="fa fa-edit"></i>
                                </a>

                                <form
                                    action="{{ route('admin.coupons.toggle-status', $coupon) }}"
                                    method="POST"
                                    class="d-inline"
                                >
                                    @csrf
                                    @method('PATCH')
                                    <button
                                        type="submit"
                                        class="btn {{ $coupon->status ? 'btn-warning' : 'btn-success' }} btn-sm"
                                        title="{{ $coupon->status ? 'Deactivate' : 'Activate' }}"
                                        data-bs-toggle="tooltip"
                                    >
                                        <i class="fa {{ $coupon->status ? 'fa-ban' : 'fa-check' }}"></i>
                                    </button>
                                </form>
                            @endcan

                            @can('coupons.delete')
                                <form
                                    id="deleteCouponForm{{ $coupon->id }}"
                                    action="{{ route('admin.coupons.destroy', $coupon) }}"
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
                                        data-bs-target="#deleteCouponModal{{ $coupon->id }}"
                                    >
                                        <i class="fa fa-trash"></i>
                                    </button>
                                </form>

                                <x-confirm-modal
                                    id="deleteCouponModal{{ $coupon->id }}"
                                    formId="deleteCouponForm{{ $coupon->id }}"
                                    title="Delete Coupon?"
                                    message="Are you sure you want to delete this coupon?"
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
                            <i class="fas fa-ticket-alt fa-3x text-muted mb-3"></i>
                            <h5 class="text-muted">
                                No coupons found
                            </h5>
                            @can('coupons.create')
                                <a
                                    href="{{ route('admin.coupons.create') }}"
                                    class="btn btn-primary btn-sm mt-2"
                                >
                                    <i class="fa fa-plus me-1"></i>
                                    Create Coupon
                                </a>
                            @endcan
                        </div>
                    </td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>

<div class="mt-3" id="coupons-pagination">
    {{ $coupons->links('pagination::bootstrap-5') }}
</div>