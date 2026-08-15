/*
|--------------------------------------------------------------------------
| Category js
|--------------------------------------------------------------------------
*/

document.addEventListener('DOMContentLoaded', function() {
	document.querySelectorAll('.category-toggle').forEach(function(button) {
		const targetSelector =
			button.getAttribute('data-bs-target');
		const target =
			document.querySelector(targetSelector);

		if (!target) {
			return;
		}

		target.addEventListener(
			'shown.bs.collapse',
			function() {
				const icon =
					button.querySelector('i');

				icon.classList.remove('fa-plus');
				icon.classList.add('fa-minus');
			}
		);

		target.addEventListener(
			'hidden.bs.collapse',
			function() {
				const icon =
					button.querySelector('i');

				icon.classList.remove('fa-minus');
				icon.classList.add('fa-plus');
			}
		);
	});
});

document.addEventListener('DOMContentLoaded', function () {
    const searchInput = document.getElementById('categorySearch');
    const clearButton = document.getElementById('clearCategorySearch');
    const tree = document.querySelector('.category-tree');

    if (!searchInput || !tree) {
        return;
    }

    function escapeRegex(value) {
        return value.replace(/[.*+?^${}()|[\]\\]/g, '\\$&');
    }

    function highlightText(element, keyword) {
        if (!element.dataset.originalText) {
            element.dataset.originalText = element.textContent;
        }

        const originalText = element.dataset.originalText;

        if (!keyword) {
            element.textContent = originalText;
            return;
        }

        const regex = new RegExp(
            `(${escapeRegex(keyword)})`,
            'gi'
        );

        element.innerHTML = originalText.replace(
            regex,
            '<mark class="category-search-highlight">$1</mark>'
        );
    }

    function openParent(item) {
        let parent = item.parentElement;

        while (parent && parent !== tree) {
            if (parent.classList.contains('category-children')) {
                parent.classList.add('show');

                const toggle = parent
                    .previousElementSibling
                    ?.querySelector('.category-toggle');

                if (toggle) {
                    toggle.setAttribute(
                        'aria-expanded',
                        'true'
                    );

                    const icon = toggle.querySelector('i');

                    if (icon) {
                        icon.classList.remove('fa-plus');
                        icon.classList.add('fa-minus');
                    }
                }
            }

            if (parent.classList.contains('category-item')) {
                parent.style.display = '';
            }

            parent = parent.parentElement;
        }
    }

    function resetTree() {
        tree.querySelectorAll('.category-item').forEach(item => {
            item.style.display = '';
        });

        tree.querySelectorAll('.category-children').forEach(children => {
            children.classList.remove('show');
        });

        tree.querySelectorAll('.category-toggle').forEach(toggle => {
            toggle.setAttribute(
                'aria-expanded',
                'false'
            );

            const icon = toggle.querySelector('i');

            if (icon) {
                icon.classList.remove('fa-minus');
                icon.classList.add('fa-plus');
            }
        });

        tree.querySelectorAll('.category-title').forEach(title => {
            highlightText(title, '');
        });
    }

    function searchCategories() {
        const keyword = searchInput.value.trim().toLowerCase();

        clearButton.classList.toggle(
            'd-none',
            keyword === ''
        );

        if (!keyword) {
            resetTree();
            return;
        }

        const items = tree.querySelectorAll('.category-item');

        items.forEach(item => {
            item.style.display = 'none';
        });

        items.forEach(item => {
            const title = item.querySelector(
                ':scope > .category-row .category-title'
            );

            if (!title) {
                return;
            }

            const categoryName = (
                title.dataset.originalText || title.textContent
            ).trim().toLowerCase();

            highlightText(title, keyword);

            if (categoryName.includes(keyword)) {
                item.style.display = '';
                openParent(item);
            }
        });
    }

    searchInput.addEventListener(
        'input',
        searchCategories
    );

    clearButton.addEventListener(
        'click',
        function () {
            searchInput.value = '';

            resetTree();

            clearButton.classList.add('d-none');

            searchInput.focus();
        }
    );
});