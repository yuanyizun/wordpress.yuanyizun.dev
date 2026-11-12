/**
 * Still Cup product page — finish swatches, capacity chips, details accordion.
 */
(function ($) {
	'use strict';

	function finishColor(label) {
		var map = { sand: '#CBB89E', olive: '#7F8D70', chalk: '#E5E0D7' };
		var key = String(label || '').toLowerCase().trim();
		return map[key] || '#CFCFC4';
	}

	var optionBase =
		'inline-flex items-center justify-center min-h-touch cursor-pointer font-body text-primary border-0 bg-transparent';
	var swatchBtn =
		optionBase + ' flex-col gap-[0.35rem] min-w-touch p-0 text-[13px]';
	var chipBtn =
		optionBase + ' px-4 border border-border bg-surface text-[14px]';
	var swatchVisual =
		'block w-10 h-10 rounded-full border border-border box-border';
	var nativeHidden =
		'sc-variation-native absolute! w-px! h-px! p-0! -m-px! overflow-hidden! border-0!';

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
			var $wrap = $('<div class="flex flex-wrap gap-3 my-2 mb-4" role="listbox" />');

			$select.find('option').each(function () {
				var value = $(this).attr('value');
				if (!value) return;
				var text = $(this).text();
				var selected = $select.val() === value;
				var unavailable = $(this).is(':disabled');
				var $btn = $('<button type="button" role="option" />')
					.attr('aria-selected', selected ? 'true' : 'false')
					.attr('data-value', value)
					.attr('aria-label', text)
					.toggleClass('is-selected', selected)
					.toggleClass('is-unavailable', unavailable);

				if (unavailable) {
					$btn.prop('disabled', true).attr('aria-disabled', 'true');
				}

				if (isFinish) {
					$btn.addClass(swatchBtn + ' sc-swatch');
					$btn.append(
						$('<span class="' + swatchVisual + ' sc-swatch-visual" aria-hidden="true" />').css(
							'background',
							finishColor(text)
						)
					);
					$btn.append($('<span />').text(text));
				} else {
					$btn.addClass(chipBtn + ' sc-chip');
					$btn.text(text);
				}

				$wrap.append($btn);
			});

			$select.addClass(nativeHidden + ' absolute w-px h-px p-0 -m-px overflow-hidden border-0').css({
				position: 'absolute',
				width: '1px',
				height: '1px',
				padding: '0',
				margin: '-1px',
				overflow: 'hidden',
				clip: 'rect(0, 0, 0, 0)',
				border: '0',
			}).after($wrap);

			$wrap.on('click', 'button[role="option"]', function () {
				var $btn = $(this);
				if ($btn.prop('disabled')) return;
				var value = $btn.data('value');
				$select.val(String(value)).trigger('change');
				$wrap.find('button[role="option"]').removeClass('is-selected').attr('aria-selected', 'false');
				$btn.addClass('is-selected').attr('aria-selected', 'true');
			});

			$select.on('change', function () {
				var value = $select.val();
				$wrap.find('button[role="option"]').each(function () {
					var on = String($(this).data('value')) === String(value);
					$(this).toggleClass('is-selected', on).attr('aria-selected', on ? 'true' : 'false');
				});
			});
		});
	}

	function setupDetailsAccordion() {
		var root = document.querySelector('[data-sc-product-details]');
		if (!root) return;

		var rows = root.querySelectorAll('.sc-details-row');

		function isMobile() {
			return window.matchMedia('(max-width: 1023px)').matches;
		}

		function applyMode() {
			var mobile = isMobile();
			root.toggleAttribute('data-accordion', mobile);
			rows.forEach(function (row, index) {
				if (!mobile) {
					row.setAttribute('open', '');
				} else if (index > 0) {
					row.removeAttribute('open');
				}
			});
		}

		applyMode();
		window.addEventListener('resize', applyMode);
	}

	$(function () {
		var $form = $('form.variations_form');
		if ($form.length) {
			enhanceVariations($form);
			$form.on('woocommerce_update_variation_values reset_data', function () {
				$form.find('table.variations select').each(function () {
					var $select = $(this);
					var $wrap = $select.next('[role="listbox"]');
					if (!$wrap.length) return;
					$wrap.find('button[role="option"]').each(function () {
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
