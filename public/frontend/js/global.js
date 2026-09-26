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

    const mainSlider = $('#qv-main-slider');
    const thumbSlider = $('#qv-thumb-slider');

    const productName = document.getElementById('qv-product-name');
    const productCode = document.getElementById('qv-product-code');
    const productPrice = document.getElementById('qv-product-price');
    const productColor = document.getElementById('qv-product-color');
    const productSize = document.getElementById('qv-product-size');
    const fullDetails = document.getElementById('qv-full-details');
    const addToCartButton = document.getElementById('qv-add-to-cart');

    document.addEventListener('click', function (event) {
        const button = event.target.closest('.quick-view-btn');

        if (!button) {
            return;
        }

        const data = button.dataset;

        productName.textContent = data.productName || '';
        productCode.textContent = data.productCode || 'N/A';
        productPrice.textContent = data.productPrice || 'N/A';

        fullDetails.href = data.productUrl || '#';

        addToCartButton.dataset.url = data.cartUrl || '';
        addToCartButton.dataset.productId = data.productId || '';

        productColor.innerHTML =
            '<span class="text-muted">Available on product page</span>';

        productSize.innerHTML =
            '<span class="text-muted">Available on product page</span>';

        loadQuickViewImages(data);
        loadQuickViewVariants(data);
    });

    function loadQuickViewImages(data) {
        destroySliders();

        let images = [];

        try {
            images = JSON.parse(data.productImages || '[]');
        } catch (error) {
            images = [];
        }

        if (!Array.isArray(images)) {
            images = [];
        }

        if (!images.length && data.productImage) {
            images.push(data.productImage);
        }

        images = images.filter(function (image) {
            return image && image.trim() !== '';
        });

        if (!images.length) {
            mainSlider.html(`
                <div class="qv-main-slide">
                    <div class="d-flex align-items-center justify-content-center h-100">
                        <span class="text-muted">
                            No image available
                        </span>
                    </div>
                </div>
            `);

            thumbSlider.empty();

            return;
        }

        let mainHtml = '';
        let thumbHtml = '';

        images.forEach(function (image, index) {
            mainHtml += `
                <div class="qv-main-slide">
                    <img
                        src="${image}"
                        alt="${escapeHtml(data.productName || 'Product')}"
                    >
                </div>
            `;

            thumbHtml += `
                <div class="qv-thumb-slide">
                    <div class="qv-thumb ${index === 0 ? 'active' : ''}">
                        <img
                            src="${image}"
                            alt="${escapeHtml(data.productName || 'Product')}"
                        >
                    </div>
                </div>
            `;
        });

        mainSlider.html(mainHtml);
        thumbSlider.html(thumbHtml);

        mainSlider.slick({
            slidesToShow: 1,
            slidesToScroll: 1,
            arrows: true,
            fade: true,
            adaptiveHeight: false,
            asNavFor: '#qv-thumb-slider'
        });

        thumbSlider.slick({
            slidesToShow: Math.min(images.length, 4),
            slidesToScroll: 1,
            asNavFor: '#qv-main-slider',
            dots: false,
            arrows: images.length > 4,
            centerMode: false,
            focusOnSelect: true,
            responsive: [
                {
                    breakpoint: 576,
                    settings: {
                        slidesToShow: Math.min(images.length, 3)
                    }
                }
            ]
        });

        updateActiveThumbnail();

        mainSlider.on('afterChange', function (event, slick, currentSlide) {
            updateActiveThumbnail(currentSlide);
        });
    }

    function loadQuickViewVariants(data) {
        productColor.innerHTML = '';
        productSize.innerHTML = '';

        let variants = [];

        try {
            variants = JSON.parse(data.productVariants || '[]');
        } catch (error) {
            variants = [];
        }

        if (!variants.length) {
            productColor.innerHTML =
                '<span class="text-muted">No color available</span>';

            productSize.innerHTML =
                '<span class="text-muted">No size available</span>';

            return;
        }

        const colors = new Map();
        const sizes = new Map();

        variants.forEach(function (variant) {
            if (!variant.values) {
                return;
            }

            variant.values.forEach(function (item) {
                const attributeName = (item.attribute_name || '').toLowerCase();
                const value = item.value;

                if (!value) {
                    return;
                }

                if (attributeName === 'color') {
                    colors.set(item.attribute_value_id, value);
                }

                if (attributeName === 'size') {
                    sizes.set(item.attribute_value_id, value);
                }
            });
        });

        if (colors.size) {
            colors.forEach(function (value, id) {
                const button = document.createElement('button');

                button.type = 'button';
                button.className = 'btn btn-outline-secondary';
                button.textContent = value;
                button.dataset.attributeValueId = id;

                productColor.appendChild(button);
            });
        } else {
            productColor.innerHTML =
                '<span class="text-muted">No color available</span>';
        }

        if (sizes.size) {
            sizes.forEach(function (value, id) {
                const button = document.createElement('button');

                button.type = 'button';
                button.className = 'btn btn-outline-secondary';
                button.textContent = value;
                button.dataset.attributeValueId = id;

                productSize.appendChild(button);
            });
        } else {
            productSize.innerHTML =
                '<span class="text-muted">No size available</span>';
        }
    }

    function updateActiveThumbnail(activeIndex = 0) {
        $('#qv-thumb-slider .qv-thumb').removeClass('active');
        $('#qv-thumb-slider .slick-slide')
            .eq(activeIndex)
            .find('.qv-thumb')
            .addClass('active');
    }

    function destroySliders() {
        if (mainSlider.hasClass('slick-initialized')) {
            mainSlider.slick('unslick');
        }

        if (thumbSlider.hasClass('slick-initialized')) {
            thumbSlider.slick('unslick');
        }

        mainSlider.empty();
        thumbSlider.empty();
    }

    function escapeHtml(text) {
        return $('<div>').text(text).html();
    }
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

    const cartModal = document.getElementById('cartModal');
    const cartBtn = document.querySelector('.cart-floating-btn');

    cartModal.addEventListener('shown.bs.offcanvas', function () {
        backToTop.classList.add('hide-floating-btns');
        cartBtn.classList.add('hide-floating-btns');
    });

    cartModal.addEventListener('hidden.bs.offcanvas', function () {
        backToTop.classList.remove('hide-floating-btns');
        cartBtn.classList.remove('hide-floating-btns');
    });
});

