<div class="table-responsive">
    <table class="table table-hover align-middle">
        <thead>
            <tr>
                <th width="60">#</th>
                <th>Value</th>
                <th>Status</th>
                <th>Sort Order</th>
                <th width="140">Action</th>
            </tr>
        </thead>

        <tbody>
            @forelse ($values as $value)
                <tr>
                    <td>
                        {{ $values->firstItem() + $loop->index }}
                    </td>

                    <td>
                        <div class="fw-semibold">
                            {{ $value->value }}
                        </div>

                        @if ($value->slug)
                            <small class="text-muted">
                                {{ $value->slug }}
                            </small>
                        @endif
                    </td>

                    <td>
                        @if ($value->status)
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
                            {{ $value->sort_order }}
                        </span>
                    </td>

                    <td>
                        <div class="d-flex gap-1">
                            @can('product-attributes.edit')
                                <a
                                    href="{{ route(
                                        'admin.product-attributes.values.edit',
                                        [
                                            $product_attribute,
                                            $value,
                                        ]
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
                                    id="deleteAttributeValueForm{{ $value->id }}"
                                    action="{{ route(
                                        'admin.product-attributes.values.destroy',
                                        [
                                            $product_attribute,
                                            $value,
                                        ]
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
                                        data-bs-target="#deleteAttributeValueModal{{ $value->id }}"
                                    >
                                        <i class="fa fa-trash"></i>
                                    </button>
                                </form>

                                <x-confirm-modal
                                    id="deleteAttributeValueModal{{ $value->id }}"
                                    formId="deleteAttributeValueForm{{ $value->id }}"
                                    title="Delete Attribute Value?"
                                    message="Are you sure you want to delete this attribute value?"
                                    confirmText="Yes, Delete"
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
                            <i class="fas fa-list fa-3x text-muted mb-3"></i>

                            <h5 class="text-muted">
                                No attribute values found
                            </h5>

                            @can('product-attributes.create')
                                <a
                                    href="{{ route(
                                        'admin.product-attributes.values.create',
                                        $product_attribute
                                    ) }}"
                                    class="btn btn-primary btn-sm mt-2"
                                >
                                    <i class="fa fa-plus me-1"></i>
                                    Create Value
                                </a>
                            @endcan
                        </div>
                    </td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>

<div class="mt-3" id="attribute-values-pagination">
    {{ $values->links('pagination::bootstrap-5') }}
</div>