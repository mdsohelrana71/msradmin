$(document).ready(function () {
    const attributes = window.productVariantData?.attributes ?? [];
    const existingVariants =
        window.productVariantData?.existingVariants ?? [];
    const removedVariantIds = [];

    const existingVariantValueIds = existingVariants
        .flatMap(variant => variant.values || [])
        .map(value => Number(value.attribute_value_id));

    const valuesContainer = $('#attribute-values-container');
    const variantsContainer = $('#variants-container');

    function getSelectedAttributes() {
        return $('.attribute-checkbox:checked')
            .map(function () {
                return {
                    id: Number($(this).val()),
                    name: $(this).data('name'),
                };
            })
            .get();
    }

    function renderAttributeValues() {
        const selectedAttributes = getSelectedAttributes();

        valuesContainer.empty();

        selectedAttributes.forEach(attribute => {
            const data = attributes.find(
                item => Number(item.id) === Number(attribute.id)
            );

            if (!data) {
                return;
            }

            let html = `
                <div class="border rounded p-3 mb-3">
                    <div class="fw-semibold mb-3">
                        ${data.name}
                    </div>

                    <div class="row">
            `;

            data.values.forEach(value => {
                const isChecked = existingVariantValueIds.includes(
                    Number(value.id)
                );

                html += `
                    <div class="col-md-3 mb-2">
                        <div class="form-check">
                            <input
                                type="checkbox"
                                class="form-check-input attribute-value-checkbox"
                                data-attribute-id="${data.id}"
                                value="${value.id}"
                                id="attribute_value_${value.id}"
                                ${isChecked ? 'checked' : ''}
                            >

                            <label
                                class="form-check-label"
                                for="attribute_value_${value.id}"
                            >
                                ${value.value}
                            </label>
                        </div>
                    </div>
                `;
            });

            html += `
                    </div>
                </div>
            `;

            valuesContainer.append(html);
        });
    }

    $('.attribute-checkbox').on('change', function () {
        renderAttributeValues();
    });

    function getSelectedValues() {
        const result = {};

        $('.attribute-value-checkbox:checked').each(function () {
            const attributeId = $(this).data('attribute-id');

            if (!result[attributeId]) {
                result[attributeId] = [];
            }

            result[attributeId].push({
                id: Number($(this).val()),
                label: $(this)
                    .closest('.form-check')
                    .find('label')
                    .text()
                    .trim(),
            });
        });

        return result;
    }

    function generateCombinations(groups) {
        const groupValues = Object.values(groups);

        if (!groupValues.length) {
            return [];
        }

        if (groupValues.some(group => !group.length)) {
            return [];
        }

        return groupValues.reduce(
            (combinations, group) => {
                const result = [];

                combinations.forEach(combination => {
                    group.forEach(value => {
                        result.push([
                            ...combination,
                            value,
                        ]);
                    });
                });

                return result;
            },
            [[]]
        );
    }

    function findExistingVariant(combination) {
        return existingVariants.find(variant => {
            const existingValues = variant.values || [];

            if (
                existingValues.length !== combination.length
            ) {
                return false;
            }

            return combination.every(value => {
                return existingValues.some(item =>
                    Number(item.attribute_value_id) ===
                    Number(value.id)
                );
            });
        });
    }

    function renderVariantImage(existing, index) {
        const image = existing?.image ?? null;

        return `
            <div class="variant-image-wrapper">

                <div
                    class="variant-image-preview mb-2 ${
                        image ? '' : 'd-none'
                    }"
                >
                    ${
                        image
                            ? `
                                <div class="position-relative d-inline-block">
                                    <img
                                        src="/storage/${image}"
                                        alt="Variant Image"
                                        class="img-thumbnail"
                                        style="
                                            width: 70px;
                                            height: 70px;
                                            object-fit: cover;
                                        "
                                    >

                                    <button
                                        type="button"
                                        class="btn btn-danger btn-sm position-absolute top-0 end-0 remove-variant-image"
                                        title="Remove image"
                                        style="
                                            width: 22px;
                                            height: 22px;
                                            padding: 0;
                                            transform: translate(35%, -35%);
                                        "
                                    >
                                        <i class="fa fa-times"></i>
                                    </button>
                                </div>
                            `
                            : ''
                    }
                </div>

                <input
                    type="file"
                    name="variants[${index}][image]"
                    class="form-control form-control-sm variant-image-input"
                    accept="image/*"
                >

                <input
                    type="hidden"
                    name="variants[${index}][remove_image]"
                    value="0"
                    class="remove-image-input"
                >

                <small class="text-muted">
                    JPG, JPEG, PNG, WEBP
                </small>
            </div>
        `;
    }

    function renderVariants() {
        const groups = getSelectedValues();
        const combinations = generateCombinations(groups);

        variantsContainer.empty();

        if (!combinations.length) {
            variantsContainer.html(`
                <div class="alert alert-info mb-0">
                    Select attribute values and generate variants.
                </div>
            `);

            return;
        }

        let html = `
            <div class="table-responsive">
                <table class="table table-bordered align-middle">
                    <thead>
                        <tr>
                            <th>Variant</th>
                            <th width="160">SKU</th>
                            <th width="140">Price</th>
                            <th width="140">Discount Price</th>
                            <th width="110">Stock</th>
                            <th width="100">Status</th>
                            <th width="230">Image</th>
                            <th width="80">Action</th>
                        </tr>
                    </thead>

                    <tbody>
        `;

        combinations.forEach((combination, index) => {
            const existing = findExistingVariant(combination);

            const variantName = combination
                .map(value => value.label)
                .join(' + ');

            const variantValues = combination.map(value => {
                const attributeId = Object.keys(groups).find(
                    id => groups[id].some(
                        item => item.id === value.id
                    )
                );

                return {
                    attribute_id: Number(attributeId),
                    attribute_value_id: Number(value.id),
                };
            });

            html += `
                <tr>
                    <td>
                        <div class="fw-semibold">
                            ${variantName}
                        </div>

                        <input
                            type="hidden"
                            name="variants[${index}][id]"
                            value="${existing?.id ?? ''}"
                        >
            `;

            variantValues.forEach((value, valueIndex) => {
                html += `
                    <input
                        type="hidden"
                        name="variants[${index}][values][${valueIndex}][attribute_id]"
                        value="${value.attribute_id}"
                    >

                    <input
                        type="hidden"
                        name="variants[${index}][values][${valueIndex}][attribute_value_id]"
                        value="${value.attribute_value_id}"
                    >
                `;
            });

            html += `
                    </td>

                    <td>
                        <input
                            type="text"
                            name="variants[${index}][sku]"
                            class="form-control form-control-sm"
                            value="${existing?.sku ?? ''}"
                            placeholder="Variant SKU"
                        >
                    </td>

                    <td>
                        <input
                            type="number"
                            step="0.01"
                            min="0"
                            name="variants[${index}][price]"
                            class="form-control form-control-sm"
                            value="${existing?.price ?? ''}"
                            placeholder="0.00"
                        >
                    </td>

                    <td>
                        <input
                            type="number"
                            step="0.01"
                            min="0"
                            name="variants[${index}][discount_price]"
                            class="form-control form-control-sm"
                            value="${existing?.discount_price ?? ''}"
                            placeholder="0.00"
                        >
                    </td>

                    <td>
                        <input
                            type="number"
                            min="0"
                            name="variants[${index}][stock]"
                            class="form-control form-control-sm"
                            value="${existing?.stock ?? 0}"
                        >
                    </td>

                    <td>
                        <input
                            type="hidden"
                            name="variants[${index}][status]"
                            value="0"
                        >

                        <div class="form-check">
                            <input
                                type="checkbox"
                                name="variants[${index}][status]"
                                value="1"
                                class="form-check-input"
                                ${
                                    existing?.status !== false
                                        ? 'checked'
                                        : ''
                                }
                            >

                            <label class="form-check-label">
                                Active
                            </label>
                        </div>
                    </td>

                    <td>
                        ${renderVariantImage(existing, index)}
                    </td>

                    <td>
                        ${
                            existing
                                ? `
                                    <button
                                        type="button"
                                        class="btn btn-danger btn-sm remove-variant"
                                        title="Remove"
                                        data-variant-id="${existing.id}"
                                    >
                                        <i class="fa fa-trash"></i>
                                    </button>
                                `
                                : `
                                    <button
                                        type="button"
                                        class="btn btn-danger btn-sm remove-variant"
                                        title="Remove"
                                    >
                                        <i class="fa fa-trash"></i>
                                    </button>
                                `
                        }
                    </td>
                </tr>
            `;
        });

        html += `
                    </tbody>
                </table>
            </div>
        `;

        variantsContainer.html(html);
    }

    $('#generate-variants').on('click', function () {
        renderVariants();
    });

    /*
     * Edit page:
     * Existing attributes → values → variants
     */
    if ($('.attribute-checkbox:checked').length) {
        renderAttributeValues();
        renderVariants();
    }

    /*
     * Preview newly selected image
     */
    $(document).on('change', '.variant-image-input', function () {
        const input = this;
        const wrapper = $(input).closest('.variant-image-wrapper');
        const preview = wrapper.find('.variant-image-preview');
        const removeInput = wrapper.find('.remove-image-input');

        if (!input.files || !input.files.length) {
            return;
        }

        const file = input.files[0];

        const reader = new FileReader();

        reader.onload = function (event) {
            preview
                .removeClass('d-none')
                .html(`
                    <div class="position-relative d-inline-block">
                        <img
                            src="${event.target.result}"
                            alt="Variant Image"
                            class="img-thumbnail"
                            style="
                                width: 70px;
                                height: 70px;
                                object-fit: cover;
                            "
                        >

                        <button
                            type="button"
                            class="btn btn-danger btn-sm position-absolute top-0 end-0 remove-variant-image"
                            title="Remove image"
                            style="
                                width: 22px;
                                height: 22px;
                                padding: 0;
                                transform: translate(35%, -35%);
                            "
                        >
                            <i class="fa fa-times"></i>
                        </button>
                    </div>
                `);

            removeInput.val('0');
        };

        reader.readAsDataURL(file);
    });

    /*
     * Remove variant image
     */
    $(document).on('click', '.remove-variant-image', function () {
        const wrapper = $(this).closest('.variant-image-wrapper');

        wrapper
            .find('.variant-image-input')
            .val('');

        wrapper
            .find('.variant-image-preview')
            .addClass('d-none')
            .empty();

        wrapper
            .find('.remove-image-input')
            .val('1');
    });

    /*
     * Remove entire variant
     */
    $(document).on('click', '.remove-variant', function () {
        const variantId = Number($(this).data('variant-id'));

        if (variantId) {
            removedVariantIds.push(variantId);
        }

        $(this).closest('tr').remove();

        reindexVariants();
    });

    function reindexVariants() {
        $('#variants-container tbody tr').each(function (index) {
            $(this)
                .find('[name]')
                .each(function () {
                    const name = $(this).attr('name');

                    if (!name) {
                        return;
                    }

                    $(this).attr(
                        'name',
                        name.replace(
                            /variants\[\d+\]/,
                            `variants[${index}]`
                        )
                    );
                });
        });
    }

    $('form').on('submit', function () {
        $('#removed-variant-inputs').remove();

        const form = this;

        removedVariantIds.forEach(id => {
            $('<input>', {
                type: 'hidden',
                name: 'removed_variant_ids[]',
                value: id,
            }).appendTo(form);
        });
    });
});