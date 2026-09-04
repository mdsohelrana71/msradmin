<div class="table-responsive">
    <table class="table table-hover align-middle">
        <thead>
            <tr>
                <th width="60">#</th>
                <th>Order</th>
                <th>Customer</th>
                <th>Items</th>
                <th>Total</th>
                <th>Payment</th>
                <th>Status</th>
                <th width="110">Action</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($orders as $order)
                <tr>
                    <td>
                        {{ $orders->firstItem() + $loop->index }}
                    </td>

                    <td>
                        <div class="fw-semibold">
                            {{ $order->order_number }}
                        </div>

                        <small class="text-muted">
                            {{ $order->created_at?->format('M d, Y h:i A') }}
                        </small>
                    </td>

                    <td>
                        @if ($order->user)
                            <div class="fw-medium">
                                {{ $order->user->name }}
                            </div>

                            @if ($order->user->email)
                                <small class="text-muted">
                                    {{ $order->user->email }}
                                </small>
                            @endif
                        @else
                            <span class="text-muted">
                                Guest Customer
                            </span>
                        @endif
                    </td>

                    <td>
                        <span class="badge bg-light text-dark">
                            {{ $order->items->sum('quantity') }}
                            {{ $order->items->sum('quantity') == 1 ? 'Item' : 'Items' }}
                        </span>
                    </td>

                    <td>
                        <div class="fw-semibold">
                            {{ $order->currency }}
                            {{ number_format($order->total, 2) }}
                        </div>
                    </td>

                    <td>
                        @if ($order->payment_status === 'paid')
                            <span class="badge bg-success">
                                Paid
                            </span>
                        @elseif ($order->payment_status === 'failed')
                            <span class="badge bg-danger">
                                Failed
                            </span>
                        @elseif ($order->payment_status === 'refunded')
                            <span class="badge bg-info">
                                Refunded
                            </span>
                        @elseif ($order->payment_status === 'partially_refunded')
                            <span class="badge bg-warning text-dark">
                                Partially Refunded
                            </span>
                        @else
                            <span class="badge bg-secondary">
                                Pending
                            </span>
                        @endif
                    </td>

                    <td>
                        @if ($order->status === 'pending')
                            <span class="badge bg-warning text-dark">
                                Pending
                            </span>
                        @elseif ($order->status === 'confirmed')
                            <span class="badge bg-primary">
                                Confirmed
                            </span>
                        @elseif ($order->status === 'processing')
                            <span class="badge bg-info">
                                Processing
                            </span>
                        @elseif ($order->status === 'shipped')
                            <span class="badge bg-primary">
                                Shipped
                            </span>
                        @elseif ($order->status === 'delivered')
                            <span class="badge bg-success">
                                Delivered
                            </span>
                        @elseif ($order->status === 'cancelled')
                            <span class="badge bg-danger">
                                Cancelled
                            </span>
                        @elseif ($order->status === 'returned')
                            <span class="badge bg-dark">
                                Returned
                            </span>
                        @else
                            <span class="badge bg-secondary">
                                {{ ucfirst($order->status) }}
                            </span>
                        @endif
                    </td>

                    <td>
                        @can('orders.view')
                            <a
                                href="{{ route('admin.orders.show', $order) }}"
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
                    <td colspan="8">
                        <div class="text-center py-5">
                            <i class="fas fa-shopping-cart fa-3x text-muted mb-3"></i>
                            <h5 class="text-muted">
                                No orders found
                            </h5>
                        </div>
                    </td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>

<div class="mt-3" id="orders-pagination">
    {{ $orders->links('pagination::bootstrap-5') }}
</div>