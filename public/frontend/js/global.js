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
    const url = button.data('url');
    const action = button.data('action');

    if (button.hasClass('loading')) {
        return;
    }

    button.addClass('loading').prop('disabled', true);

    $.ajax({
        url: url,
        type: 'PATCH',
        data: {
            _token: $('meta[name="csrf-token"]').attr('content'),
            action: action
        },
        success: function (response) {
            if (!response.success) {
                return;
            }

            updateCart(response);
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