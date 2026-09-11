<div class="container pb-1 pt-4">
    <!-- Breadcrumb -->
    <nav aria-label="breadcrumb" class="mb-3">
        <ol class="breadcrumb small mb-0">
            <li class="breadcrumb-item">
                <a href="{{ route('home') }}" class="text-muted text-decoration-none">Home</a>
            </li>
            <li class="breadcrumb-item">
                <a href="{{ route('products.index') }}" class="text-muted text-decoration-none">Products</a>
            </li>
            @if($product->category)
                <li class="breadcrumb-item">
                    <a href="{{ route('products.index', ['category' => [$product->category->slug]]) }}" class="text-muted text-decoration-none">
                        {{ $product->category->name }}
                    </a>
                </li>
            @endif
            <li class="breadcrumb-item active">{{ $product->name }}</li>
        </ol>
    </nav>

    <div class="row g-4">
        <!-- Images Section -->
        <div class="col-lg-7">
            @php
                $colorAttribute = $variants->firstWhere('attribute_slug', 'color');

                $colorImages = collect();

                if ($isVariantProduct && $colorAttribute) {
                    $colorImages = $variants
                        ->where('attribute_id', $colorAttribute->attribute_id)
                        ->filter(fn ($variant) => !empty($variant->variant_image))
                        ->groupBy('attribute_value_id')
                        ->map(function ($items) {
                            return $items->first();
                        })
                        ->values();
                }

                $defaultImage = $colorImages->isNotEmpty()
                    ? asset('storage/' . $colorImages->first()->variant_image)
                    : ($product->images?->count()
                        ? asset('storage/' . $product->images->first()->image)
                        : ($product->thumbnail
                            ? asset('storage/' . $product->thumbnail)
                            : asset('frontend/images/p-1.jpg')));
            @endphp

            <div class="product-image-viewer d-flex gap-3">
                <div class="thumbnails d-flex flex-column gap-3" id="productThumbnails">
                    @if($isVariantProduct && $colorImages->count())
                        @foreach($colorImages as $colorImage)
                            <img src="{{ asset('storage/' . $colorImage->variant_image) }}"
                                alt="{{ $product->name }} - {{ $colorImage->attribute_value }}"
                                class="thumbnail {{ $loop->first ? 'active' : '' }}"
                                data-color-value-id="{{ $colorImage->attribute_value_id }}"
                                data-variant-image="{{ $colorImage->variant_image }}"
                                onclick="changeImage(this)">
                        @endforeach
                    @elseif($product->images?->count())
                        @foreach($product->images as $image)
                            <img src="{{ asset('storage/' . $image->image) }}"
                                alt="{{ $product->name }}"
                                class="thumbnail {{ $loop->first ? 'active' : '' }}"
                                onclick="changeImage(this)">
                        @endforeach
                    @elseif($product->thumbnail)
                        <img src="{{ asset('storage/' . $product->thumbnail) }}"
                            alt="{{ $product->name }}"
                            class="thumbnail active"
                            onclick="changeImage(this)">
                    @else
                        <img src="{{ asset('frontend/images/p-1.jpg') }}"
                            alt="{{ $product->name }}"
                            class="thumbnail active"
                            onclick="changeImage(this)">
                    @endif
                </div>

                <div class="main-image-wrapper grow d-flex justify-content-center align-items-start">
                    <div class="main-image-container position-relative overflow-hidden"
                        id="mainImageContainer"
                        onmousemove="zoomImage(event)"
                        onmouseleave="resetZoom">
                        <img id="mainImage"
                            src="{{ $defaultImage }}"
                            alt="{{ $product->name }}"
                            class="main-product-image">
                    </div>
                </div>
            </div>
        </div>

        <!-- Product Info -->
        <div class="col-lg-5">
            <h1 class="h6 fw-semibold mb-2">{{ $product->name }}</h1>

            <div class="d-flex align-items-center gap-2 my-2">
                <span class="fs-6 fw-bold" id="productPrice">
                    ৳ {{ number_format($isVariantProduct ? ($variants->first()->price ?? 0) : $product->selling_price, 2) }}
                </span>

                <span id="productOldPrice"
                    class="text-muted small {{ $isVariantProduct ? (($variants->first()->discount_price ?? null) ? '' : 'd-none') : (($product->discount_price ?? null) ? '' : 'd-none') }}">
                    @if($isVariantProduct)
                        @if($variants->first()?->discount_price)
                            <del>৳ {{ number_format($variants->first()->discount_price, 2) }}</del>
                        @endif
                    @elseif($product->discount_price)
                        <del>৳ {{ number_format($product->discount_price, 2) }}</del>
                    @endif
                </span>

                <span class="text-muted small">+ VAT</span>
            </div>

            <p class="fw-medium small mb-3 d-flex align-items-center gap-2">
                SKU:
                <span class="text-muted small" id="skuNumber">
                    {{ $isVariantProduct ? ($variants->first()->variant_sku ?? $product->sku ?? '—') : ($product->sku ?? '—') }}
                </span>
                <button onclick="copySKU()" class="btn btn-link p-0 ms-1 copy-btn" title="Copy SKU">
                    <i class="fa-solid fa-copy"></i>
                </button>
            </p>

            <!-- Variants -->
            @if($isVariantProduct && $variants->count())
                @php
                    $attributeGroups = $variants->groupBy('attribute_id');
                @endphp

                @foreach($attributeGroups as $attributeId => $attributeVariants)
                    @php
                        $firstAttribute = $attributeVariants->first();
                        $attributeValues = $attributeVariants->unique('attribute_value_id');
                    @endphp

                    <div class="mb-3 variant-group" data-attribute-id="{{ $attributeId }}">
                        <div class="d-flex align-items-center justify-content-between">
                            <p class="fw-medium small mb-0">
                                {{ $firstAttribute->attribute_name }}:
                            </p>

                            @if(strtolower($firstAttribute->attribute_slug) === 'size')
                                <button onclick="showSizeChart()"
                                    class="btn btn-link text-decoration-none p-0 small fw-medium text-orange">
                                    <i class="fa-solid fa-ruler-combined"></i> Size Chart
                                </button>
                            @endif
                        </div>

                        <div class="d-flex gap-2 flex-wrap mt-2">
                            @foreach($attributeValues as $attributeValue)
                                @php
                                    $valueVariant = $attributeVariants->firstWhere('attribute_value_id', $attributeValue->attribute_value_id);
                                @endphp

                                <button type="button"
                                    class="size-btn btn btn-sm"
                                    data-attribute-id="{{ $attributeId }}"
                                    data-attribute-value-id="{{ $attributeValue->attribute_value_id }}"
                                    onclick="selectVariantValue(this)">
                                    {{ $attributeValue->attribute_value }}
                                </button>
                            @endforeach
                        </div>
                    </div>
                @endforeach
            @endif

            <!-- Stock -->
            <div class="small mb-3" id="stockStatus">
                @if($isVariantProduct)
                    @if($variants->first()?->available_stock > 0)
                        <span class="text-success">In Stock</span>
                    @else
                        <span class="text-danger">Out of Stock</span>
                    @endif
                @elseif($productStock > 0)
                    <span class="text-success">In Stock</span>
                @else
                    <span class="text-danger">Out of Stock</span>
                @endif
            </div>

            <!-- Buttons -->
            <div class="row buttons-container">
                <div class="col-12 col-lg-6">
                    <button onclick="addToCart()"
                        id="addToCartButton"
                        class="btn add-to-cart w-100 py-2 fw-medium"
                        disabled>
                        <i class="fas fa-shopping-cart"></i>
                        Add to cart
                    </button>
                </div>

                <div class="col-12 col-lg-6">
                    <button onclick="checkAvailability()" class="btn trial-room w-100 py-2 fw-medium">
                        <i class="fa-solid fa-shirt"></i>
                        Trial Room
                    </button>
                </div>
            </div>

            <div class="mt-3 product-description">
                <p class="small">
                    {!! $product->description ?? '' !!}
                </p>
            </div>

            <!-- Check Store Availability -->
            <div class="row g-3 buttons-container">
                <div class="col-12">
                    <button onclick="checkStoreAvailability()"
                        class="btn btn-outline check-availability w-100 py-2 d-flex align-items-center justify-content-between">
                        <div class="d-flex align-items-center gap-2">
                            <i class="fa-solid fa-store"></i>
                            <span>Check Store Availability</span>
                        </div>
                        <i class="fa-solid fa-right-long"></i>
                    </button>
                </div>
            </div>

            <!-- Collapse Sections -->
            <div class="mt-4">
                <div class="custom-collapse">
                    <div class="collapse-header" onclick="toggleCollapse(this)">
                        <span>Product Info</span>
                        <i class="fa-solid fa-chevron-down"></i>
                    </div>

                    <div class="collapse-content show">
                        <p class="small">
                            Product colour may slightly vary, depending on your device's screen resolution.<br><br>
                            Free shipping at ৳8000 purchase.
                        </p>
                    </div>
                </div>

                <div class="custom-collapse">
                    <div class="collapse-header" onclick="toggleCollapse(this)">
                        <span>Product Details</span>
                        <i class="fa-solid fa-chevron-down"></i>
                    </div>

                    <div class="collapse-content">
                        <div class="row small">
                            @if($product->unit)
                                <div class="col-6 mb-2">
                                    <strong>Unit:</strong> {{ $product->unit }}
                                </div>
                            @endif

                            @if($product->weight)
                                <div class="col-6 mb-2">
                                    <strong>Weight:</strong> {{ $product->weight }}
                                </div>
                            @endif

                            @if($product->category)
                                <div class="col-6 mb-2">
                                    <strong>Category:</strong> {{ $product->category->name }}
                                </div>
                            @endif

                            @if($product->brand)
                                <div class="col-6 mb-2">
                                    <strong>Brand:</strong> {{ $product->brand->name }}
                                </div>
                            @endif

                            @if($product->sku)
                                <div class="col-6 mb-2">
                                    <strong>SKU:</strong> {{ $product->sku }}
                                </div>
                            @endif

                            @if($product->barcode)
                                <div class="col-6 mb-2">
                                    <strong>Barcode:</strong> {{ $product->barcode }}
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Similar Products -->
<div class="container-fluid px-4 px-md-5 pb-5 py-4">
    <div class="row g-3 g-lg-4">
        <h2 class="products-section-title">Similar Products</h2>

        @forelse($similarProducts ?? [] as $similarProduct)
            <div class="col-6 col-md-3 col-lg-2">
                @include($productCardView, ['product' => $similarProduct])
            </div>
        @empty
        @endforelse
    </div>
