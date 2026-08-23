<div class="table-responsive">
    <table class="table table-hover align-middle">
        <thead>
            <tr>
                <th width="60">#</th>
                <th width="300">Question</th>
                <th>Products</th>
                <th width="110">Status</th>
                <th width="110">Sort Order</th>
                <th width="150">Action</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($faqs as $faq)
                <tr>
                    <td>
                        {{ $faqs->firstItem() + $loop->index }}
                    </td>
                    {{-- Question --}}
                    <td>
                        <div class="fw-semibold">
                            {{ $faq->question }}
                        </div>
                        <small class="text-muted">
                            {{ \Illuminate\Support\Str::limit(strip_tags($faq->answer), 80) }}
                        </small>
                    </td>
                    {{-- Products --}}
                    <td>
                        @forelse ($faq->products->take(4) as $product)
                            <span class="badge bg-info me-1 mb-1">
                                {{ $product->name }}
                            </span>
                        @empty
                            <span class="text-muted">
                                No products
                            </span>
                        @endforelse

                        @if ($faq->products->count() > 4)
                            <a
                                href="{{ route('admin.product-faqs.show', $faq) }}"
                                class="btn btn-info btn-sm p-0 ms-1 d-inline-flex align-items-center justify-content-center"
                                style="width: 25px; height: 20px;"
                                title="View all products"
                                data-bs-toggle="tooltip"
                            >
                                <i class="fa fa-eye"></i>
                            </a>
                        @endif
                    </td>
                    {{-- Status --}}
                    <td>
                        @if ($faq->status)
                            <span class="badge bg-success">
                                Active
                            </span>
                        @else
                            <span class="badge bg-warning">
                                Inactive
                            </span>
                        @endif
                    </td>
                    {{-- Sort Order --}}
                    <td>
                        <span class="text-muted">
                            {{ $faq->sort_order }}
                        </span>
                    </td>
                    {{-- Actions --}}
                    <td>
                        <div class="d-flex gap-1">
                            @can('product-faqs.view')
                                <a
                                    href="{{ route('admin.product-faqs.show', $faq) }}"
                                    class="btn btn-info btn-sm"
                                    title="View"
                                    data-bs-toggle="tooltip"
                                >
                                    <i class="fa fa-eye"></i>
                                </a>
                            @endcan
                            @can('product-faqs.edit')
                                <a
                                    href="{{ route('admin.product-faqs.edit', $faq) }}"
                                    class="btn btn-primary btn-sm"
                                    title="Edit"
                                    data-bs-toggle="tooltip"
                                >
                                    <i class="fa fa-edit"></i>
                                </a>
                            @endcan
                            @can('product-faqs.delete')
                                <form
                                    id="deleteProductFaqForm{{ $faq->id }}"
                                    action="{{ route('admin.product-faqs.destroy', $faq) }}"
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
                                        data-bs-target="#deleteProductFaqModal{{ $faq->id }}"
                                    >
                                        <i class="fa fa-trash"></i>
                                    </button>
                                </form>
                                <x-confirm-modal
                                    id="deleteProductFaqModal{{ $faq->id }}"
                                    formId="deleteProductFaqForm{{ $faq->id }}"
                                    title="Delete Product FAQ?"
                                    message="Are you sure you want to delete this product FAQ?"
                                    confirmText="Yes, Delete"
                                    confirmClass="btn-danger"
                                />
                            @endcan
                        </div>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="6">
                        <div class="text-center py-5">
                            <i class="fas fa-question-circle fa-3x text-muted mb-3"></i>
                            <h5 class="text-muted">
                                No product FAQs found
                            </h5>
                            @can('product-faqs.create')
                                <a
                                    href="{{ route('admin.product-faqs.create') }}"
                                    class="btn btn-primary btn-sm mt-2"
                                >
                                    <i class="fa fa-plus me-1"></i>
                                    Create FAQ
                                </a>
                            @endcan
                        </div>
                    </td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>

<div
    class="mt-3"
    id="product-faqs-pagination"
>
    {{ $faqs->links('pagination::bootstrap-5') }}
</div>