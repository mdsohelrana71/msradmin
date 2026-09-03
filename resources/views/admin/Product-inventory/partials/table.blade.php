<div class="table-responsive">
    <table class="table table-hover align-middle">
        <thead>
            <tr>
                <th width="60">#</th>
                <th>Product</th>
                <th>Variant</th>
                <th width="110">On Hand</th>
                <th width="110">Reserved</th>
                <th width="110">Available</th>
                <th width="120">Status</th>
                <th width="110">Action</th>
            </tr>
        </thead>

        <tbody>
            @forelse ($inventories as $inventory)
                <tr>
                    <td>
                        {{ $inventories->firstItem() + $loop->index }}
                    </td>

                    <td>
                        <div class="fw-semibold">
                            {{ $inventory->product?->name ?? '—' }}
                        </div>

                        @if ($inventory->product?->sku)
                            <small class="text-muted">
                                {{ $inventory->product->sku }}
                            </small>
                        @endif
                    </td>

                    <td>
                        @if ($inventory->variant)
                            @forelse ($inventory->variant->values as $value)
                                <span class="d-block">
                                    <small class="text-muted">
                                        {{ $value->attribute?->name }}:
                                    </small>
                                    {{ $value->attributeValue?->value }}
                                </span>
                            @empty
                                <span class="text-muted">
                                    Variant
                                </span>
                            @endforelse
                        @else
                            <span class="text-muted">
                                Default
                            </span>
                        @endif
                    </td>

                    <td>
                        <span class="fw-medium">
                            {{ $inventory->stock }}
                        </span>
                    </td>

                    <td>
                        <span class="text-muted">
                            {{ $inventory->reserved_stock }}
                        </span>
                    </td>

                    <td>
                        <span class="fw-semibold">
                            {{ $inventory->available_stock }}
                        </span>
                    </td>

                    <td>
                        @if ($inventory->stock_status === 'out_of_stock')
                            <span class="badge bg-danger">
                                Out of Stock
                            </span>
                        @elseif ($inventory->stock_status === 'low_stock')
                            <span class="badge bg-warning">
                                Low Stock
                            </span>
                        @else
                            <span class="badge bg-success">
                                In Stock
                            </span>
                        @endif
                    </td>

                    <td>
                        <div class="d-flex gap-1">
                            @can('product-inventory.view')
                                <a
                                    href="{{ route(
                                        'admin.product-inventory.show',
                                        $inventory
                                    ) }}"
                                    class="btn btn-info btn-sm"
                                    title="View"
                                    data-bs-toggle="tooltip"
                                >
                                    <i class="fa fa-eye"></i>
                                </a>
                            @endcan

                            @can('product-inventory.edit')
                                <a
                                    href="{{ route(
                                        'admin.product-inventory.edit',
                                        $inventory
                                    ) }}"
                                    class="btn btn-primary btn-sm"
                                    title="Edit"
                                    data-bs-toggle="tooltip"
                                >
                                    <i class="fa fa-edit"></i>
                                </a>
                            @endcan
                        </div>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="8">
                        <div class="text-center py-5">
                            <i class="fas fa-boxes fa-3x text-muted mb-3"></i>

                            <h5 class="text-muted">
                                No product inventory found
                            </h5>
                        </div>
                    </td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>

<div class="mt-3" id="product-inventory-pagination">
    {{ $inventories->links('pagination::bootstrap-5') }}
</div>