</div>

<!-- Size Chart Modal -->
<div class="modal fade" id="sizeChartModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
            <div class="modal-header pb-2">
                <h5 class="modal-title fw-semibold">Size Chart</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <div class="modal-body p-3 p-md-4">
                <div class="table-responsive">
                    <table class="table table-bordered mb-0 text-center align-middle">
                        <thead class="table-light">
                            <tr>
                                <th style="min-width: 130px;">Size Name (Inch.)</th>
                                <th>32</th>
                                <th>34</th>
                                <th>36</th>
                                <th>38</th>
                                <th>40</th>
                                <th>42</th>
                                <th>44</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td><strong>Shoulder</strong></td>
                                <td>13.5</td>
                                <td>14</td>
                                <td>14.5</td>
                                <td>15</td>
                                <td>15.5</td>
                                <td>16</td>
                                <td>16.5</td>
                            </tr>
                            <tr>
                                <td><strong>Bust</strong></td>
                                <td>35</td>
                                <td>37</td>
                                <td>39</td>
                                <td>41</td>
                                <td>43</td>
                                <td>45</td>
                                <td>47</td>
                            </tr>
                            <tr>
                                <td><strong>Waist</strong></td>
                                <td>32</td>
                                <td>34</td>
                                <td>36</td>
                                <td>38</td>
                                <td>40</td>
                                <td>42</td>
                                <td>43</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Check Store Modal -->
