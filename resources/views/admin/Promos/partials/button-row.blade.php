<div class="promo-button-row border rounded p-3 mb-3">
    <input type="hidden" name="buttons[{{ $index }}][id]" value="{{ $button->id ?? '' }}">
    <div class="row align-items-end">
        <div class="col-md-3">
            <div class="form-group mb-0">
                <label class="form-label">Label <span class="text-danger">*</span></label>
                <input type="text" name="buttons[{{ $index }}][label]" class="form-control" placeholder="e.g. MEN" value="{{ old("buttons.$index.label", $button->label ?? '') }}" required>
            </div>
        </div>
        <div class="col-md-4">
            <div class="form-group mb-0">
                <label class="form-label">URL <span class="text-danger">*</span></label>
                <input type="text" name="buttons[{{ $index }}][url]" class="form-control" placeholder="e.g. /men" value="{{ old("buttons.$index.url", $button->url ?? '') }}" required>
            </div>
        </div>
        <div class="col-md-2">
            <div class="form-group mb-0">
                <label class="form-label">Order <span class="text-danger">*</span></label>
                <input type="number" name="buttons[{{ $index }}][sort_order]" class="form-control" min="0" value="{{ old("buttons.$index.sort_order", $button->sort_order ?? $index + 1) }}" required>
            </div>
        </div>
        <div class="col-md-2">
            <div class="form-group mb-0">
                <label class="form-label">Status</label>
                <select name="buttons[{{ $index }}][status]" class="form-control">
                    <option value="1" @selected(old("buttons.$index.status", $button->status ?? 1) == 1)>Active</option>
                    <option value="0" @selected(old("buttons.$index.status", $button->status ?? 1) == 0)>Inactive</option>
                </select>
            </div>
        </div>
        <div class="col-md-1">
            <div class="form-group mb-0">
                <label class="form-label">Action</label>
                <button type="button" class="btn btn-danger btn-sm remove-promo-button w-100" title="Remove">
                    <i class="fa fa-trash"></i>
                </button>
            </div>
        </div>
    </div>
</div>