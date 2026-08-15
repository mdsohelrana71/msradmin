/*
|--------------------------------------------------------------------------
| Category JS (Conflict Free)
|--------------------------------------------------------------------------
*/

document.addEventListener('DOMContentLoaded', function () {

    // ===============================
    // 1. Toggle Icon (Plus / Minus)
    // ===============================
    document.querySelectorAll('.category-toggle').forEach(function (button) {
        const targetSelector = button.getAttribute('data-bs-target');
        const target = document.querySelector(targetSelector);

        if (!target) return;

        target.addEventListener('shown.bs.collapse', function () {
            const icon = button.querySelector('i');
            if (icon) {
                icon.classList.remove('fa-plus');
                icon.classList.add('fa-minus');
            }
        });

        target.addEventListener('hidden.bs.collapse', function () {
            const icon = button.querySelector('i');
            if (icon) {
                icon.classList.remove('fa-minus');
                icon.classList.add('fa-plus');
            }
        });
    });


    // ===============================
    // 2. Category Tree Search
    // ===============================
    const treeSearchInput = document.getElementById('categoryTreeSearch');
    const treeClearButton = document.getElementById('clearCategoryTreeSearch');
    const tree = document.querySelector('.category-tree');

    if (treeSearchInput && tree) {

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

            const regex = new RegExp(`(${escapeRegex(keyword)})`, 'gi');
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

                    const toggle = parent.previousElementSibling?.querySelector('.category-toggle');

                    if (toggle) {
                        toggle.setAttribute('aria-expanded', 'true');
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
                toggle.setAttribute('aria-expanded', 'false');
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
            const keyword = treeSearchInput.value.trim().toLowerCase();

            if (treeClearButton) {
                treeClearButton.classList.toggle('d-none', keyword === '');
            }

            if (!keyword) {
                resetTree();
                return;
            }

            const items = tree.querySelectorAll('.category-item');

            items.forEach(item => {
                item.style.display = 'none';
            });

            items.forEach(item => {
                const title = item.querySelector(':scope > .category-row .category-title');

                if (!title) return;

                const categoryName = (title.dataset.originalText || title.textContent)
                    .trim()
                    .toLowerCase();

                highlightText(title, keyword);

                if (categoryName.includes(keyword)) {
                    item.style.display = '';
                    openParent(item);
                }
            });
        }

        treeSearchInput.addEventListener('input', searchCategories);

        if (treeClearButton) {
            treeClearButton.addEventListener('click', function () {
                treeSearchInput.value = '';
                resetTree();
                treeClearButton.classList.add('d-none');
                treeSearchInput.focus();
            });
        }
    }


    // ===============================
    // 3. Parent Category Search
    // ===============================
    const parentSearchInput = document.getElementById('parentCategorySearch');
    const categoryList = document.querySelector('.category-list');
    const emptyMessage = document.getElementById('categorySearchEmpty');

    if (parentSearchInput && categoryList) {

        const treeItems = categoryList.querySelectorAll('.category-tree-item');

        // Store original names
        treeItems.forEach(function (item) {
            const nameElement = item.querySelector(':scope > .category-option-row .category-name');
            if (nameElement) {
                nameElement.dataset.originalText = nameElement.textContent.trim();
            }
        });

        function escapeRegex(value) {
            return value.replace(/[.*+?^${}()|[\]\\]/g, '\\$&');
        }

        function highlightText(item, keyword) {
            const nameElement = item.querySelector(':scope > .category-option-row .category-name');
            if (!nameElement) return;

            const originalText = nameElement.dataset.originalText || nameElement.textContent.trim();

            if (!keyword) {
                nameElement.textContent = originalText;
                return;
            }

            const regex = new RegExp('(' + escapeRegex(keyword) + ')', 'gi');
            nameElement.innerHTML = originalText.replace(
                regex,
                '<mark class="category-search-highlight">$1</mark>'
            );
        }

        function showItemAndParents(item, keyword) {
            item.style.display = '';
            highlightText(item, keyword);

            const children = item.querySelector(':scope > .category-children');
            if (children) {
                children.classList.add('show');
            }

            const toggle = item.querySelector(':scope > .category-option-row .category-toggle');
            if (toggle) {
                toggle.setAttribute('aria-expanded', 'true');
                const icon = toggle.querySelector('i');
                if (icon) {
                    icon.classList.remove('fa-plus');
                    icon.classList.add('fa-minus');
                }
            }

            const parent = item.parentElement.closest('.category-tree-item');
            if (parent) {
                showItemAndParents(parent, keyword);
            }
        }

        function hideAllItems() {
            treeItems.forEach(function (item) {
                item.style.display = 'none';

                const nameElement = item.querySelector(':scope > .category-option-row .category-name');
                if (nameElement?.dataset.originalText) {
                    nameElement.textContent = nameElement.dataset.originalText;
                }
            });
        }

        function resetCategories() {
            treeItems.forEach(function (item) {
                item.style.display = '';

                const nameElement = item.querySelector(':scope > .category-option-row .category-name');
                if (nameElement?.dataset.originalText) {
                    nameElement.textContent = nameElement.dataset.originalText;
                }

                const children = item.querySelector(':scope > .category-children');
                if (children) {
                    children.classList.remove('show');
                }

                const toggle = item.querySelector(':scope > .category-option-row .category-toggle');
                if (toggle) {
                    toggle.setAttribute('aria-expanded', 'false');
                    const icon = toggle.querySelector('i');
                    if (icon) {
                        icon.classList.remove('fa-minus');
                        icon.classList.add('fa-plus');
                    }
                }
            });

            if (emptyMessage) {
                emptyMessage.classList.add('d-none');
            }
        }

        parentSearchInput.addEventListener('input', function () {
            const keyword = this.value.trim().toLowerCase();

            if (!keyword) {
                resetCategories();
                return;
            }

            hideAllItems();

            let found = false;

            treeItems.forEach(function (item) {
                const nameElement = item.querySelector(':scope > .category-option-row .category-name');
                const originalText = nameElement?.dataset.originalText?.toLowerCase() || '';

                if (originalText.includes(keyword)) {
                    found = true;
                    showItemAndParents(item, keyword);
                }
            });

            if (emptyMessage) {
                emptyMessage.classList.toggle('d-none', found);
            }
        });
    }

});