/*-------------------
    Wishlist Toggle
--------------------- */

$(document).on('click', '.wishlist-btn', function (e) {
    e.preventDefault();
    e.stopPropagation();

    const button = $(this);
    const productId = button.data('product-id');

    $.ajax({
        url: `/wishlist/${productId}/toggle`,
        type: 'POST',
        data: {
            _token: $('meta[name="csrf-token"]').attr('content')
        },
        success: function (response) {
            if (!response.status) {
                return;
            }

            // Update wishlist count immediately
            $('.wishlist-badge').text(response.wishlist_count);

            // Update heart icon
            if (response.added) {
                button.addClass('active');

                button.find('i')
                    .removeClass('fa-regular')
                    .addClass('fa-solid');

                button.attr('aria-label', 'Remove from wishlist');
            } else {
                button.removeClass('active');

                button.find('i')
                    .removeClass('fa-solid')
                    .addClass('fa-regular');

                button.attr('aria-label', 'Add to wishlist');
            }

            // Show message
            showWishlistAlert(response.message);
        },
        error: function (xhr) {
            if (xhr.status === 401 && xhr.responseJSON?.redirect) {
                window.location.href = xhr.responseJSON.redirect;
                return;
            }

            console.log(xhr.responseText);
        }
    });
});

function showWishlistAlert(message) {
    const alert = $(`
        <div class="alert alert-success alert-dismissible fade show wishlist-alert"
             role="alert">
            ${message}
            <button type="button"
                    class="btn-close"
                    data-bs-dismiss="alert"
                    aria-label="Close"></button>
        </div>
    `);

    $('#ajaxAlertContainer').html(alert);

    setTimeout(function () {
        alert.alert('close');
    }, 2500);
}

/*-------------------
    Add to Cart
--------------------- */

$(document).on('click', '.add-to-cart-btn', function (e) {
    e.preventDefault();

    const button = $(this);
    const url = button.data('url');

    if (button.hasClass('loading')) {
        return;
    }

    button.addClass('loading').prop('disabled', true);

    $.ajax({
        url: url,
        type: 'POST',
        data: {
            _token: $('meta[name="csrf-token"]').attr('content'),
            quantity: 1
        },
        success: function (response) {
            if (!response.success) {
                return;
            }

            updateCart(response);

            showCartAlert(
                'success',
                response.message || 'Product added to cart.'
            );
        },
        error: function (xhr) {
            const message = xhr.responseJSON?.message || 'Something went wrong.';

            showCartAlert('danger', message);
        },
        complete: function () {
            button.removeClass('loading').prop('disabled', false);
        }
    });
});


/*-------------------
    Update Cart Quantity
--------------------- */

