
setTimeout(function () {
	const alert = document.getElementById('successAlert');

	if (alert) {
		const bsAlert = bootstrap.Alert.getOrCreateInstance(alert);
		bsAlert.close();
	}
}, 2000);


/*
|--------------------------------------------------------------------------
| Menu Or Settings Search js
|--------------------------------------------------------------------------
*/

$(document).ready(function () {
	const searchInput = document.querySelector('#adminSearch');

	if (!searchInput) {
		return;
	}

	let searchTimer;

	searchInput.addEventListener('input', function () {
		clearTimeout(searchTimer);

		const query = this.value.trim();

		if (query.length < 2) {
			hideSearchResults();
			return;
		}

		searchTimer = setTimeout(() => {
			searchAdmin(query);
		}, 300);
	});

	async function searchAdmin(query) {
		try {
			const response = await fetch(
				`/admin/search?q=${encodeURIComponent(query)}`,
				{
					headers: {
						'Accept': 'application/json',
						'X-Requested-With': 'XMLHttpRequest',
					}
				}
			);

			if (!response.ok) {
				throw new Error('Search request failed.');
			}

			const results = await response.json();

			renderSearchResults(results);

		} catch (error) {
			console.error('Search error:', error);
			hideSearchResults();
		}
	}

	function renderSearchResults(results) {
		const container = document.querySelector('#adminSearchResults');

		if (!container) {
			return;
		}

		if (!results.length) {
			container.innerHTML = `
                        <div class="search-empty">
                            No results found
                        </div>
                    `;

			container.style.display = 'block';
			return;
		}

		container.innerHTML = results.map(item => `
                    <a href="${item.route}" class="search-result-item">
                        <i class="${item.icon ?? 'fa fa-search'}"></i>
                        <span>${item.title}</span>
                    </a>
                `).join('');

		container.style.display = 'block';
	}

	function hideSearchResults() {
		const container = document.querySelector('#adminSearchResults');

		if (container) {
			container.innerHTML = '';
			container.style.display = 'none';
		}
	}

	document.addEventListener('click', function (event) {
		const wrapper = document.querySelector('.admin-search-wrapper');

		if (wrapper && !wrapper.contains(event.target)) {
			hideSearchResults();
		}
	});
});

/*
|--------------------------------------------------------------------------
| Site Settings js
|--------------------------------------------------------------------------
*/

document.addEventListener('DOMContentLoaded', function() {
	const menuItems = document.querySelectorAll('.settings-menu-item');
	const tabPanes = document.querySelectorAll('.settings-tab-pane');

	function openTab(targetId) {
		menuItems.forEach(function(item) {
			item.classList.remove('active');
		});

		tabPanes.forEach(function(pane) {
			pane.classList.remove('active');
		});

		const selectedMenu = document.querySelector(
			'.settings-menu-item[href="' + targetId + '"]'
		);

		const selectedPane = document.querySelector(targetId);

		if (!selectedPane) {
			return;
		}
		if (selectedMenu) {
			selectedMenu.classList.add('active');
		}
		selectedPane.classList.add('active');
	}

	menuItems.forEach(function(item) {
		item.addEventListener('click', function(event) {
			event.preventDefault();

			const targetId = this.getAttribute('href');

			if (!targetId) {
				return;
			}

			openTab(targetId);

			if (history.pushState) {
				history.pushState(
					null,
					null,
					targetId
				);
			} else {
				window.location.hash = targetId;
			}
		});
	});

	const hash = window.location.hash;

	if (hash && document.querySelector(hash)) {
		openTab(hash);
	} else {
		openTab('#general');
	}
});

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
            'badge bg-primary d-flex align-items-center gap-1 tag-item';

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
