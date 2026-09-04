@extends('layouts.admin')

@section('title', 'Order Details')

@section('content')

    <div class="container">
        <div class="page-inner">
            <x-admin.breadcrumb :items="[
                [
                    'label' => 'Orders',
                    'url' => route('admin.orders.index'),
                ],
                [
                    'label' => 'Order Details',
                ],
            ]" />

            <x-admin.alert />

            <div class="row">
                <div class="col-md-8">
                    <div class="card mb-4">
                        <div class="card-header">
                            <div class="d-flex align-items-center">
                                <div>
                                    <h4 class="card-title mb-1">
                                        Order #{{ $order->order_number }}
                                    </h4>
                                    <p class="text-muted mb-0">
                                        {{ $order->created_at?->format('M d, Y h:i A') }}
                                    </p>
                                </div>

                                <a href="{{ route('admin.orders.index') }}" class="btn btn-secondary btn-round ms-auto">
                                    Back
                                </a>
                            </div>
                        </div>

                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-hover align-middle">
                                    <thead>
                                        <tr>
                                            <th>Product</th>
                                            <th width="100">Price</th>
                                            <th width="80">Qty</th>
                                            <th width="120">Discount</th>
                                            <th width="120">Total</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse ($order->items as $item)
                                            <tr>
                                                <td>
                                                    <div class="d-flex align-items-center">
                                                        @if ($item->product?->thumbnail)
                                                            <img src="{{ asset('storage/' . $item->product->thumbnail) }}"
                                                                alt="{{ $item->product_name }}" class="rounded me-3"
                                                                style="width:60px;height:60px;object-fit:cover;">
                                                        @else
                                                            <div class="rounded bg-light d-flex align-items-center justify-content-center me-3"
                                                                style="width:60px;height:60px;">
                                                                <i class="fas fa-image text-muted"></i>
                                                            </div>
                                                        @endif

                                                        <div>
                                                            <div class="fw-semibold">
                                                                {{ $item->product_name }}
                                                            </div>

                                                            @if ($item->product_sku)
                                                                <small class="text-muted d-block">
                                                                    SKU: {{ $item->product_sku }}
                                                                </small>
                                                            @endif

                                                            @if ($item->variant_name)
                                                                <small class="text-muted d-block">
                                                                    {{ $item->variant_name }}
                                                                </small>
                                                            @endif

                                                            @if ($item->variant_sku)
                                                                <small class="text-muted d-block">
                                                                    Variant SKU: {{ $item->variant_sku }}
                                                                </small>
                                                            @endif
                                                        </div>
                                                    </div>
                                                </td>

                                                <td>
                                                    {{ $order->currency }}
                                                    {{ number_format($item->unit_price, 2) }}
                                                </td>

                                                <td>
                                                    {{ $item->quantity }}
                                                </td>

                                                <td>
                                                    {{ $order->currency }}
                                                    {{ number_format($item->discount, 2) }}
                                                </td>

                                                <td>
                                                    <span class="fw-semibold">
                                                        {{ $order->currency }}
                                                        {{ number_format($item->total, 2) }}
                                                    </span>
                                                </td>
                                            </tr>
                                        @empty
                                            <tr>
                                                <td colspan="5">
                                                    <div class="text-center py-4 text-muted">
                                                        No order items found.
                                                    </div>
                                                </td>
                                            </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="card mb-4">
                                <div class="card-header">
                                    <h4 class="card-title mb-0">
                                        Billing Address
                                    </h4>
                                </div>

                                <div class="card-body">
                                    @if ($order->billingAddress)
                                        <div class="fw-semibold mb-1">
                                            {{ $order->billingAddress->name }}
                                        </div>

                                        @if ($order->billingAddress->phone)
                                            <div class="text-muted mb-1">
                                                <i class="fas fa-phone me-1"></i>
                                                {{ $order->billingAddress->phone }}
                                            </div>
                                        @endif

                                        @if ($order->billingAddress->email)
                                            <div class="text-muted mb-2">
                                                <i class="fas fa-envelope me-1"></i>
                                                {{ $order->billingAddress->email }}
                                            </div>
                                        @endif

                                        <div>
                                            {{ $order->billingAddress->address_line_1 }}
                                        </div>

                                        @if ($order->billingAddress->address_line_2)
                                            <div>
                                                {{ $order->billingAddress->address_line_2 }}
                                            </div>
                                        @endif

                                        <div>
                                            {{ $order->billingAddress->city }}

                                            @if ($order->billingAddress->state)
                                                , {{ $order->billingAddress->state }}
                                            @endif

                                            @if ($order->billingAddress->postal_code)
                                                - {{ $order->billingAddress->postal_code }}
                                            @endif
                                        </div>

                                        <div>
                                            {{ $order->billingAddress->country }}
                                        </div>
                                    @else
                                        <span class="text-muted">
                                            No billing address available.
                                        </span>
                                    @endif
                                </div>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="card mb-4">
                                <div class="card-header">
                                    <h4 class="card-title mb-0">
                                        Shipping Address
                                    </h4>
                                </div>

                                <div class="card-body">
                                    @if ($order->shippingAddress)
                                        <div class="fw-semibold mb-1">
                                            {{ $order->shippingAddress->name }}
                                        </div>

                                        @if ($order->shippingAddress->phone)
                                            <div class="text-muted mb-1">
                                                <i class="fas fa-phone me-1"></i>
                                                {{ $order->shippingAddress->phone }}
                                            </div>
                                        @endif

                                        @if ($order->shippingAddress->email)
                                            <div class="text-muted mb-2">
                                                <i class="fas fa-envelope me-1"></i>
                                                {{ $order->shippingAddress->email }}
                                            </div>
                                        @endif

                                        <div>
                                            {{ $order->shippingAddress->address_line_1 }}
                                        </div>

                                        @if ($order->shippingAddress->address_line_2)
                                            <div>
                                                {{ $order->shippingAddress->address_line_2 }}
                                            </div>
                                        @endif

                                        <div>
                                            {{ $order->shippingAddress->city }}

                                            @if ($order->shippingAddress->state)
                                                , {{ $order->shippingAddress->state }}
                                            @endif

                                            @if ($order->shippingAddress->postal_code)
                                                - {{ $order->shippingAddress->postal_code }}
                                            @endif
                                        </div>

                                        <div>
                                            {{ $order->shippingAddress->country }}
                                        </div>
                                    @else
                                        <span class="text-muted">
                                            No shipping address available.
                                        </span>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="card mb-4">
                        <div class="card-header">
                            <h4 class="card-title mb-0">
                                Customer
                            </h4>
                        </div>

                        <div class="card-body">
                            @if ($order->user)
                                <div class="row">
                                    <div class="col-md-6">
                                        <label class="form-label text-muted small">
                                            Name
                                        </label>
                                        <div class="fw-semibold">
                                            {{ $order->user->name }}
                                        </div>
                                    </div>

                                    @if ($order->user->email)
                                        <div class="col-md-6">
                                            <label class="form-label text-muted small">
                                                Email
                                            </label>
                                            <div class="fw-medium">
                                                {{ $order->user->email }}
                                            </div>
                                        </div>
                                    @endif
                                </div>
                            @else
                                <span class="text-muted">
                                    Guest Customer
                                </span>
                            @endif
                        </div>
                    </div>

                    @if ($order->customer_note)
                        <div class="card mb-4">
                            <div class="card-header">
                                <h4 class="card-title mb-0">
                                    Customer Note
                                </h4>
                            </div>

                            <div class="card-body">
                                <p class="mb-0">
                                    {{ $order->customer_note }}
                                </p>
                            </div>
                        </div>
                    @endif
                </div>

                <div class="col-md-4">
                    <div class="card mb-4">
                        <div class="card-header">
                            <h4 class="card-title mb-0">
                                Order Summary
                            </h4>
                        </div>

                        <div class="card-body">
                            <div class="d-flex justify-content-between mb-2">
                                <span class="text-muted">
                                    Subtotal
                                </span>
                                <span>
                                    {{ $order->currency }}
                                    {{ number_format($order->subtotal, 2) }}
                                </span>
                            </div>

                            <div class="d-flex justify-content-between mb-2">
                                <span class="text-muted">
                                    Discount
                                </span>
                                <span>
                                    - {{ $order->currency }}
                                    {{ number_format($order->discount, 2) }}
                                </span>
                            </div>

                            <div class="d-flex justify-content-between mb-2">
                                <span class="text-muted">
                                    Shipping
                                </span>
                                <span>
                                    {{ $order->currency }}
                                    {{ number_format($order->shipping_charge, 2) }}
                                </span>
                            </div>

                            <div class="d-flex justify-content-between mb-3">
                                <span class="text-muted">
                                    Tax
                                </span>
                                <span>
                                    {{ $order->currency }}
                                    {{ number_format($order->tax, 2) }}
                                </span>
                            </div>

                            <hr>

                            <div class="d-flex justify-content-between">
                                <span class="fw-semibold">
                                    Grand Total
                                </span>
                                <span class="fw-bold fs-5">
                                    {{ $order->currency }}
                                    {{ number_format($order->total, 2) }}
                                </span>
                            </div>
                        </div>
                    </div>

                    <div class="card mb-4">
                        <div class="card-header">
                            <h4 class="card-title mb-0">
                                Order Status
                            </h4>
                        </div>

                        <div class="card-body">
                            @can('orders.edit')
                                <form action="{{ route('admin.orders.update-status', $order) }}" method="POST">
                                    @csrf
                                    @method('PATCH')

                                    <div class="mb-3">
                                        <select name="status" class="form-select">
                                            <option value="pending" {{ $order->status === 'pending' ? 'selected' : '' }}>
                                                Pending
                                            </option>
                                            <option value="confirmed" {{ $order->status === 'confirmed' ? 'selected' : '' }}>
                                                Confirmed
                                            </option>
                                            <option value="processing"
                                                {{ $order->status === 'processing' ? 'selected' : '' }}>
                                                Processing
                                            </option>
                                            <option value="shipped" {{ $order->status === 'shipped' ? 'selected' : '' }}>
                                                Shipped
                                            </option>
                                            <option value="delivered" {{ $order->status === 'delivered' ? 'selected' : '' }}>
                                                Delivered
                                            </option>
                                            <option value="cancelled" {{ $order->status === 'cancelled' ? 'selected' : '' }}>
                                                Cancelled
                                            </option>
                                            <option value="returned" {{ $order->status === 'returned' ? 'selected' : '' }}>
                                                Returned
                                            </option>
                                        </select>
                                    </div>

                                    <button type="submit" class="btn btn-primary">
                                        <i class="fas fa-save me-1"></i>
                                        Update Status
                                    </button>
                                </form>
                            @else
                                <span class="badge bg-secondary">
                                    {{ ucfirst($order->status) }}
                                </span>
                            @endcan
                        </div>
                    </div>

                    <div class="card mb-4">
                        <div class="card-header">
                            <h4 class="card-title mb-0">
                                Payment
                            </h4>
                        </div>

                        <div class="card-body">
                            <label class="form-label text-muted small">
                                Payment Status
                            </label>

                            <div>
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
                            </div>
                        </div>
                    </div>

                    <div class="card">
                        <div class="card-header">
                            <h4 class="card-title mb-1">
                                Status History
                            </h4>
                            <p class="text-muted mb-0">
                                Order status change history
                            </p>
                        </div>

                        <div class="card-body">
                            @forelse ($order->statusHistories as $history)
                                <div class="d-flex gap-3 mb-4">
                                    <div>
                                        <span
                                            class="d-flex align-items-center justify-content-center rounded-circle bg-primary text-white"
                                            style="width:36px;height:36px;">
                                            <i class="fas fa-check"></i>
                                        </span>
                                    </div>

                                    <div class="grow">
                                        <div class="d-flex align-items-center justify-content-between gap-2">
                                            <div class="fw-semibold">
                                                {{ ucfirst($history->status) }}
                                            </div>

                                            <small class="text-muted text-nowrap">
                                                {{ $history->created_at?->format('M d, Y h:i A') }}
                                            </small>
                                        </div>

                                        @if ($history->creator)
                                            <small class="text-muted">
                                                By {{ $history->creator->name }}
                                            </small>
                                        @endif

                                        @if ($history->note)
                                            <div class="mt-2 text-muted">
                                                {{ $history->note }}
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            @empty
                                <div class="text-center py-4">
                                    <i class="fas fa-history fa-2x text-muted mb-2"></i>
                                    <p class="text-muted mb-0">
                                        No status history available.
                                    </p>
                                </div>
                            @endforelse
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
