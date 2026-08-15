
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
