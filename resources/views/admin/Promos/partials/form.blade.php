<div class="row">
    <div class="col-md-8">
        <div class="form-group mb-3">
            <label for="title">
                Promo Text <span class="text-danger">*</span>
            </label>

            <input
                type="text"
                name="title"
                id="title"
                class="form-control @error('title') is-invalid @enderror"
                placeholder="Enter promo text"
                value="{{ old('title', $promo->title ?? '') }}"
                required
            >

            @error('title')
                <div class="invalid-feedback">
                    {{ $message }}
                </div>
            @enderror
        </div>
    </div>

    <div class="col-md-2">
        <div class="form-group mb-3">
            <label for="sort_order">
                Sort Order <span class="text-danger">*</span>
            </label>

            <input
                type="number"
                name="sort_order"
                id="sort_order"
                class="form-control @error('sort_order') is-invalid @enderror"
                min="0"
                value="{{ old('sort_order', $promo->sort_order ?? 0) }}"
                required
            >

            @error('sort_order')
                <div class="invalid-feedback">
                    {{ $message }}
                </div>
            @enderror
        </div>
    </div>

    <div class="col-md-2">
        <div class="form-group mb-3">
            <label for="status">
                Status <span class="text-danger">*</span>
            </label>

            <select
                name="status"
                id="status"
                class="form-control @error('status') is-invalid @enderror"
                required
            >
                <option value="1" @selected(old('status', $promo->status ?? 1) == 1)>
                    Active
                </option>

                <option value="0" @selected(old('status', $promo->status ?? 1) == 0)>
                    Inactive
                </option>
            </select>

            @error('status')
                <div class="invalid-feedback">
                    {{ $message }}
                </div>
            @enderror
        </div>
    </div>
</div>

<div class="row">
    <div class="col-md-12">
        <div class="form-group mb-3">
            <label for="description">
                Description
            </label>

            <textarea
                name="description"
                id="description"
                rows="4"
                class="form-control @error('description') is-invalid @enderror"
                placeholder="Enter promo description"
            >{{ old('description', $promo->description ?? '') }}</textarea>

            @error('description')
                <div class="invalid-feedback">
                    {{ $message }}
                </div>
            @enderror
        </div>
    </div>
</div>

<div class="row">
    <div class="col-md-6">
        <div class="form-group mb-3">
            <label for="start_date">Start Date</label>

            <input
                type="datetime-local"
                name="start_date"
                id="start_date"
                class="form-control @error('start_date') is-invalid @enderror"
                value="{{ old('start_date', $promo?->start_date?->format('Y-m-d\TH:i')) }}"
            >

            @error('start_date')
                <div class="invalid-feedback">
                    {{ $message }}
                </div>
            @enderror
        </div>
    </div>

    <div class="col-md-6">
        <div class="form-group mb-3">
            <label for="end_date">End Date</label>

            <input
                type="datetime-local"
                name="end_date"
                id="end_date"
                class="form-control @error('end_date') is-invalid @enderror"
                value="{{ old('end_date', $promo?->end_date?->format('Y-m-d\TH:i')) }}"
            >

            @error('end_date')
                <div class="invalid-feedback">
                    {{ $message }}
                </div>
            @enderror
        </div>
    </div>
</div>

<div class="card border mt-4">
    <div class="card-header">
        <div class="d-flex align-items-center">
            <div>
                <h5 class="mb-1">Promo Buttons</h5>
                <p class="text-muted mb-0">Add buttons to display with this promo</p>
            </div>

            <button type="button" class="btn btn-primary btn-sm ms-auto" id="addPromoButton">
                <i class="fa fa-plus me-1"></i>
                Add Button
            </button>
        </div>
    </div>

    <div class="card-body">
        <div id="promo-buttons">
            @if ($promo?->buttons?->count())
                @foreach ($promo->buttons as $index => $button)
                    @include('admin.Promos.partials.button-row', [
                        'button' => $button,
                        'index' => $index,
                    ])
                @endforeach
            @else
                <div class="text-muted text-center py-3" id="no-promo-buttons">
                    No buttons added.
                </div>
            @endif
        </div>
    </div>
</div>

@push('scripts')
<script>
    $(document).ready(function () {
        let buttonIndex = {{ $promo?->buttons?->count() ?? 0 }};
        $('#addPromoButton').on('click', function () {
            $('#no-promo-buttons').remove();
            const row = `
                <div class="promo-button-row border rounded p-3 mb-3">
                    <input type="hidden" name="buttons[${buttonIndex}][id]" value="">
                    <div class="row align-items-end">
                        <div class="col-md-3">
                            <div class="form-group mb-0">
                                <label class="form-label">Label <span class="text-danger">*</span></label>
                                <input
                                    type="text"
                                    name="buttons[${buttonIndex}][label]"
                                    class="form-control"
                                    placeholder="e.g. MEN"
                                    required
                                >
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group mb-0">
                                <label class="form-label">URL <span class="text-danger">*</span></label>
                                <input
                                    type="text"
                                    name="buttons[${buttonIndex}][url]"
                                    class="form-control"
                                    placeholder="e.g. /men"
                                    required
                                >
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="form-group mb-0">
                                <label class="form-label">Order <span class="text-danger">*</span></label>
                                <input
                                    type="number"
                                    name="buttons[${buttonIndex}][sort_order]"
                                    class="form-control"
                                    min="0"
                                    value="${buttonIndex + 1}"
                                    required
                                >
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="form-group mb-0">
                                <label class="form-label">Status</label>
                                <select
                                    name="buttons[${buttonIndex}][status]"
                                    class="form-control"
                                >
                                    <option value="1" selected>Active</option>
                                    <option value="0">Inactive</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-1">
                            <div class="form-group mb-0">
                                <label class="form-label">Action</label>
                                <button
                                    type="button"
                                    class="btn btn-danger btn-sm remove-promo-button w-100"
                                    title="Remove"
                                >
                                    <i class="fa fa-trash"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            `;
            $('#promo-buttons').append(row);
            buttonIndex++;
        });
        $(document).on('click', '.remove-promo-button', function () {
            $(this).closest('.promo-button-row').remove();
            if ($('.promo-button-row').length === 0) {
                $('#promo-buttons').html(`
                    <div class="text-muted text-center py-3" id="no-promo-buttons">
                        No buttons added.
                    </div>
                `);
            }
        });
    });
</script>
@endpush