<div class="table-responsive">
    <table class="table table-hover align-middle">
        <thead>
            <tr>
                <th width="60">#</th>
                <th>Customer</th>
                <th>Phone</th>
                <th>Orders</th>
                <th>Wishlist</th>
                <th>Compare</th>
                <th>Reviews</th>
                <th>Status</th>
                <th width="110">Action</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($customers as $customer)
                <tr>
                    <td>
                        {{ $customers->firstItem() + $loop->index }}
                    </td>

                    <td>
                        <div class="d-flex align-items-center">
                            @if ($customer->avatar)
                                <img
                                    src="{{ asset('storage/' . $customer->avatar) }}"
                                    alt="{{ $customer->name }}"
                                    class="rounded-circle me-2"
                                    width="40"
                                    height="40"
                                >
                            @else
                                <div
                                    class="rounded-circle bg-light d-flex align-items-center justify-content-center me-2"
                                    style="width: 40px; height: 40px;"
                                >
                                    <i class="fa fa-user text-muted"></i>
                                </div>
                            @endif

                            <div>
                                <div class="fw-semibold">
                                    {{ $customer->name }}
                                </div>

                                @if ($customer->email)
                                    <small class="text-muted">
                                        {{ $customer->email }}
                                    </small>
                                @endif
                            </div>
                        </div>
                    </td>

                    <td>
                        {{ $customer->phone ?? '—' }}
                    </td>

                    <td>
                        <span class="badge bg-light text-dark">
                            {{ $customer->orders_count }}
                        </span>
                    </td>

                    <td>
                        <span class="badge bg-light text-dark">
                            {{ $customer->wishlists_count }}
                        </span>
                    </td>

                    <td>
                        <span class="badge bg-light text-dark">
                            {{ $customer->compares_count }}
                        </span>
                    </td>

                    <td>
                        <span class="badge bg-light text-dark">
                            {{ $customer->reviews_count }}
                        </span>
                    </td>

                    <td>
                        @if ($customer->is_active)
                            <span class="badge bg-success">
                                Active
                            </span>
                        @else
                            <span class="badge bg-danger">
                                Inactive
                            </span>
                        @endif
                    </td>

                    <td>
                        @can('customers.view')
                            <a
                                href="{{ route('admin.customers.show', $customer) }}"
                                class="btn btn-info btn-sm"
                                title="View"
                                data-bs-toggle="tooltip"
                            >
                                <i class="fa fa-eye"></i>
                            </a>
                        @endcan
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="9">
                        <div class="text-center py-5">
                            <i class="fas fa-users fa-3x text-muted mb-3"></i>
                            <h5 class="text-muted">
                                No customers found
                            </h5>
                        </div>
                    </td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>

<div class="mt-3" id="customers-pagination">
    {{ $customers->links('pagination::bootstrap-5') }}
</div>