@extends('layouts.admin')

@section('title', 'Customer Details')

@section('content')
<div class="container">
    <div class="page-inner">
        <x-admin.breadcrumb
            :items="[
                [
                    'label' => 'Customers',
                    'url' => route('admin.customers.index'),
                ],
                [
                    'label' => 'Customer Details',
                ],
            ]"
        />

        <x-admin.alert />

        <div class="row">
            <div class="col-md-4">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title mb-0">
                            Customer
                        </h4>
                    </div>

                    <div class="card-body">
                        <div class="text-center mb-4">
                            @if ($customer->avatar)
                                <img
                                    src="{{ asset('storage/' . $customer->avatar) }}"
                                    alt="{{ $customer->name }}"
                                    class="rounded-circle"
                                    width="90"
                                    height="90"
                                >
                            @else
                                <div
                                    class="rounded-circle bg-light d-flex align-items-center justify-content-center mx-auto"
                                    style="width: 90px; height: 90px;"
                                >
                                    <i class="fa fa-user fa-2x text-muted"></i>
                                </div>
                            @endif

                            <h4 class="mt-3 mb-1">
                                {{ $customer->name }}
                            </h4>

                            @if ($customer->email)
                                <div class="text-muted">
                                    {{ $customer->email }}
                                </div>
                            @endif
                        </div>

                        <div class="mb-3">
                            <label class="form-label text-muted small mb-1">
                                Phone
                            </label>
                            <div class="fw-medium">
                                {{ $customer->phone ?? '—' }}
                            </div>
                        </div>

                        <div class="mb-3">
                            <label class="form-label text-muted small mb-1">
                                Address
                            </label>
                            <div class="fw-medium">
                                {{ $customer->address ?? '—' }}
                            </div>
                        </div>

                        <div class="mb-3">
                            <label class="form-label text-muted small mb-1">
                                Joined
                            </label>
                            <div class="fw-medium">
                                {{ $customer->created_at?->format('M d, Y h:i A') }}
                            </div>
                        </div>

                        <div>
                            <label class="form-label text-muted small mb-1">
                                Status
                            </label>

                            <div class="d-flex align-items-center gap-2">
                                @if ($customer->is_active)
                                    <span class="badge bg-success">
                                        Active
                                    </span>
                                @else
                                    <span class="badge bg-danger">
                                        Inactive
                                    </span>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>

                @can('customers.edit')
                    <div class="card">
                        <div class="card-header">
                            <h4 class="card-title mb-0">
                                Update Status
                            </h4>
                        </div>

                        <div class="card-body">
                            <form
                                action="{{ route('admin.customers.update', $customer) }}"
                                method="POST"
                            >
                                @csrf
                                @method('PUT')

                                <div class="mb-3">
                                    <label class="form-label">
                                        Customer Status
                                    </label>

                                    <select
                                        name="is_active"
                                        class="form-select @error('is_active') is-invalid @enderror"
                                    >
                                        <option
                                            value="1"
                                            {{ $customer->is_active ? 'selected' : '' }}
                                        >
                                            Active
                                        </option>

                                        <option
                                            value="0"
                                            {{ !$customer->is_active ? 'selected' : '' }}
                                        >
                                            Inactive
                                        </option>
                                    </select>

                                    @error('is_active')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>

                                <button
                                    type="submit"
                                    class="btn btn-primary"
                                >
                                    <i class="fa fa-save me-1"></i>
                                    Update Status
                                </button>
                            </form>
                        </div>
                    </div>
                @endcan
            </div>

            <div class="col-md-8">
                <div class="row">
                    <div class="col-md-3">
                        <div class="card">
                            <div class="card-body">
                                <div class="text-muted small mb-1">
                                    Orders
                                </div>
                                <h3 class="mb-0">
                                    {{ $customer->orders->count() }}
                                </h3>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-3">
                        <div class="card">
                            <div class="card-body">
                                <div class="text-muted small mb-1">
                                    Wishlist
                                </div>
                                <h3 class="mb-0">
                                    {{ $customer->wishlists->count() }}
                                </h3>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-3">
                        <div class="card">
                            <div class="card-body">
                                <div class="text-muted small mb-1">
                                    Compare
                                </div>
                                <h3 class="mb-0">
                                    {{ $customer->compares->count() }}
                                </h3>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-3">
                        <div class="card">
                            <div class="card-body">
                                <div class="text-muted small mb-1">
                                    Reviews
                                </div>
                                <h3 class="mb-0">
                                    {{ $customer->reviews->count() }}
                                </h3>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title mb-0">
                            Orders
                        </h4>
                    </div>

                    <div class="card-body">
                        @forelse ($customer->orders as $order)
                            <div class="d-flex align-items-center justify-content-between border-bottom py-3">
                                <div>
                                    <div class="fw-semibold">
                                        {{ $order->order_number }}
                                    </div>

                                    <small class="text-muted">
                                        {{ $order->created_at?->format('M d, Y h:i A') }}
                                    </small>
                                </div>

                                <div class="text-end">
                                    <div class="fw-semibold">
                                        {{ $order->currency }}
                                        {{ number_format($order->total, 2) }}
                                    </div>

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
                                </div>
                            </div>
                        @empty
                            <div class="text-center py-4">
                                <i class="fas fa-shopping-cart fa-2x text-muted mb-2"></i>
                                <p class="text-muted mb-0">
                                    No orders found.
                                </p>
                            </div>
                        @endforelse
                    </div>
                </div>

                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title mb-0">
                            Wishlist
                        </h4>
                    </div>

                    <div class="card-body">
                        @forelse ($customer->wishlists as $wishlist)
                            @if ($wishlist->product)
                                <div class="d-flex align-items-center border-bottom py-3">
                                    @if ($wishlist->product->thumbnail)
                                        <img
                                            src="{{ asset('storage/' . $wishlist->product->thumbnail) }}"
                                            alt="{{ $wishlist->product->name }}"
                                            width="50"
                                            height="50"
                                            class="rounded me-3"
                                        >
                                    @endif

                                    <div>
                                        <div class="fw-semibold">
                                            {{ $wishlist->product->name }}
                                        </div>

                                        <small class="text-muted">
                                            Added {{ $wishlist->created_at?->format('M d, Y') }}
                                        </small>
                                    </div>
                                </div>
                            @endif
                        @empty
                            <p class="text-muted mb-0">
                                No wishlist products found.
                            </p>
                        @endforelse
                    </div>
                </div>

                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title mb-0">
                            Compare
                        </h4>
                    </div>

                    <div class="card-body">
                        @forelse ($customer->compares as $compare)
                            @if ($compare->product)
                                <div class="d-flex align-items-center border-bottom py-3">
                                    @if ($compare->product->thumbnail)
                                        <img
                                            src="{{ asset('storage/' . $compare->product->thumbnail) }}"
                                            alt="{{ $compare->product->name }}"
                                            width="50"
                                            height="50"
                                            class="rounded me-3"
                                        >
                                    @endif

                                    <div>
                                        <div class="fw-semibold">
                                            {{ $compare->product->name }}
                                        </div>

                                        <small class="text-muted">
                                            Added {{ $compare->created_at?->format('M d, Y') }}
                                        </small>
                                    </div>
                                </div>
                            @endif
                        @empty
                            <p class="text-muted mb-0">
                                No compare products found.
                            </p>
                        @endforelse
                    </div>
                </div>

                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title mb-0">
                            Reviews
                        </h4>
                    </div>

                    <div class="card-body">
                        @forelse ($customer->reviews as $review)
                            <div class="border-bottom py-3">
                                <div class="d-flex align-items-center justify-content-between mb-2">
                                    <div class="fw-semibold">
                                        {{ $review->product?->name ?? 'Product unavailable' }}
                                    </div>

                                    <div>
                                        @for ($i = 1; $i <= 5; $i++)
                                            @if ($i <= $review->rating)
                                                <i class="fa fa-star text-warning"></i>
                                            @else
                                                <i class="far fa-star text-muted"></i>
                                            @endif
                                        @endfor
                                    </div>
                                </div>

                                @if ($review->title)
                                    <div class="fw-medium mb-1">
                                        {{ $review->title }}
                                    </div>
                                @endif

                                @if ($review->review)
                                    <div class="text-muted">
                                        {{ $review->review }}
                                    </div>
                                @endif

                                <small class="text-muted">
                                    {{ $review->created_at?->format('M d, Y h:i A') }}
                                </small>
                            </div>
                        @empty
                            <p class="text-muted mb-0">
                                No reviews found.
                            </p>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection