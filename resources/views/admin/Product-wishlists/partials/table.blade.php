<div class="table-responsive">
    <table class="table table-hover align-middle">
        <thead>
            <tr>
                <th width="60">#</th>
                <th>Product</th>
                <th>Customer</th>
                <th width="150">Added At</th>
                <th width="110">Action</th>
            </tr>
        </thead>

        <tbody>
            @forelse ($wishlists as $wishlist)
                <tr>
                    <td>
                        {{ $wishlists->firstItem() + $loop->index }}
                    </td>

                    <td>
                        <div class="d-flex align-items-center">
                            @if ($wishlist->product?->thumbnail)
                                <img
                                    src="{{ asset('storage/' . $wishlist->product->thumbnail) }}"
                                    alt="{{ $wishlist->product->name }}"
                                    class="rounded me-2"
                                    style="width:45px;height:45px;object-fit:cover;"
                                >
                            @else
                                <div
                                    class="rounded bg-light d-flex align-items-center justify-content-center me-2"
                                    style="width:45px;height:45px;"
                                >
                                    <i class="fas fa-image text-muted"></i>
                                </div>
                            @endif

                            <div>
                                <div class="fw-semibold">
                                    {{ $wishlist->product?->name ?? '—' }}
                                </div>

                                @if ($wishlist->product?->sku)
                                    <small class="text-muted">
                                        {{ $wishlist->product->sku }}
                                    </small>
                                @endif
                            </div>
                        </div>
                    </td>

                    <td>
                        <div class="fw-medium">
                            {{ $wishlist->user?->name ?? '—' }}
                        </div>

                        @if ($wishlist->user?->email)
                            <small class="text-muted">
                                {{ $wishlist->user->email }}
                            </small>
                        @endif
                    </td>

                    <td>
                        <span class="text-muted">
                            {{ $wishlist->created_at?->format('M d, Y h:i A') ?? '—' }}
                        </span>
                    </td>

                    <td>
                        <div class="d-flex gap-1">
                            @can('product-wishlists.view')
                                <a
                                    href="{{ route('admin.product-wishlists.show', $wishlist) }}"
                                    class="btn btn-info btn-sm"
                                    title="View"
                                    data-bs-toggle="tooltip"
                                >
                                    <i class="fa fa-eye"></i>
                                </a>
                            @endcan

                            @can('product-wishlists.delete')
                                <form
                                    id="deleteProductWishlistForm{{ $wishlist->id }}"
                                    action="{{ route('admin.product-wishlists.destroy', $wishlist) }}"
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
                                        data-bs-target="#deleteProductWishlistModal{{ $wishlist->id }}"
                                    >
                                        <i class="fa fa-trash"></i>
                                    </button>
                                </form>

                                <x-confirm-modal
                                    id="deleteProductWishlistModal{{ $wishlist->id }}"
                                    formId="deleteProductWishlistForm{{ $wishlist->id }}"
                                    title="Remove Wishlist?"
                                    message="Are you sure you want to remove this product from the customer's wishlist?"
                                    confirmText="Yes, Remove"
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
                            <i class="fas fa-heart fa-3x text-muted mb-3"></i>

                            <h5 class="text-muted">
                                No product wishlists found
                            </h5>
                        </div>
                    </td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>

<div class="mt-3" id="product-wishlists-pagination">
    {{ $wishlists->links('pagination::bootstrap-5') }}
</div>