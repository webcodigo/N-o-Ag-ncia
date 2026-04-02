(function () {
	var body = document.body;
	var toggle = document.querySelector('.header-drawer-toggle');
	var drawer = document.getElementById('mobile-editorial-drawer');
	var overlay = document.querySelector('.header-drawer-overlay');
	var closeButtons = document.querySelectorAll('[data-header-drawer-close]');

	if (!body || !toggle || !drawer) {
		return;
	}

	var setState = function (isOpen) {
		body.classList.toggle('has-mobile-drawer', isOpen);
		toggle.setAttribute('aria-expanded', isOpen ? 'true' : 'false');
		drawer.setAttribute('aria-hidden', isOpen ? 'false' : 'true');

		if (overlay) {
			overlay.hidden = !isOpen;
		}
	};

	toggle.addEventListener('click', function () {
		var willOpen = toggle.getAttribute('aria-expanded') !== 'true';
		setState(willOpen);
	});

	closeButtons.forEach(function (button) {
		button.addEventListener('click', function () {
			setState(false);
		});
	});

	document.addEventListener('keydown', function (event) {
		if (event.key === 'Escape') {
			setState(false);
		}
	});

	window.addEventListener('resize', function () {
		if (window.innerWidth > 860) {
			setState(false);
		}
	});

	setState(false);
})();
