<div class="table-responsive">
    <table class="table table-hover align-middle">
        <thead>
            <tr>
                <th width="60">#</th>
                <th>Customer</th>
                <th>Compared Products</th>
                <th width="150">Added At</th>
                <th width="110">Action</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($compares as $compare)
                @php
                    $compareId = $compare['compare_ids']->first();
                    $userId = $compare['user']?->id;
                @endphp
                <tr>
                    <td>
                        {{ $compares->firstItem() + $loop->index }}
                    </td>
                    <td>
                        <div class="fw-medium">
                            {{ $compare['user']?->name ?? '—' }}
                        </div>

                        @if ($compare['user']?->email)
                            <small class="text-muted">
                                {{ $compare['user']->email }}
                            </small>
                        @endif
                    </td>
                    <td>
                        <div class="d-flex flex-wrap gap-2">
                            @foreach ($compare['products'] as $product)
                                <div class="d-flex align-items-center border rounded px-2 py-1">
                                    @if ($product->thumbnail)
                                        <img
                                            src="{{ asset('storage/' . $product->thumbnail) }}"
                                            alt="{{ $product->name }}"
                                            class="rounded me-2"
                                            style="width:40px;height:40px;object-fit:cover;"
                                        >
                                    @else
                                        <div
                                            class="rounded bg-light d-flex align-items-center justify-content-center me-2"
                                            style="width:40px;height:40px;"
                                        >
                                            <i class="fas fa-image text-muted"></i>
                                        </div>
                                    @endif

                                    <div>
                                        <div class="fw-semibold">
                                            {{ $product->name }}
                                        </div>

                                        @if ($product->sku)
                                            <small class="text-muted">
                                                {{ $product->sku }}
                                            </small>
                                        @endif
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </td>
                    <td>
                        <span class="text-muted">
                            {{ $compare['created_at']?->format('M d, Y h:i A') ?? '—' }}
                        </span>
                    </td>
                    <td>
                        <div class="d-flex gap-1">
                            @can('product-compares.view')
                                <a
                                    href="{{ route('admin.product-compares.show', $compareId) }}"
                                    class="btn btn-info btn-sm"
                                    title="View"
                                    data-bs-toggle="tooltip"
                                >
                                    <i class="fa fa-eye"></i>
                                </a>
                            @endcan

                            @can('product-compares.delete')
                                <form
                                    id="deleteProductCompareForm{{ $userId }}"
                                    action="{{ route('admin.product-compares.destroy', $compareId) }}"
                                    method="POST"
                                    class="d-inline"
                                >
                                    @csrf
                                    @method('DELETE')
                                </form>

                                <button
                                    type="button"
                                    class="btn btn-danger btn-sm"
                                    title="Remove"
                                    data-bs-toggle="modal"
                                    data-bs-target="#deleteProductCompareModal{{ $userId }}"
                                >
                                    <i class="fa fa-trash"></i>
                                </button>

                                <x-confirm-modal
                                    id="deleteProductCompareModal{{ $userId }}"
                                    formId="deleteProductCompareForm{{ $userId }}"
                                    title="Remove Compare?"
                                    message="Are you sure you want to remove this customer's product comparison list?"
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
                            <i class="fas fa-exchange-alt fa-3x text-muted mb-3"></i>
                            <h5 class="text-muted">
                                No product compares found
                            </h5>
                        </div>
                    </td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>

<div class="mt-3" id="product-compares-pagination">
    {{ $compares->links('pagination::bootstrap-5') }}
</div>