$(document).on('click', '.cart-quantity-btn', function (e) {
    e.preventDefault();

    const button = $(this);
    const cartItem = button.closest('.cart-item');
    const input = cartItem.find('.cart-quantity-input');

    const url = button.data('url');
    const action = button.data('action');

    const currentQuantity = parseInt(input.val(), 10) || 1;
    const maxStock = parseInt(cartItem.data('max-stock'), 10) || 0;

    let newQuantity = currentQuantity;

    if (action === 'increase') {
        newQuantity = currentQuantity + 1;
    }

    if (action === 'decrease') {
        newQuantity = currentQuantity - 1;
    }

    if (newQuantity < 1) {
        newQuantity = 1;
    }

    if (newQuantity > maxStock) {
        showCartAlert(
            'danger',
            `Only ${maxStock} item(s) available in stock.`
        );

        return;
    }

    updateCartItemQuantity(button, url, newQuantity);
});


/*-------------------
    Cart Quantity Input
--------------------- */

$(document).on('change', '.cart-quantity-input', function () {
    const input = $(this);
    const cartItem = input.closest('.cart-item');

    const url = input.data('url');

    const maxStock = parseInt(
        cartItem.data('max-stock'),
        10
    ) || 0;

    let quantity = parseInt(input.val(), 10) || 1;

    if (quantity < 1) {
        quantity = 1;
    }

    if (quantity > maxStock) {
        quantity = maxStock;

        showCartAlert(
            'danger',
            `Only ${maxStock} item(s) available in stock.`
        );
    }

    input.val(quantity);

    updateCartItemQuantity(input, url, quantity);
});


/*-------------------
    Remove Cart Item
--------------------- */

$(document).on('click', '.remove-cart-item', function (e) {
    e.preventDefault();

    const button = $(this);
    const url = button.data('url');

    if (button.hasClass('loading')) {
        return;
    }

    button.addClass('loading').prop('disabled', true);

    $.ajax({
        url: url,
        type: 'DELETE',
        data: {
            _token: $('meta[name="csrf-token"]').attr('content')
        },
        success: function (response) {
            if (!response.success) {
                return;
            }

            updateCart(response);

            showCartAlert(
                'success',
                response.message || 'Product removed from cart.'
            );
        },
        error: function (xhr) {
            const message = xhr.responseJSON?.message || 'Something went wrong.';

            showCartAlert('danger', message);
        },
        complete: function () {
            button.removeClass('loading').prop('disabled', false);
        }
    });
});


/*-------------------
    Update Cart Item
--------------------- */

function updateCartItemQuantity(element, url, quantity) {
    if (element.hasClass('loading')) {
        return;
    }

    element.addClass('loading').prop('disabled', true);

    $.ajax({
        url: url,
        type: 'PATCH',
        data: {
            _token: $('meta[name="csrf-token"]').attr('content'),
            quantity: quantity
        },
        success: function (response) {
            if (!response.success) {
                return;
            }

            updateCart(response);
        },
        error: function (xhr) {
            const message = xhr.responseJSON?.message
                || 'Something went wrong.';

            showCartAlert('danger', message);
        },
        complete: function () {
            element.removeClass('loading').prop('disabled', false);
        }
    });
}


/*-------------------
    Update Cart UI
--------------------- */

function updateCart(response) {
    $('.cart-badge').text(response.cart_count);

    $('.cart-items').html(response.cart_html);

    updateCartTotals(response.totals);
}


/*-------------------
    Update Cart Totals
--------------------- */

function updateCartTotals(totals) {
    $('.cart-total .total-row').eq(0).find('.total-price')
        .text(formatPrice(totals.total));

    $('.cart-total .total-row').eq(1).find('.total-price')
        .text(formatPrice(totals.discount));

    $('.cart-total .total-row').eq(2).find('.total-price')
        .text(formatPrice(totals.subtotal));
}


/*-------------------
    Format Price
--------------------- */

function formatPrice(amount) {
    return '৳' + Number(amount).toLocaleString('en-BD', {
        minimumFractionDigits: 2,
        maximumFractionDigits: 2
    });
}


/*-------------------
    Cart Alert
--------------------- */

function showCartAlert(type, message) {
    const icon = type === 'success'
        ? 'fa-check-circle'
        : 'fa-exclamation-circle';

    const alert = $(`
        <div
            class="alert alert-${type} alert-dismissible fade show position-fixed top-0 end-0 m-3 shadow"
            id="cartAlert"
            style="z-index: 9999;"
            role="alert"
        >
            <i class="fas ${icon} me-2"></i>
            ${message}

            <button
                type="button"
                class="btn-close"
                data-bs-dismiss="alert"
                aria-label="Close"
            ></button>
        </div>
    `);

    $('#ajaxAlertContainer').html(alert);

    setTimeout(function () {
        alert.alert('close');
    }, 2000);
}