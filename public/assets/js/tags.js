/*
|--------------------------------------------------------------------------
| Tags js
|--------------------------------------------------------------------------
*/

document.addEventListener('DOMContentLoaded', function () {
    const container = document.getElementById('tags-container');
    const input = document.getElementById('tag-input');

    input.addEventListener('keydown', function (e) {
        if (e.key !== 'Enter') {
            return;
        }

        e.preventDefault();

        const value = input.value.trim();

        if (!value) {
            return;
        }

        addTag(value);
        input.value = '';
    });

    container.addEventListener('click', function (e) {
        if (e.target.classList.contains('remove-tag')) {
            e.target.closest('.tag-item').remove();
        }

        input.focus();
    });

    function addTag(name) {
        const existingTags = [
            ...container.querySelectorAll('.tag-item')
        ].map(tag => {
            return tag.textContent.trim().toLowerCase();
        });

        if (existingTags.includes(name.toLowerCase())) {
            return;
        }

        const tag = document.createElement('span');

        tag.className =
            'badge bg-primary gap-1 tag-item';

        tag.innerHTML = `
            ${escapeHtml(name)}

            <button
                type="button"
                class="btn-close btn-close-white remove-tag"
                style="font-size: 8px;"
            ></button>

            <input
                type="hidden"
                name="tags[]"
                value="${escapeHtml(name)}"
            >
        `;

        container.insertBefore(tag, input);
    }

    function escapeHtml(value) {
        const div = document.createElement('div');
        div.textContent = value;
        return div.innerHTML;
    }
});