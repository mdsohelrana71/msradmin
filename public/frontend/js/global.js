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