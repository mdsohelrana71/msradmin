/*-------------------
    Newsletter Form
--------------------- */
$(document).ready(function () {
    $(document).on('submit', '#newsletterForm', function (e) {
        e.preventDefault();
        const form = $(this);
        const button = form.find('.newsletter-btn');
        const input = form.find('.newsletter-input');
        const message = $('#newsletterMessage');
        message.removeClass('text-success text-danger').html('');
        button.prop('disabled', true).text('Submitting...');
        $.ajax({
            url: form.attr('action'),
            type: 'POST',
            data: form.serialize(),
            dataType: 'json',
            success: function (response) {
                message
                    .removeClass('text-success text-danger')
                    .addClass(response.success ? 'text-success' : 'text-danger')
                    .html(response.message);
                if (response.success) {
                    input.val('');
                }
            },
            error: function (xhr) {
                message
                    .removeClass('text-success text-danger')
                    .addClass('text-danger');
                if (xhr.status === 422 && xhr.responseJSON?.errors) {
                    const errors = Object.values(xhr.responseJSON.errors).flat();
                    message.html(errors.join('<br>'));
                } else if (xhr.responseJSON?.message) {
                    message.html(xhr.responseJSON.message);
                } else {
                    message.html('Something went wrong. Please try again.');
                }
            },
            complete: function () {
                button.prop('disabled', false).text('OK');
            }
        });
    });
});


/*-------------------
    Quick View Modal
--------------------- */

document.addEventListener('DOMContentLoaded', function () {
    const quickViewModal = document.getElementById('quickViewModal');

    if (!quickViewModal) {
        return;
    }

    const mainImage = document.getElementById('qv-main-image');
    const productName = document.getElementById('qv-product-name');
    const productCode = document.getElementById('qv-product-code');
    const productPrice = document.getElementById('qv-product-price');
    const productColor = document.getElementById('qv-product-color');
    const productSize = document.getElementById('qv-product-size');
    const fullDetails = document.getElementById('qv-full-details');

    document.addEventListener('click', function (event) {
        const button = event.target.closest('.quick-view-btn');

        if (!button) {
            return;
        }

        const data = button.dataset;

        productName.textContent = data.productName || '';
        productCode.textContent = data.productCode || 'N/A';
        productPrice.textContent = data.productPrice
            ? data.productPrice
            : 'N/A';

        fullDetails.href = data.productUrl || '#';

        mainImage.src = data.productImage || '';
        mainImage.alt = data.productName || 'Product';

        thumbnails.innerHTML = '';

        if (data.productImage) {
            const thumb = document.createElement('img');
            thumb.src = data.productImage;
            thumb.alt = data.productName || 'Product';
            thumb.className = 'thumb-img active';

            thumb.addEventListener('click', function () {
                changeQuickViewImage(this);
            });

            thumbnails.appendChild(thumb);
        }

        productColor.innerHTML =
            '<span class="text-muted">Available on product page</span>';

        productSize.innerHTML =
            '<span class="text-muted">Available on product page</span>';
    });

    window.changeQuickViewImage = function (image) {
        mainImage.src = image.src;

        document.querySelectorAll('#qv-thumbnails .thumb-img').forEach(function (thumb) {
            thumb.classList.remove('active');
        });

        image.classList.add('active');
    };
});

/*-------------------
    Back to Top
--------------------- */

document.addEventListener('DOMContentLoaded', function () {
    const backToTop = document.getElementById("backToTop");

    if (backToTop) {
        window.addEventListener("scroll", () => {
            if (window.scrollY > 300) {
                backToTop.classList.add("show");
            } else {
                backToTop.classList.remove("show");
            }
        });

        backToTop.addEventListener("click", () => {
            window.scrollTo({
                top: 0,
                behavior: "smooth"
            });
        });
    }
});
