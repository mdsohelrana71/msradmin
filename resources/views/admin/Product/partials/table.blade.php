<div class="table-responsive">
    <table class="table table-hover align-middle">
        <thead>
            <tr>
                <th width="60">#</th>
                <th width="90">Image</th>
                <th>Title</th>
                <th>Category</th>
                <th>Status</th>
                <th>Published</th>
                <th width="170">Action</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($products as $product)
            <tr>
                <td>{{ $products->firstItem() + $loop->index }}</td>

                <td>
                    @if ($product->featured_image)
                    <img
                        src="{{ asset('storage/' . $product->featured_image) }}"
                        alt="{{ $product->title }}"
                        class="rounded"
                        style="width:65px;height:50px;object-fit:cover;">
                    @else
                    <div
                        class="rounded bg-light d-flex align-items-center justify-content-center"
                        style="width:65px;height:50px;">
                        <i class="fas fa-image text-muted"></i>
                    </div>
                    @endif
                </td>

                <td>
                    <div class="fw-semibold">{{ $product->title }}</div>
                    @if ($product->slug)
                    <small class="text-muted">{{ $product->slug }}</small>
                    @endif
                </td>

                <td>
                    @if ($product->category)
                    <span class="badge bg-info">
                        {{ $product->category->name }}
                    </span>
                    @else
                    <span class="text-muted">—</span>
                    @endif
                </td>

                <td>
                    @if ($product->status === 1)
                    <span class="badge bg-success">Published</span>
                    @else
                    <span class="badge bg-warning">Draft</span>
                    @endif
                </td>

                <td>
                    @if ($product->published_at)
                    <div>{{ $product->published_at->format('d M Y') }}</div>
                    <small class="text-muted">
                        {{ $product->published_at->format('h:i A') }}
                    </small>
                    @else
                    <span class="text-muted">—</span>
                    @endif
                </td>

                <td>
                    <div class="d-flex gap-1">
                        @can('products.view')
                        <a
                            href="{{ route('admin.products.show', $product) }}"
                            class="btn btn-info btn-sm"
                            title="View"
                            data-bs-toggle="tooltip">
                            <i class="fa fa-eye"></i>
                        </a>
                        @endcan

                        @can('products.edit')
                        <a
                            href="{{ route('admin.products.edit', $product) }}"
                            class="btn btn-primary btn-sm"
                            title="Edit"
                            data-bs-toggle="tooltip">
                            <i class="fa fa-edit"></i>
                        </a>
                        @endcan

                        @can('products.delete')
                        <form
                            id="deleteProductForm{{ $product->id }}"
                            action="{{ route('admin.products.destroy', $product) }}"
                            method="POST"
                            class="d-inline">
                            @csrf
                            @method('DELETE')

                            <button
                                type="button"
                                class="btn btn-danger btn-sm"
                                title="Delete"
                                data-bs-toggle="modal"
                                data-bs-target="#deleteProductModal{{ $product->id }}">
                                <i class="fa fa-trash"></i>
                            </button>
                        </form>

                        <x-confirm-modal
                            id="deleteProductModal{{ $product->id }}"
                            formId="deleteProductForm{{ $product->id }}"
                            title="Delete Product?"
                            message="Are you sure you want to delete this product?"
                            confirmText="Yes, Delete"
                            confirmClass="btn-danger" />
                        @endcan
                    </div>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="7">
                    <div class="text-center py-5">
                        <i class="fas fa-box fa-3x text-muted mb-3"></i>
                        <h5 class="text-muted">No products found</h5>

                        @can('products.create')
                        <a
                            href="{{ route('admin.products.create') }}"
                            class="btn btn-primary btn-sm mt-2">
                            <i class="fa fa-plus me-1"></i>
                            Create Product
                        </a>
                        @endcan
                    </div>
                </td>
            </tr>
            @endforelse
        </tbody>
    </table>
</div>

<div class="mt-3" id="products-pagination">
    {{ $products->links('pagination::bootstrap-5') }}
</div>