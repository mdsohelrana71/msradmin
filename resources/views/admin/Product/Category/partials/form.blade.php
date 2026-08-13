<div class="row g-3">

    {{-- Name --}}
    <div class="col-md-6">
        <div class="form-group">
            <label for="name">
                Category Name
                <span class="text-danger">*</span>
            </label>
            <input
                type="text"
                name="name"
                id="name"
                class="form-control @error('name') is-invalid @enderror"
                value="{{ old('name', $category->name ?? '') }}"
                placeholder="Enter category name"
                required>

            @error('name')
            <div class="invalid-feedback">
                {{ $message }}
            </div>
            @enderror
        </div>
    </div>
    {{-- Status --}}
    <div class="col-md-3">
        <div class="form-group">
            <label for="status">
                Status
            </label>
            <select
                name="status"
                id="status"
                class="form-select">
                <option
                    value="1"
                    {{ old(
                        'status',
                        $category->status ?? 1
                    ) == 1 ? 'selected' : '' }}>
                    Active
                </option>
                <option
                    value="0"
                    {{ old(
                        'status',
                        $category->status ?? 1
                    ) == 0 ? 'selected' : '' }}>
                    Inactive
                </option>
            </select>
        </div>
    </div>

    {{-- Sort Order --}}
    <div class="col-md-3">
        <div class="form-group">
            <label for="sort_order">
                Sort Order
            </label>
            <input
                type="number"
                name="sort_order"
                id="sort_order"
                class="form-control"
                value="{{ old(
                    'sort_order',
                    $category->sort_order ?? 0
                ) }}"
                min="0">
        </div>
    </div>
    <div class="col-md-12">
        <div class="form-group">
            <label class="form-label">
                Parent Category
            </label>
            <div class="category-selector border rounded">
                {{-- No Parent --}}
                <label class="category-option-row">
                    <span class="category-option">
                        <input
                            type="radio"
                            name="parent_id"
                            value=""
                            {{ empty($selectedParent) ? 'checked' : '' }}>
                        <span class="category-check"></span>
                        <span class="category-name">
                            No Parent
                        </span>
                    </span>
                </label>

                {{-- Category Tree --}}
                @include(
                'admin.Blog.Category.partials.parent-tree',
                [
                'categories' => $categories,
                'selectedParent' => $selectedParent,
                'excludedIds' => $excludedIds,
                ]
                )
            </div>
            @error('parent_id')
            <div class="text-danger mt-2">
                {{ $message }}
            </div>
            @enderror
        </div>
    </div>
</div>