$.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': document.querySelector(
            'meta[name="csrf-token"]'
        ).content
    }
});

function showAlert(message, type = 'success') {
    $("#ajaxAlert").remove();

    const icon = type === 'success'
        ? 'fa-check-circle'
        : 'fa-exclamation-circle';

    const alert = `
        <div
            class="alert alert-${type} alert-dismissible fade show position-fixed top-0 end-0 m-3 shadow"
            id="ajaxAlert"
            style="z-index: 9999; min-width: 300px;"
            role="alert"
        >
            <i class="fas ${icon} me-2"></i>
            ${message}
        </div>
    `;

    $("body").append(alert);

    setTimeout(function () {
        $("#ajaxAlert").fadeOut(300, function () {
            $(this).remove();
        });
    }, 2000);
}

/*
|--------------------------------------------------------------------------
| success js
|--------------------------------------------------------------------------
*/

setTimeout(function () {
	const alert = document.getElementById('successAlert');

	if (alert) {
		const bsAlert = bootstrap.Alert.getOrCreateInstance(alert);
		bsAlert.close();
	}
}, 2000);

/*
|--------------------------------------------------------------------------
| Theme color js
|--------------------------------------------------------------------------
*/

function saveThemeColor(type, color) {
    $.ajax({
        url: window.themeColorSaveUrl,
        method: "POST",
        data: {
            _token: $('meta[name="csrf-token"]').attr('content') || "{{ csrf_token() }}",
            [type]: color
        },
        success: function (res) {
            if (res.success) {
                showAlert(res.message);
            }
        },
        error: function (xhr) {
            console.error(xhr.responseText);
        }
    });
}

$(".changeLogoHeaderColor").on("click", function () {
    const color = $(this).attr("data-color");

    if (color === "default") {
        $(".logo-header").removeAttr("data-background-color");
    } else {
        $(".logo-header").attr("data-background-color", color);
    }

    $(this).parent().find(".changeLogoHeaderColor").removeClass("selected");
    $(this).addClass("selected");
    customCheckColor();
    layoutsColors();
    getCheckmark();

    // Save to DB
    saveThemeColor('logo_header_color', color === 'default' ? null : color);
});

$(".changeTopBarColor").on("click", function () {
    const color = $(this).attr("data-color");

    if (color === "default") {
        $(".main-header .navbar-header").removeAttr("data-background-color");
    } else {
        $(".main-header .navbar-header").attr("data-background-color", color);
    }

    $(this).parent().find(".changeTopBarColor").removeClass("selected");
    $(this).addClass("selected");
    layoutsColors();
    getCheckmark();

    saveThemeColor('topbar_color', color === 'default' ? null : color);
});

$(".changeSideBarColor").on("click", function () {
    const color = $(this).attr("data-color");

    if (color === "default") {
        $(".sidebar").removeAttr("data-background-color");
    } else {
        $(".sidebar").attr("data-background-color", color);
    }

    $(this).parent().find(".changeSideBarColor").removeClass("selected");
    $(this).addClass("selected");
    layoutsColors();
    getCheckmark();

    saveThemeColor('sidebar_color', color === 'default' ? null : color);
});

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
