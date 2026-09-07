<div class="table-responsive">
    <table class="table table-hover align-middle">
        <thead>
            <tr>
                <th width="60">#</th>
                <th width="90">Image</th>
                <th>Title</th>
                <th>Button</th>
                <th>Sort Order</th>
                <th>Status</th>
                <th>Created</th>
                <th width="170">Action</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($sliders as $slider)
            <tr>
                <td>{{ $sliders->firstItem() + $loop->index }}</td>

                <td>
                    @if ($slider->image)
                    <img
                        src="{{ asset('storage/' . $slider->image) }}"
                        alt="{{ $slider->title }}"
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
                    <div class="fw-semibold">{{ $slider->title ?: 'Untitled Slider' }}</div>
                    @if ($slider->subtitle)
                    <small class="text-muted">
                        {{ Str::limit($slider->subtitle, 60) }}
                    </small>
                    @endif
                </td>

                <td>
                    @if ($slider->button_text)
                    <div class="fw-semibold">{{ $slider->button_text }}</div>
                    @if ($slider->button_url)
                    <small class="text-muted">{{ Str::limit($slider->button_url, 40) }}</small>
                    @endif
                    @else
                    <span class="text-muted">—</span>
                    @endif
                </td>

                <td>
                    <span class="badge bg-light text-dark">
                        {{ $slider->sort_order }}
                    </span>
                </td>

                <td>
                    @if ($slider->status == 1)
                    <span class="badge bg-success">Active</span>
                    @else
                    <span class="badge bg-warning">Inactive</span>
                    @endif
                </td>

                <td>
                    @if ($slider->created_at)
                    <div>{{ $slider->created_at->format('d M Y') }}</div>
                    <small class="text-muted">
                        {{ $slider->created_at->format('h:i A') }}
                    </small>
                    @else
                    <span class="text-muted">—</span>
                    @endif
                </td>

                <td>
                    <div class="d-flex gap-1">
                        @can('sliders.edit')
                        <a
                            href="{{ route('admin.sliders.edit', $slider) }}"
                            class="btn btn-primary btn-sm"
                            title="Edit"
                            data-bs-toggle="tooltip">
                            <i class="fa fa-edit"></i>
                        </a>
                        @endcan

                        @can('sliders.delete')
                        <form
                            id="deleteSliderForm{{ $slider->id }}"
                            action="{{ route('admin.sliders.destroy', $slider) }}"
                            method="POST"
                            class="d-inline">
                            @csrf
                            @method('DELETE')

                            <button
                                type="button"
                                class="btn btn-danger btn-sm"
                                title="Delete"
                                data-bs-toggle="modal"
                                data-bs-target="#deleteSliderModal{{ $slider->id }}">
                                <i class="fa fa-trash"></i>
                            </button>
                        </form>

                        <x-confirm-modal
                            id="deleteSliderModal{{ $slider->id }}"
                            formId="deleteSliderForm{{ $slider->id }}"
                            title="Delete Slider?"
                            message="Are you sure you want to delete this slider?"
                            confirmText="Yes, Delete"
                            confirmClass="btn-danger" />
                        @endcan
                    </div>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="8">
                    <div class="text-center py-5">
                        <i class="fas fa-images fa-3x text-muted mb-3"></i>
                        <h5 class="text-muted">No sliders found</h5>

                        @can('sliders.create')
                        <a
                            href="{{ route('admin.sliders.create') }}"
                            class="btn btn-primary btn-sm mt-2">
                            <i class="fa fa-plus me-1"></i>
                            Create Slider
                        </a>
                        @endcan
                    </div>
                </td>
            </tr>
            @endforelse
        </tbody>
    </table>
</div>

<div class="mt-3" id="sliders-pagination">
    {{ $sliders->links('pagination::bootstrap-5') }}
</div>