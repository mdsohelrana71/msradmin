@extends('frontend.layouts.app')

@section('title', $product->name . ' - NICK')

@push('styles')
    <link rel="stylesheet" href="{{ app(\App\Services\Frontend\DesignManager::class)->getTemplateCss('product-details') }}">
    <link rel="stylesheet" href="{{ app(\App\Services\Frontend\DesignManager::class)->getSectionCss('product_details') }}">
    <link rel="stylesheet" href="{{ app(\App\Services\Frontend\DesignManager::class)->getSectionCss('product_card') }}">
@endpush

@section('content')
    @include($productDetailsView, [
        'product' => $product,
        'similarProducts' => $similarProducts,
        'productCardView' => $productCardView,
        'isVariantProduct' => $isVariantProduct,
        'productStock' => $productStock,
        'variants' => $variants,
    ])
@endsection

<script>
    const productData = {
        id: @json($product->id),
        isVariantProduct: @json($isVariantProduct),
        basePrice: @json((float) $product->selling_price),
        baseDiscountPrice: @json($product->discount_price ? (float) $product->discount_price : null),
        baseStock: @json((int) $productStock),
        baseSku: @json($product->sku),
        variants: @json($variants->values()),
    };

    let selectedVariant = null;
    let selectedValues = {};

    document.addEventListener('DOMContentLoaded', function () {
        const imageContainer = document.getElementById('mainImageContainer');

        if (imageContainer) {
            imageContainer.addEventListener('mousemove', zoomImage);
            imageContainer.addEventListener('mouseleave', resetZoom);
        }

        if (productData.isVariantProduct) {
            initializeVariants();
        } else {
            updateSingleProductState();
        }
    });

    function initializeVariants() {
        selectedVariant = null;
        selectedValues = {};

        document.querySelectorAll('.variant-group .size-btn').forEach(button => {
            button.classList.remove('active');
            button.disabled = false;
            button.classList.remove('disabled');
        });

        updateVariantState(null);
        updateAvailableOptions();
    }

    function selectVariantValue(button) {
        if (!button || button.disabled) {
            return;
        }

        const attributeId = String(button.dataset.attributeId);
        const attributeValueId = String(button.dataset.attributeValueId);

        document.querySelectorAll(
            `.variant-group[data-attribute-id="${attributeId}"] .size-btn`
        ).forEach(item => {
            item.classList.remove('active');
        });

        button.classList.add('active');

        selectedValues[attributeId] = attributeValueId;

        updateVariantSelection();
    }

    function updateVariantSelection() {
        selectedVariant = findMatchingVariant();

        if (selectedVariant) {
            updateVariantState(selectedVariant);
            updateVariantImage(selectedVariant);
        } else {
            updateVariantState(null);
        }

        updateAvailableOptions();
    }

    function findMatchingVariant() {
        const attributeGroups = getAttributeGroups();

        if (!attributeGroups.length) {
            return null;
        }

        const allAttributesSelected = attributeGroups.every(attributeId => {
            return Object.prototype.hasOwnProperty.call(
                selectedValues,
                attributeId
            );
        });

        if (!allAttributesSelected) {
            return null;
        }

        const variantMap = {};

        productData.variants.forEach(item => {
            const variantId = String(item.variant_id);

            if (!variantMap[variantId]) {
                variantMap[variantId] = [];
            }

            variantMap[variantId].push(item);
        });

        for (const variantId in variantMap) {
            const variantItems = variantMap[variantId];

            const isMatch = variantItems.every(item => {
                return String(selectedValues[item.attribute_id]) ===
                    String(item.attribute_value_id);
            });

            if (isMatch) {
                return variantItems[0];
            }
        }

        return null;
    }

    function getAttributeGroups() {
        return [
            ...new Set(
                productData.variants.map(item => String(item.attribute_id))
            )
        ];
    }

    function updateVariantState(variant) {
        const priceElement = document.getElementById('productPrice');
        const oldPriceElement = document.getElementById('productOldPrice');
        const skuElement = document.getElementById('skuNumber');
        const stockElement = document.getElementById('stockStatus');
        const addToCartButton = document.getElementById('addToCartButton');

        if (!priceElement || !oldPriceElement || !skuElement || !stockElement || !addToCartButton) {
            return;
        }

        if (!variant) {
            priceElement.textContent = '৳ 0.00';

            oldPriceElement.innerHTML = '';
            oldPriceElement.classList.add('d-none');

            skuElement.textContent = '—';

            const hasSelection = Object.keys(selectedValues).length > 0;

            stockElement.innerHTML = hasSelection
                ? '<span class="text-warning">Please select all variants</span>'
                : '<span class="text-muted">Please select variant</span>';

            addToCartButton.disabled = true;

            return;
        }

        const price = parseFloat(variant.price || 0);
        const discountPrice = variant.discount_price
            ? parseFloat(variant.discount_price)
            : null;
        const stock = parseInt(variant.available_stock || 0);

        priceElement.textContent = `৳ ${formatPrice(price)}`;

        if (discountPrice !== null && discountPrice > 0) {
            oldPriceElement.innerHTML =
                `<del>৳ ${formatPrice(discountPrice)}</del>`;

            oldPriceElement.classList.remove('d-none');
        } else {
            oldPriceElement.innerHTML = '';
            oldPriceElement.classList.add('d-none');
        }

        skuElement.textContent = variant.variant_sku || '—';

        if (stock > 0) {
            stockElement.innerHTML =
                '<span class="text-success">In Stock</span>';

            addToCartButton.disabled = false;
        } else {
            stockElement.innerHTML =
                '<span class="text-danger">Out of Stock</span>';

            addToCartButton.disabled = true;
        }
    }

    function updateAvailableOptions() {
        document.querySelectorAll('.variant-group').forEach(group => {
            const attributeId = String(group.dataset.attributeId);

            group.querySelectorAll('.size-btn').forEach(button => {
                const valueId = String(button.dataset.attributeValueId);

                const possible = isOptionAvailable(
                    attributeId,
                    valueId
                );

                button.disabled = !possible;
                button.classList.toggle('disabled', !possible);

                if (
                    !possible &&
                    String(selectedValues[attributeId]) === valueId
                ) {
                    delete selectedValues[attributeId];
                    button.classList.remove('active');
                }
            });
        });

        syncSelectedButtons();
    }

    function isOptionAvailable(attributeId, valueId) {
        const matchingVariantIds = [
            ...new Set(
                productData.variants
                    .filter(item =>
                        String(item.attribute_id) === attributeId &&
                        String(item.attribute_value_id) === valueId
                    )
                    .map(item => String(item.variant_id))
            )
        ];

        if (!matchingVariantIds.length) {
            return false;
        }

        return matchingVariantIds.some(variantId => {
            const variantItems = productData.variants.filter(item =>
                String(item.variant_id) === variantId
            );

            const compatible = variantItems.every(item => {
                const itemAttributeId = String(item.attribute_id);
                const itemValueId = String(item.attribute_value_id);

                if (itemAttributeId === attributeId) {
                    return itemValueId === valueId;
                }

                if (
                    !Object.prototype.hasOwnProperty.call(
                        selectedValues,
                        itemAttributeId
                    )
                ) {
                    return true;
                }

                return String(selectedValues[itemAttributeId]) === itemValueId;
            });

            if (!compatible) {
                return false;
            }

            return variantItems.some(item =>
                parseInt(item.available_stock || 0) > 0
            );
        });
    }

    function syncSelectedButtons() {
        document.querySelectorAll('.variant-group').forEach(group => {
            const attributeId = String(group.dataset.attributeId);
            const selectedValue = selectedValues[attributeId];

            group.querySelectorAll('.size-btn').forEach(button => {
                const valueId = String(button.dataset.attributeValueId);

                button.classList.toggle(
                    'active',
                    String(selectedValue) === valueId
                );
            });
        });
    }

    function updateVariantImage(variant) {
        if (!variant) {
            return;
        }

        const image = document.getElementById('mainImage');
        const thumbnails = document.getElementById('productThumbnails');

        if (!image || !thumbnails) {
            return;
        }

        if (variant.variant_image) {
            image.src = "{{ asset('storage') }}/" + variant.variant_image;
        }

        const colorAttribute = productData.variants.find(item =>
            String(item.attribute_slug).toLowerCase() === 'color'
        );

        if (!colorAttribute) {
            return;
        }

        const colorValueId = String(
            productData.variants.find(item =>
                String(item.variant_id) === String(variant.variant_id) &&
                String(item.attribute_slug).toLowerCase() === 'color'
            )?.attribute_value_id || ''
        );

        if (!colorValueId) {
            return;
        }

        document.querySelectorAll('#productThumbnails .thumbnail').forEach(thumbnail => {
            thumbnail.classList.toggle(
                'active',
                String(thumbnail.dataset.colorValueId) === colorValueId
            );
        });
    }

    function updateSingleProductState() {
        const stockElement = document.getElementById('stockStatus');
        const addToCartButton = document.getElementById('addToCartButton');

        if (!stockElement || !addToCartButton) {
            return;
        }

        if (productData.baseStock > 0) {
            stockElement.innerHTML =
                '<span class="text-success">In Stock</span>';

            addToCartButton.disabled = false;
        } else {
            stockElement.innerHTML =
                '<span class="text-danger">Out of Stock</span>';

            addToCartButton.disabled = true;
        }
    }

    function formatPrice(price) {
        return Number(price).toLocaleString('en-BD', {
            minimumFractionDigits: 2,
            maximumFractionDigits: 2
        });
    }

    function addToCart() {
        if (productData.isVariantProduct) {
            if (
                !selectedVariant ||
                parseInt(selectedVariant.available_stock || 0) <= 0
            ) {
                return;
            }

            console.log('Add variant to cart:', {
                product_id: productData.id,
                variant_id: selectedVariant.variant_id,
                quantity: 1
            });

            return;
        }

        if (productData.baseStock <= 0) {
            return;
        }

        console.log('Add product to cart:', {
            product_id: productData.id,
            quantity: 1
        });
    }

    function checkAvailability() {
        const modal = document.getElementById('checkStoreModal');

        if (modal) {
            bootstrap.Modal.getOrCreateInstance(modal).show();
        }
    }

    function checkStoreAvailability() {
        const modal = document.getElementById('checkStoreModal');

        if (modal) {
            bootstrap.Modal.getOrCreateInstance(modal).show();
        }
    }

    function showSizeChart() {
        const modal = document.getElementById('sizeChartModal');

        if (modal) {
            bootstrap.Modal.getOrCreateInstance(modal).show();
        }
    }

    function copySKU() {
        const sku = document.getElementById('skuNumber')?.textContent.trim();

        if (!sku || sku === '—') {
            return;
        }

        navigator.clipboard.writeText(sku);
    }

    function changeImage(element) {
        const mainImage = document.getElementById('mainImage');

        if (!mainImage || !element) {
            return;
        }

        mainImage.src = element.src;

        document.querySelectorAll('.thumbnail').forEach(thumbnail => {
            thumbnail.classList.remove('active');
        });

        element.classList.add('active');
    }

    function zoomImage(event) {
        const container = document.getElementById('mainImageContainer');
        const image = document.getElementById('mainImage');

        if (!container || !image) {
            return;
        }

        const rect = container.getBoundingClientRect();
        const x = ((event.clientX - rect.left) / rect.width) * 100;
        const y = ((event.clientY - rect.top) / rect.height) * 100;

        image.style.transformOrigin = `${x}% ${y}%`;
        image.style.transform = 'scale(1.5)';
    }

    function resetZoom() {
        const image = document.getElementById('mainImage');

        if (!image) {
            return;
        }

        image.style.transformOrigin = 'center center';
        image.style.transform = 'scale(1)';
    }

    function toggleCollapse(element) {
        const content = element.nextElementSibling;

        if (!content) {
            return;
        }

        content.classList.toggle('show');

        const icon = element.querySelector('i');

        if (icon) {
            icon.classList.toggle('fa-chevron-down');
            icon.classList.toggle('fa-chevron-up');
        }
    }
</script>
