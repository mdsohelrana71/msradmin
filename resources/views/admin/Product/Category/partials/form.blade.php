<div class="row g-3">

    {{-- Name --}}
    <div class="col-md-8">

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
                required
            >

            @error('name')
                <div class="invalid-feedback">
                    {{ $message }}
                </div>
            @enderror

        </div>

    </div>


    {{-- Parent --}}
    <div class="col-md-4">

        <div class="form-group">

            <label for="parent_id">
                Parent Category
            </label>

            <select
                name="parent_id"
                id="parent_id"
                class="form-select @error('parent_id') is-invalid @enderror"
            >

                <option value="">
                    No Parent
                </option>

                @foreach ($categories as $item)

                    <option
                        value="{{ $item->id }}"
                        {{ old(
                            'parent_id',
                            $category->parent_id ?? ''
                        ) == $item->id ? 'selected' : '' }}
                    >
                        {{ $item->name }}
                    </option>

                @endforeach

            </select>

            @error('parent_id')
                <div class="invalid-feedback">
                    {{ $message }}
                </div>
            @enderror

        </div>

    </div>


    {{-- Status --}}
    <div class="col-md-4">

        <div class="form-group">

            <label for="status">
                Status
            </label>

            <select
                name="status"
                id="status"
                class="form-select"
            >

                <option
                    value="1"
                    {{ old(
                        'status',
                        $category->status ?? 1
                    ) == 1 ? 'selected' : '' }}
                >
                    Active
                </option>

                <option
                    value="0"
                    {{ old(
                        'status',
                        $category->status ?? 1
                    ) == 0 ? 'selected' : '' }}
                >
                    Inactive
                </option>

            </select>

        </div>

    </div>


    {{-- Sort Order --}}
    <div class="col-md-4">

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
                min="0"
            >

        </div>

    </div>

</div>