<div class="modal fade check-store-modal" id="checkStoreModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered custom-modal">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title fw-semibold">Store Availability</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <div class="modal-body p-3 p-md-3">
                <div class="container">
                    <div class="row align-items-start">
                        <p class="fw-medium d-block d-md-none">Please select variant</p>

                        <div class="col-4">
                            <p class="fw-medium d-none d-md-block">Please select variant</p>

                            <div class="size-list">
                                @if($isVariantProduct && $variants->count())
                                    @foreach($variants->groupBy('variant_id') as $variantId => $variantItems)
                                        @php
                                            $variant = $variantItems->first();
                                            $variantLabel = $variantItems->pluck('attribute_value')->unique()->implode(' / ');
                                        @endphp

                                        <label>
                                            <input class="form-check-input"
                                                type="radio"
                                                name="variant"
                                                value="{{ $variantId }}">
                                            {{ $variantLabel }}
                                        </label>
                                    @endforeach
                                @endif
                            </div>
                        </div>

                        <div class="col-8">
                            @if($product->images?->count())
                                <img loading="lazy"
                                    width="189"
                                    height="217"
                                    decoding="async"
                                    src="{{ asset('storage/' . $product->images->first()->image) }}"
                                    alt="{{ $product->name }}"
                                    class="img-fluid rounded shadow-sm"
                                    style="max-height: 480px; object-fit: contain;">
                            @elseif($product->thumbnail)
                                <img loading="lazy"
                                    width="189"
                                    height="217"
                                    decoding="async"
                                    src="{{ asset('storage/' . $product->thumbnail) }}"
                                    alt="{{ $product->name }}"
                                    class="img-fluid rounded shadow-sm"
                                    style="max-height: 480px; object-fit: contain;">
                            @else
                                <img loading="lazy"
                                    width="189"
                                    height="217"
                                    decoding="async"
                                    src="{{ asset('frontend/images/p-1.jpg') }}"
                                    alt="{{ $product->name }}"
                                    class="img-fluid rounded shadow-sm"
                                    style="max-height: 480px; object-fit: contain;">
                            @endif
                        </div>
                    </div>

                    <div class="shop-info" id="shopInfo">
                        <div class="table-responsive">
                            <table class="table table-bordered mb-0 text-start align-middle">
                                <thead class="table-success">
                                    <tr>
                                        <th style="min-width: 80px;">Shop</th>
                                        <th>Address</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>Banasree</td>
                                        <td>H ? 5, Block ? E, Main Road, Near by National Ideal School & College, Banasree, Rampura, Dhaka. Mobile 01847189614</td>
                                    </tr>
                                    <tr>
                                        <td>Mirpur</td>
                                        <td>Multiplan Red Crescent City, Level 2, Mirpur 1. Mobile 01811456051</td>
                                    </tr>
                                    <tr>
                                        <td>Cumilla</td>
                                        <td>Silver Rahman Villa (2nd Floor) 567 Nazrul Avenue, Kandirpar, Cumilla Sadar Cumilla- 3500</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
