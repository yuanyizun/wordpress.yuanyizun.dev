/**
 * Still Cup product page — finish swatches, capacity buttons, mobile details accordion.
 */
(function ($) {
	'use strict';

	function finishColor(label) {
		var map = { sand: '#CBB89E', olive: '#7F8D70', chalk: '#E5E0D7' };
		var key = String(label || '').toLowerCase().trim();
		return map[key] || '#CFCFC4';
	}

	function enhanceVariations($form) {
		$form.find('table.variations select').each(function () {
			var $select = $(this);
			if ($select.data('scEnhanced')) return;

			var name = ($select.attr('name') || '').toLowerCase();
			var $row = $select.closest('tr');
			var labelText = $row.find('label').text().toLowerCase();
			var isFinish = /finish|colour|color/.test(name + ' ' + labelText);
			var isCapacity = /capacity|size|volume/.test(name + ' ' + labelText);

			if (!isFinish && !isCapacity) return;

			$select.data('scEnhanced', true);
			var $wrap = $('<div class="sc-variation-ui" role="listbox" />');
			if (isFinish) $wrap.addClass('sc-variation-ui--finish');
			if (isCapacity) $wrap.addClass('sc-variation-ui--capacity');

			$select.find('option').each(function () {
				var value = $(this).attr('value');
				if (!value) return;
				var text = $(this).text();
				var $btn = $('<button type="button" class="sc-variation-ui__option" />')
					.attr('role', 'option')
					.attr('aria-selected', $select.val() === value ? 'true' : 'false')
					.attr('data-value', value)
					.attr('aria-label', text);

				if (isFinish) {
					$btn.addClass('sc-variation-ui__swatch');
					$btn.css('--sc-swatch', finishColor(text));
					$btn.append($('<span class="sc-variation-ui__swatch-visual" aria-hidden="true" />'));
					$btn.append($('<span class="sc-variation-ui__swatch-label" />').text(text));
				} else {
					$btn.addClass('sc-variation-ui__chip').text(text);
				}

				if ($select.val() === value) $btn.addClass('is-selected');
				if ($(this).is(':disabled')) {
					$btn.prop('disabled', true).addClass('is-unavailable').attr('aria-disabled', 'true');
				}

				$wrap.append($btn);
			});

			$select.addClass('sc-variation-ui__native').after($wrap);

			$wrap.on('click', '.sc-variation-ui__option', function () {
				var $btn = $(this);
				if ($btn.prop('disabled')) return;
				var value = $btn.data('value');
				$select.val(String(value)).trigger('change');
				$wrap.find('.sc-variation-ui__option').removeClass('is-selected').attr('aria-selected', 'false');
				$btn.addClass('is-selected').attr('aria-selected', 'true');
			});

			$select.on('change', function () {
				var value = $select.val();
				$wrap.find('.sc-variation-ui__option').each(function () {
					var on = String($(this).data('value')) === String(value);
					$(this).toggleClass('is-selected', on).attr('aria-selected', on ? 'true' : 'false');
				});
			});
		});
	}

	function setupDetailsAccordion() {
		var root = document.querySelector('[data-sc-details]');
		if (!root) return;
		var panels = root.querySelectorAll('.woocommerce-Tabs-panel, .wc-tab');
		var titles = root.querySelectorAll('.woocommerce-tabs ul.tabs li a, .wc-tabs li a');

		function isMobile() {
			return window.matchMedia('(max-width: 1023px)').matches;
		}

		function applyMode() {
			if (!isMobile()) {
				root.classList.remove('sc-details--accordion');
				return;
			}
			root.classList.add('sc-details--accordion');
		}

		applyMode();
		window.addEventListener('resize', applyMode);

		// Keyboard-friendly: ensure tab links are buttons-like with Enter.
		titles.forEach(function (link) {
			link.addEventListener('keydown', function (event) {
				if (event.key === 'Enter' || event.key === ' ') {
					event.preventDefault();
					link.click();
				}
			});
		});

		void panels;
	}

	$(function () {
		var $form = $('form.variations_form');
		if ($form.length) {
			enhanceVariations($form);
			$form.on('woocommerce_update_variation_values reset_data', function () {
				// Re-sync disabled state after Woo updates options.
				$form.find('table.variations select').each(function () {
					var $select = $(this);
					var $wrap = $select.next('.sc-variation-ui');
					if (!$wrap.length) return;
					$wrap.find('.sc-variation-ui__option').each(function () {
						var value = String($(this).data('value'));
						var $opt = $select.find('option[value="' + value.replace(/"/g, '\\"') + '"]');
						var disabled = !$opt.length || $opt.is(':disabled');
						$(this).prop('disabled', disabled).toggleClass('is-unavailable', disabled).attr('aria-disabled', disabled ? 'true' : 'false');
					});
				});
			});
		}
		setupDetailsAccordion();
	});
})(jQuery);
