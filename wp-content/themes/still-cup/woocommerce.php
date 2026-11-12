<?php
/**
 * WooCommerce wrapper template.
 *
 * @package Still_Cup
 */

get_header();
?>

<div class="sc-woo-page">
	<?php woocommerce_content(); ?>
</div>

<?php
get_footer();
