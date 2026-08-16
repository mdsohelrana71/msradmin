<div class="table-responsive">
    <table class="table table-hover align-middle">
        <thead>
            <tr>
                <th width="60">#</th>
                <th width="220">Attribute</th>
                <th>Values</th>
                <th width="110">Status</th>
                <th width="110">Sort Order</th>
                <th width="190">Action</th>
            </tr>
        </thead>

        <tbody>
            @forelse ($attributes as $attribute)
                <tr>
                    <td>
                        {{ $attributes->firstItem() + $loop->index }}
                    </td>

                    <td>
                        <div class="fw-semibold">
                            {{ $attribute->name }}
                        </div>

                        @if ($attribute->slug)
                            <small class="text-muted">
                                {{ $attribute->slug }}
                            </small>
                        @endif
                    </td>

                    <td>
                        @forelse ($attribute->values->take(5) as $value)
                            <span class="badge bg-info me-1 mb-1">
                                {{ $value->value }}
                            </span>
                        @empty
                            <span class="text-muted">
                                No values
                            </span>
                        @endforelse

                        @if ($attribute->values->count() > 5)
                            <a
                                href="{{ route(
                                    'admin.product-attributes.values.index',
                                    $attribute
                                ) }}"
                                class="small text-primary text-decoration-none"
                            >
                                +{{ $attribute->values->count() - 5 }} more
                            </a>
                        @endif
                    </td>

                    <td>
                        @if ($attribute->status)
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
                        <span class="text-muted">
                            {{ $attribute->sort_order }}
                        </span>
                    </td>

                    <td>
                        <div class="d-flex gap-1">
                            @can('product-attributes.view')
                                <a
                                    href="{{ route(
                                        'admin.product-attributes.values.index',
                                        $attribute
                                    ) }}"
                                    class="btn btn-info btn-sm"
                                    title="Manage Values"
                                    data-bs-toggle="tooltip"
                                >
                                    <i class="fa fa-list"></i>
                                </a>
                            @endcan

                            @can('product-attributes.edit')
                                <a
                                    href="{{ route(
                                        'admin.product-attributes.edit',
                                        $attribute
                                    ) }}"
                                    class="btn btn-primary btn-sm"
                                    title="Edit"
                                    data-bs-toggle="tooltip"
                                >
                                    <i class="fa fa-edit"></i>
                                </a>
                            @endcan

                            @can('product-attributes.delete')
                                <form
                                    id="deleteProductAttributeForm{{ $attribute->id }}"
                                    action="{{ route(
                                        'admin.product-attributes.destroy',
                                        $attribute
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
                                        data-bs-target="#deleteProductAttributeModal{{ $attribute->id }}"
                                    >
                                        <i class="fa fa-trash"></i>
                                    </button>
                                </form>

                                <x-confirm-modal
                                    id="deleteProductAttributeModal{{ $attribute->id }}"
                                    formId="deleteProductAttributeForm{{ $attribute->id }}"
                                    title="Delete Product Attribute?"
                                    message="Are you sure you want to delete this product attribute?"
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
                            <i class="fas fa-sliders-h fa-3x text-muted mb-3"></i>

                            <h5 class="text-muted">
                                No product attributes found
                            </h5>

                            @can('product-attributes.create')
                                <a
                                    href="{{ route(
                                        'admin.product-attributes.create'
                                    ) }}"
                                    class="btn btn-primary btn-sm mt-2"
                                >
                                    <i class="fa fa-plus me-1"></i>
                                    Create Attribute
                                </a>
                            @endcan
                        </div>
                    </td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>

<div class="mt-3" id="product-attributes-pagination">
    {{ $attributes->links('pagination::bootstrap-5') }}
</div>