<div class="row">
    <div class="col-md-8">
        <div class="form-group mb-3">
            <label for="value">
                Value <span class="text-danger">*</span>
            </label>

            <input
                type="text"
                name="value"
                id="value"
                class="form-control @error('value') is-invalid @enderror"
                placeholder="Enter attribute value"
                value="{{ old('value', $value->value ?? '') }}"
                required
            >

            @error('value')
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
                <option
                    value="1"
                    @selected(old('status', $value->status ?? 1) == 1)
                >
                    Active
                </option>

                <option
                    value="0"
                    @selected(old('status', $value->status ?? 1) == 0)
                >
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

    <div class="col-md-2">
        <div class="form-group mb-3">
            <label for="sort_order">
                Sort Order
            </label>

            <input
                type="number"
                name="sort_order"
                id="sort_order"
                min="0"
                class="form-control @error('sort_order') is-invalid @enderror"
                placeholder="0"
                value="{{ old('sort_order', $value->sort_order ?? 0) }}"
            >

            @error('sort_order')
                <div class="invalid-feedback">
                    {{ $message }}
                </div>
            @enderror
        </div>
    </div>
</div>