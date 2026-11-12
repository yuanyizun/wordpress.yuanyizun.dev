<?php
/**
 * WooCommerce wrapper template.
 *
 * @package Still_Cup
 */

get_header();
?>

<div class="mx-auto max-w-[calc(var(--sc-content-max)+2*var(--sc-gutter))] px-[var(--sc-gutter)] pt-10 pb-16">
	<?php woocommerce_content(); ?>
</div>

<?php
get_footer();
