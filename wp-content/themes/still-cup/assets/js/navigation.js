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

		document.addEventListener('click', function (event) {
			var qtyBtn = event.target.closest('.sc-qty-dec, .sc-qty-inc');
			if (qtyBtn) {
				var wrap = qtyBtn.closest('.quantity');
				var input = wrap ? wrap.querySelector('input.qty') : null;
				if (input && !input.readOnly) {
					var dir = qtyBtn.classList.contains('sc-qty-dec') ? -1 : 1;
					var min = input.min === '' ? 0 : parseFloat(input.min);
					var max = input.max === '' ? Infinity : parseFloat(input.max);
					var current = parseFloat(input.value || '0');
					if (Number.isNaN(current)) current = min;
					var next = current + dir;
					if (next < min) next = min;
					if (next > max) next = max;
					if (next !== current) {
						input.value = String(next);
						input.dispatchEvent(new Event('change', { bubbles: true }));
						var cartForm = input.closest('form.woocommerce-cart-form');
						if (cartForm) {
							window.setTimeout(function () {
								var update = cartForm.querySelector('[name="update_cart"]');
								if (!update) return;
								update.disabled = false;
								update.click();
							}, 0);
						}
					}
				}
			}

			var couponBtn = event.target.closest('[data-sc-apply-coupon]');
			if (couponBtn) {
				var sourceId = couponBtn.getAttribute('data-sc-coupon-source');
				var source = sourceId ? document.getElementById(sourceId) : null;
				var real = document.getElementById('coupon_code');
				var couponForm = document.querySelector('form.checkout_coupon');
				if (source && real && couponForm) {
					real.value = source.value;
					if (window.jQuery) {
						window.jQuery(couponForm).trigger('submit');
					}
				}
			}
		});
	});
})();
