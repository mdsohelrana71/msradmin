<div class="row">
    <div class="col-lg-8">
        <div class="card border shadow-none mb-4">
            <div class="card-header">
                <h5 class="card-title mb-0">Product Content</h5>
            </div>

            <div class="card-body">
                <div class="form-group mb-3">
                    <label for="name">
                        Product Name <span class="text-danger">*</span>
                    </label>

                    <input type="text" name="name" id="name"
                        class="form-control @error('name') is-invalid @enderror"
                        value="{{ old('name', $product->name ?? '') }}" placeholder="Enter product name" required>

                    @error('name')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group mb-3">
                            <label for="sku">
                                SKU <span class="text-danger">*</span>
                            </label>

                            <input type="text" name="sku" id="sku"
                                class="form-control @error('sku') is-invalid @enderror"
                                value="{{ old('sku', $product->sku ?? '') }}" placeholder="Enter product SKU" required>

                            @error('sku')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="form-group mb-3">
                            <label for="barcode">Barcode</label>

                            <input type="text" name="barcode" id="barcode"
                                class="form-control @error('barcode') is-invalid @enderror"
                                value="{{ old('barcode', $product->barcode ?? '') }}" placeholder="Enter barcode">

                            @error('barcode')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>

                <div class="form-group mb-3">
                    <label for="short_description">
                        Short Description
                    </label>

                    <textarea name="short_description" id="short_description" rows="4"
                        class="form-control @error('short_description') is-invalid @enderror"
                        placeholder="Write a short description of the product...">{{ old('short_description', $product->short_description ?? '') }}</textarea>

                    @error('short_description')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group mb-3">
                    <label for="description">
                        Description
                    </label>

                    <textarea name="description" id="description" class="form-control" rows="15">{{ old('description', $product->description ?? '') }}</textarea>

                    @error('description')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>
        </div>
        <div class="card border shadow-none mb-4">
            <div class="card-header">
                <h5 class="card-title mb-0">Product Pricing</h5>
            </div>

            <div class="card-body">
                <div class="row">
                    <div class="col-md-4">
                        <div class="form-group mb-0">
                            <label for="cost_price">
                                Cost Price <span class="text-danger">*</span>
                            </label>

                            <input type="number" name="cost_price" id="cost_price" min="0" step="0.01"
                                class="form-control @error('cost_price') is-invalid @enderror"
                                value="{{ old('cost_price', $product->cost_price ?? 0) }}" placeholder="0.00" required>

                            @error('cost_price')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="form-group mb-0">
                            <label for="selling_price">
                                Selling Price <span class="text-danger">*</span>
                            </label>

                            <input type="number" name="selling_price" id="selling_price" min="0" step="0.01"
                                class="form-control @error('selling_price') is-invalid @enderror"
                                value="{{ old('selling_price', $product->selling_price ?? '') }}" placeholder="0.00"
                                required>

                            @error('selling_price')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="form-group mb-0">
                            <label for="discount_price">
                                Discount Price
                            </label>

                            <input type="number" name="discount_price" id="discount_price" min="0"
                                step="0.01" class="form-control @error('discount_price') is-invalid @enderror"
                                value="{{ old('discount_price', $product->discount_price ?? '') }}" placeholder="0.00">

                            @error('discount_price')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="card border shadow-none mb-4">
            <div class="card-header">
                <h5 class="card-title mb-0">Product Specifications</h5>
            </div>

            <div class="card-body">
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group mb-0">
                            <label for="unit">
                                Unit <span class="text-danger">*</span>
                            </label>

                            <input type="text" name="unit" id="unit"
                                class="form-control @error('unit') is-invalid @enderror"
                                value="{{ old('unit', $product->unit ?? 'pcs') }}" placeholder="pcs" required>

                            @error('unit')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="form-group mb-0">
                            <label for="weight">
                                Weight
                            </label>

                            <input type="number" name="weight" id="weight" min="0" step="0.01"
                                class="form-control @error('weight') is-invalid @enderror"
                                value="{{ old('weight', $product->weight ?? '') }}" placeholder="Enter weight">

                            @error('weight')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="card border shadow-none mb-4">
            <div class="card-header">
                <h5 class="card-title mb-0">Product Gallery</h5>
            </div>

            <div class="card-body text-center">
                <div id="product-gallery" class="row g-3 mb-3">
                    @if (!empty($product?->images) && $product->images->count())
                        @foreach ($product->images as $image)
                            <div class="col-6">
                                <div class="gallery-item border rounded-3 p-3 bg-light bg-opacity-50"
                                    data-image-id="{{ $image->id }}">
                                    <div class="row g-3 align-items-center">
                                        {{-- Image Preview --}}
                                        <div class="col-auto">
                                            <div class="position-relative">
                                                <img src="{{ asset('storage/' . $image->image) }}"
                                                    alt="{{ $image->alt ?? $product->name }}"
                                                    class="rounded-3 border" width="100" height="100"
                                                    style="object-fit: cover;">
                                            </div>
                                        </div>

                                        {{-- Alt Text --}}
                                        <div class="col">
                                            <input type="hidden" name="image_order[]" value="{{ $image->id }}">

                                            <div class="mb-0">
                                                <label class="form-label small text-muted mb-1">
                                                    Alt Text
                                                </label>
                                                <input type="text"
                                                    name="existing_images[{{ $image->id }}][alt]"
                                                    value="{{ old("existing_images.{$image->id}.alt", $image->alt) }}"
                                                    class="form-control form-control-sm"
                                                    placeholder="Enter image alt text">
                                            </div>
                                        </div>

                                        {{-- Remove Button --}}
                                        <div class="col-auto">
                                            <button type="button"
                                                class="btn btn-outline-danger btn-sm remove-existing-gallery-image"
                                                data-image-id="{{ $image->id }}" title="Remove image">
                                                <i class="fa fa-trash"></i>
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    @else
                        <div class="col-12">
                            <div class="text-center py-4 text-muted">
                                <i class="fa fa-image fa-2x mb-2 opacity-50"></i>
                                <p class="mb-0 small">No gallery images added yet</p>
                            </div>
                        </div>
                    @endif
                </div>

                <div class="row" id="new-gallery-images"></div>

                <button type="button" id="add-gallery-image" class="btn btn-outline-primary btn-sm">
                    <i class="fa fa-plus me-1"></i>
                    Add Gallery Image
                </button>

                <small class="text-muted d-block mt-2">
                    You can upload multiple gallery images.
                </small>

                @error('images')
                    <div class="text-danger small mt-2">
                        {{ $message }}
                    </div>
                @enderror
            </div>
        </div>
    </div>

    <div class="col-lg-4">
        <div class="card border shadow-none mb-4">
            <div class="card-header">
                <h5 class="card-title mb-0">Product Settings</h5>
            </div>

            <div class="card-body">
                <div class="form-group mb-3">
                    <label class="form-label">
                        Category <span class="text-danger">*</span>
                    </label>

                    @php
                        $selectedCategory = old('category_id', $product->category_id ?? null);
                    @endphp

                    <div class="category-tree">
                        @foreach ($categories->whereNull('parent_id') as $category)
                            @include('admin.Product.partials.category-tree', [
                                'category' => $category,
                                'selectedCategory' => $selectedCategory,
                            ])
                        @endforeach
                    </div>

                    @error('category_id')
                        <div class="text-danger small mt-2">
                            {{ $message }}
                        </div>
                    @enderror
                </div>

                <div class="form-group mb-3">
                    <label for="brand_id">
                        Brand
                    </label>

                    <select name="brand_id" id="brand_id"
                        class="form-select @error('brand_id') is-invalid @enderror">
                        <option value="">Select Brand</option>

                        @foreach ($brands as $brand)
                            <option value="{{ $brand->id }}" @selected(old('brand_id', $product->brand_id ?? null) == $brand->id)>
                                {{ $brand->name }}
                            </option>
                        @endforeach
                    </select>

                    @error('brand_id')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror
                </div>

                <div class="form-group mb-1">
                    <label for="tags">Tags</label>

                    <div class="form-control gap-2" id="tags-container" style="min-height: 45px; cursor: text;">
                        @foreach ($product->tags ?? [] as $tag)
                            <span class="badge bg-primary gap-1 tag-item">
                                {{ ucfirst($tag->name) }}

                                <button type="button" class="btn-close btn-close-white remove-tag"
                                    style="font-size: 8px;"></button>

                                <input type="hidden" name="tags[]" value="{{ $tag->id }}">
                            </span>
                        @endforeach

                        <input type="text" id="tag-input" class="border-0 outline-none grow"
                            placeholder="Type a tag and press Enter..." autocomplete="off"
                            style="min-width: 180px; outline: none;">
                    </div>

                    @error('tags')
                        <div class="invalid-feedback d-block">
                            {{ $message }}
                        </div>
                    @enderror
                </div>

                <div class="form-group mb-3">
                    <label for="status">Status</label>

                    <select name="status" id="status" class="form-select @error('status') is-invalid @enderror">
                        <option value="1" @selected(old('status', $product->status ?? true) == true)>
                            Active
                        </option>

                        <option value="0" @selected(old('status', $product->status ?? true) == false)>
                            Inactive
                        </option>
                    </select>

                    @error('status')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror
                </div>

                <div class="form-check">
                    <input type="checkbox" name="is_featured" value="1" id="is_featured"
                        class="form-check-input" @checked(old('is_featured', $product->is_featured ?? false))>

                    <label class="form-check-label" for="is_featured">
                        Featured Product
                    </label>
                </div>
            </div>
        </div>

        <div class="card border shadow-none mb-4">
            <div class="card-header">
                <h5 class="card-title mb-0">Product Thumbnail</h5>
                <p class="mb-0 small text-muted">
                    Main product image for listing & details.
                </p>
            </div>

            <div class="card-body">
                @if (!empty($product?->thumbnail))
                    <div class="mb-2">
                        <img src="{{ asset('storage/' . $product->thumbnail) }}" alt="{{ $product->name }}"
                            class="img-fluid rounded" style="max-height: 200px; object-fit: contain;">
                    </div>
                @endif

                <input type="file" name="thumbnail" id="thumbnail"
                    class="form-control @error('thumbnail') is-invalid @enderror"
                    accept="image/jpeg,image/png,image/webp">

                <small class="text-muted">
                    Recommended image format: JPG, PNG or WebP.
                </small>

                @error('thumbnail')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                @enderror
            </div>
        </div>

        <div class="card border shadow-none mb-4">
            <div class="card-header">
                <h5 class="card-title mb-0">Product SEO</h5>
            </div>

            <div class="card-body">
                <div class="form-group mb-1">
                    <label for="meta_title">Meta Title</label>
                    <input type="text" name="meta_title" id="meta_title"
                        class="form-control @error('meta_title') is-invalid @enderror"
                        value="{{ old('meta_title', $product->seo->meta_title ?? '') }}"
                        placeholder="Enter meta title">
                    @error('meta_title')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                <div class="form-group mb-1">
                    <label for="meta_description">Meta Description</label>
                    <textarea name="meta_description" id="meta_description"
                        class="form-control @error('meta_description') is-invalid @enderror"
                        rows="4"
                        placeholder="Enter meta description">{{ old('meta_description', $product->seo->meta_description ?? '') }}</textarea>
                    @error('meta_description')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                <div class="form-group mb-1">
                    <label for="meta_keywords">Meta Keywords</label>
                    <input type="text" name="meta_keywords" id="meta_keywords"
                        class="form-control @error('meta_keywords') is-invalid @enderror"
                        value="{{ old('meta_keywords', $product->seo->meta_keywords ?? '') }}"
                        placeholder="Enter meta keywords">
                    @error('meta_keywords')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                <div class="form-group mb-1">
                    <label for="canonical_url">Canonical URL</label>
                    <input type="url" name="canonical_url" id="canonical_url"
                        class="form-control @error('canonical_url') is-invalid @enderror"
                        value="{{ old('canonical_url', $product->seo->canonical_url ?? '') }}"
                        placeholder="https://example.com/product/example">
                    @error('canonical_url')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>
        </div>
    </div>
    
    <div class="col-12">
        <div class="card border mt-4 shadow-none">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h5 class="card-title mb-0">Product Variants</h5>

                <button type="button" id="generate-variants" class="btn btn-primary btn-sm">
                    <i class="fa fa-refresh me-1"></i>
                    Generate Variants
                </button>
            </div>

            <div class="card-body">
                @php
                    $assignedAttributeIds = collect($product?->attributeAssignments ?? [])
                        ->pluck('attribute_id')
                        ->map(fn($id) => (int) $id)
                        ->toArray();

                    $existingVariantValueIds = collect($product?->variants ?? [])
                        ->flatMap(function ($variant) {
                            return $variant->values->pluck('attribute_value_id');
                        })
                        ->map(fn($id) => (int) $id)
                        ->unique()
                        ->values()
                        ->toArray();
                @endphp

                <div class="form-group">
                    <label class="fw-semibold mb-3 form-label">
                        Attributes
                    </label>

                    <div class="row">
                        @foreach ($attributes as $attribute)
                            <div class="col-md-2 mb-3">
                                <div class="form-check">
                                    <input type="checkbox" name="attributes[]"
                                        class="form-check-input attribute-checkbox"
                                        id="attribute_{{ $attribute->id }}" value="{{ $attribute->id }}"
                                        data-name="{{ $attribute->name }}" @checked(collect($product?->attributeAssignments ?? [])->contains('attribute_id', $attribute->id))>

                                    <label class="form-check-label" for="attribute_{{ $attribute->id }}">
                                        {{ $attribute->name }}
                                    </label>
                                </div>
                            </div>
                        @endforeach
                    </div>

                    @error('attributes')
                        <div class="text-danger small mt-2">
                            {{ $message }}
                        </div>
                    @enderror
                </div>

                <div id="attribute-values-container"></div>

                <div id="variants-container" class="mt-4"></div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
    <script>
        window.productVariantData = {
            attributes: @json($attributes),
            existingVariants: @json($product?->variants ?? []),
        };
    </script>
    <script src="{{ asset('assets/js/variants.js') }}"></script>
    <script src="{{ asset('assets/js/product-images.js') }}"></script>
    <script src="{{ asset('assets/js/plugin/ckeditor.js') }}"></script>
    <script src="{{ asset('assets/js/tags.js') }}"></script>

    <script>
        ClassicEditor
            .create(document.querySelector('#description'))
            .catch(error => {
                console.error(error);
            });
    </script>
@endpush
