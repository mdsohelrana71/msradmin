<div class="row">
    <div class="col-md-6">
        <div class="form-group mb-3">
            <label for="name">
                Brand Name <span class="text-danger">*</span>
            </label>

            <input
                type="text"
                name="name"
                id="name"
                class="form-control @error('name') is-invalid @enderror"
                placeholder="Enter brand name"
                value="{{ old('name', $brand->name ?? '') }}"
                required
            >

            @error('name')
                <div class="invalid-feedback">
                    {{ $message }}
                </div>
            @enderror
        </div>
    </div>

    <div class="col-md-4">
        <div class="form-group mb-3">
            <label for="logo">
                Logo
            </label>

            <input
                type="file"
                name="logo"
                id="logo"
                class="form-control @error('logo') is-invalid @enderror"
                accept="image/jpeg,image/png,image/webp"
            >

            @error('logo')
                <div class="invalid-feedback">
                    {{ $message }}
                </div>
            @enderror

            @if (!empty($brand?->logo))
                <div class="mt-2">
                    <img
                        src="{{ asset('storage/' . $brand->logo) }}"
                        alt="{{ $brand->name }}"
                        class="rounded border"
                        style="width: 80px; height: 60px; object-fit: contain;"
                    >
                </div>
            @endif
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
                <option value="1"
                    @selected(old('status', $brand->status ?? 1) == 1)>
                    Active
                </option>

                <option value="0"
                    @selected(old('status', $brand->status ?? 1) == 0)>
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
                rows="5"
                class="form-control @error('description') is-invalid @enderror"
                placeholder="Enter brand description"
            >{{ old('description', $brand->description ?? '') }}</textarea>

            @error('description')
                <div class="invalid-feedback">
                    {{ $message }}
                </div>
            @enderror
        </div>
    </div>
</div>