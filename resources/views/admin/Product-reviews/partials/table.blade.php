<div class="table-responsive">
    <table class="table table-hover align-middle">
        <thead>
            <tr>
                <th width="60">#</th>
                <th>Product</th>
                <th>Customer</th>
                <th width="130">Rating</th>
                <th>Title</th>
                <th width="110">Verified</th>
                <th width="110">Status</th>
                <th width="140">Action</th>
            </tr>
        </thead>

        <tbody>
            @forelse ($reviews as $review)
                <tr>
                    <td>
                        {{ $reviews->firstItem() + $loop->index }}
                    </td>

                    <td>
                        <div class="d-flex align-items-center">
                            @if ($review->product?->thumbnail)
                                <img
                                    src="{{ asset('storage/' . $review->product->thumbnail) }}"
                                    alt="{{ $review->product->name }}"
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
                                    {{ $review->product?->name ?? '—' }}
                                </div>

                                @if ($review->product?->sku)
                                    <small class="text-muted">
                                        SKU: {{ $review->product->sku }}
                                    </small>
                                @endif
                            </div>
                        </div>
                    </td>

                    <td>
                        <div class="fw-medium">
                            {{ $review->user?->name ?? '—' }}
                        </div>

                        @if ($review->user?->email)
                            <small class="text-muted">
                                {{ $review->user->email }}
                            </small>
                        @endif
                    </td>

                    <td>
                        <div class="text-warning">
                            @for ($i = 1; $i <= 5; $i++)
                                <i class="fa fa-star{{ $i <= $review->rating ? '' : '-o' }}"></i>
                            @endfor
                        </div>

                        <small class="text-muted">
                            {{ $review->rating }}/5
                        </small>
                    </td>

                    <td>
                        @if ($review->title)
                            <div class="fw-medium">
                                {{ $review->title }}
                            </div>
                        @else
                            <span class="text-muted">—</span>
                        @endif

                        @if ($review->images->count())
                            <small class="text-muted">
                                <i class="fa fa-image me-1"></i>
                                {{ $review->images->count() }}
                            </small>
                        @endif
                    </td>

                    <td>
                        @if ($review->is_verified)
                            <span class="badge bg-success">
                                Verified
                            </span>
                        @else
                            <span class="badge bg-secondary">
                                Unverified
                            </span>
                        @endif
                    </td>

                    <td>
                        @if ($review->status)
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
                            @can('product-reviews.view')
                                <a
                                    href="{{ route(
                                        'admin.product-reviews.show',
                                        $review
                                    ) }}"
                                    class="btn btn-info btn-sm"
                                    title="View"
                                    data-bs-toggle="tooltip"
                                >
                                    <i class="fa fa-eye"></i>
                                </a>
                            @endcan

                            @can('product-reviews.edit')
                                <a
                                    href="{{ route(
                                        'admin.product-reviews.edit',
                                        $review
                                    ) }}"
                                    class="btn btn-primary btn-sm"
                                    title="Edit"
                                    data-bs-toggle="tooltip"
                                >
                                    <i class="fa fa-edit"></i>
                                </a>
                            @endcan

                            @can('product-reviews.delete')
                                <form
                                    id="deleteProductReviewForm{{ $review->id }}"
                                    action="{{ route(
                                        'admin.product-reviews.destroy',
                                        $review
                                    ) }}"
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
                                        data-bs-target="#deleteProductReviewModal{{ $review->id }}"
                                    >
                                        <i class="fa fa-trash"></i>
                                    </button>
                                </form>

                                <x-confirm-modal
                                    id="deleteProductReviewModal{{ $review->id }}"
                                    formId="deleteProductReviewForm{{ $review->id }}"
                                    title="Delete Product Review?"
                                    message="Are you sure you want to delete this product review?"
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
                            <i class="fas fa-star fa-3x text-muted mb-3"></i>

                            <h5 class="text-muted">
                                No product reviews found
                            </h5>
                        </div>
                    </td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>

<div class="mt-3" id="product-reviews-pagination">
    {{ $reviews->links('pagination::bootstrap-5') }}
</div>