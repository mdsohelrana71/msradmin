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