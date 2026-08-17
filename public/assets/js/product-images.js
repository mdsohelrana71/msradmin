$(document).ready(function () {
    let newImageIndex = 0;

    const galleryContainer = $('#product-gallery');
    const newImagesContainer = $('#new-gallery-images');

    /*
     * Add new gallery image
     */
    $('#add-gallery-image').on('click', function () {
        const index = newImageIndex++;

        const html = `
            <div
                class="new-gallery-item border rounded p-3 mb-3"
                data-index="${index}"
            >
                <div class="row align-items-center">
                    <div class="col-md-2">
                        <div
                            class="gallery-preview border rounded d-flex align-items-center justify-content-center"
                            style="height: 100px; width: 100px;"
                        >
                            <i class="fa fa-image text-muted fa-2x"></i>
                        </div>
                    </div>

                    <div class="col-md-8">
                        <div class="form-group mb-2">
                            <label class="form-label">
                                Image
                            </label>

                            <input
                                type="file"
                                name="images[${index}][image]"
                                class="form-control gallery-image-input"
                                accept="image/jpeg,image/png,image/webp"
                            >
                        </div>

                        <div class="form-group mb-0">
                            <label class="form-label">
                                Alt Text
                            </label>

                            <input
                                type="text"
                                name="images[${index}][alt]"
                                class="form-control"
                                placeholder="Image alt text"
                            >
                        </div>
                    </div>

                    <div class="col-md-2 text-end">
                        <button
                            type="button"
                            class="btn btn-outline-danger btn-sm remove-new-gallery-image"
                            title="Remove"
                        >
                            <i class="fa fa-trash"></i>
                        </button>
                    </div>
                </div>
            </div>
        `;

        newImagesContainer.append(html);
    });

    /*
     * Preview new image
     */
    $(document).on(
        'change',
        '.gallery-image-input',
        function () {
            const input = this;

            if (!input.files || !input.files[0]) {
                return;
            }

            const file = input.files[0];

            if (!file.type.startsWith('image/')) {
                input.value = '';

                return;
            }

            const reader = new FileReader();

            reader.onload = function (event) {
                $(input)
                    .closest('.new-gallery-item')
                    .find('.gallery-preview')
                    .html(`
                        <img
                            src="${event.target.result}"
                            class="img-fluid rounded"
                            style="
                                height: 100px;
                                width: 100px;
                                object-fit: cover;
                            "
                        >
                    `);
            };

            reader.readAsDataURL(file);
        }
    );

    /*
     * Remove new gallery image
     */
    $(document).on(
        'click',
        '.remove-new-gallery-image',
        function () {
            $(this)
                .closest('.new-gallery-item')
                .remove();
        }
    );

    /*
     * Remove existing gallery image
     */
    $(document).on(
        'click',
        '.remove-existing-gallery-image',
        function () {
            const button = $(this);
            const imageId = button.data('image-id');

            if (!imageId) {
                return;
            }

            const form = button.closest('form');

            $('<input>', {
                type: 'hidden',
                name: 'removed_image_ids[]',
                value: imageId,
            }).appendTo(form);

            button
                .closest('.gallery-item')
                .remove();
        }
    );
});