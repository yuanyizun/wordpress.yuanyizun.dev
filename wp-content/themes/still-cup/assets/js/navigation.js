/**
 * Still Cup — mobile menu and search panel.
 * Keyboard operable: Escape closes, focus returns to trigger.
 */
(function () {
	'use strict';

	function qs(sel, root) {
		return (root || document).querySelector(sel);
	}

	function setHidden(el, hidden) {
		if (!el) return;
		if (hidden) {
			el.setAttribute('hidden', '');
		} else {
			el.removeAttribute('hidden');
		}
	}

	function createFocusTrap(container) {
		var focusable =
			'a[href], button:not([disabled]), input:not([disabled]), select:not([disabled]), textarea:not([disabled]), [tabindex]:not([tabindex="-1"])';

		return function (event) {
			if (event.key !== 'Tab') return;
			var nodes = Array.prototype.slice.call(container.querySelectorAll(focusable)).filter(function (n) {
				return !n.hasAttribute('disabled') && n.offsetParent !== null;
			});
			if (!nodes.length) return;
			var first = nodes[0];
			var last = nodes[nodes.length - 1];
			if (event.shiftKey && document.activeElement === first) {
				event.preventDefault();
				last.focus();
			} else if (!event.shiftKey && document.activeElement === last) {
				event.preventDefault();
				first.focus();
			}
		};
	}

	document.addEventListener('DOMContentLoaded', function () {
		var menuOpen = qs('#sc-menu-open');
		var menuClose = qs('#sc-menu-close');
		var mobileNav = qs('#sc-mobile-nav');
		var searchOpen = qs('#sc-search-open');
		var searchClose = qs('#sc-search-close');
		var searchPanel = qs('#sc-search-panel');
		var searchField = qs('#sc-search-field');
		var lastFocus = null;
		var trapHandler = null;

		function closeMenu() {
			if (!mobileNav || mobileNav.hasAttribute('hidden')) return;
			setHidden(mobileNav, true);
			document.body.classList.remove('sc-menu-open');
			if (menuOpen) {
				menuOpen.setAttribute('aria-expanded', 'false');
				menuOpen.focus();
			}
			if (trapHandler) {
				mobileNav.removeEventListener('keydown', trapHandler);
				trapHandler = null;
			}
		}

		function openMenu() {
			if (!mobileNav) return;
			lastFocus = document.activeElement;
			setHidden(mobileNav, false);
			document.body.classList.add('sc-menu-open');
			if (menuOpen) menuOpen.setAttribute('aria-expanded', 'true');
			trapHandler = createFocusTrap(mobileNav);
			mobileNav.addEventListener('keydown', trapHandler);
			if (menuClose) menuClose.focus();
		}

		function closeSearch() {
			if (!searchPanel || searchPanel.hasAttribute('hidden')) return;
			setHidden(searchPanel, true);
			if (searchOpen) {
				searchOpen.setAttribute('aria-expanded', 'false');
				searchOpen.focus();
			}
		}

		function openSearch() {
			if (!searchPanel) return;
			setHidden(searchPanel, false);
			if (searchOpen) searchOpen.setAttribute('aria-expanded', 'true');
			if (searchField) searchField.focus();
		}

		if (menuOpen) menuOpen.addEventListener('click', openMenu);
		if (menuClose) menuClose.addEventListener('click', closeMenu);
		if (searchOpen) searchOpen.addEventListener('click', openSearch);
		if (searchClose) searchClose.addEventListener('click', closeSearch);

		document.addEventListener('keydown', function (event) {
			if (event.key !== 'Escape') return;
			closeMenu();
			closeSearch();
		});

		if (mobileNav) {
			mobileNav.addEventListener('click', function (event) {
				if (event.target === mobileNav) closeMenu();
			});
		}
	});
})();
