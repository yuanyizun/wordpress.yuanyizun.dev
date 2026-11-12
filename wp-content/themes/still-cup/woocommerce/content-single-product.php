<?php
/**
 * Single product layout — Pencil 02 Product.
 *
 * @package Still_Cup
 * @version 3.6.0
 */

defined( 'ABSPATH' ) || exit;

global $product;

do_action( 'woocommerce_before_single_product' );

if ( post_password_required() ) {
	echo get_the_password_form(); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
	return;
}
?>
<div id="product-<?php the_ID(); ?>" <?php wc_product_class( 'sc-product grid gap-5 desktop:grid-cols-[minmax(0,690px)_minmax(0,1fr)] desktop:gap-x-[4.1rem] desktop:gap-y-5 desktop:items-start', $product ); ?>>

	<?php still_cup_product_breadcrumb(); ?>

	<div class="sc-product-gallery -mx-[var(--sc-gutter)] desktop:mx-0 w-auto desktop:w-full">
		<?php
		/**
		 * Hook: woocommerce_before_single_product_summary.
		 *
		 * @hooked woocommerce_show_product_sale_flash - 10
		 * @hooked woocommerce_show_product_images - 20
		 * @hooked still_cup_product_photo_note - 25
		 */
		do_action( 'woocommerce_before_single_product_summary' );
		?>
	</div>

	<div class="summary entry-summary w-full !float-none !m-0">
		<?php
		/**
		 * Hook: woocommerce_single_product_summary.
		 */
		do_action( 'woocommerce_single_product_summary' );
		?>
	</div>

	<div class="desktop:col-span-2 desktop:mt-8" data-sc-details>
		<?php
		/**
		 * Hook: woocommerce_after_single_product_summary.
		 *
		 * @hooked still_cup_output_product_details - 10
		 */
		do_action( 'woocommerce_after_single_product_summary' );
		?>
	</div>
</div>

<?php do_action( 'woocommerce_after_single_product' ); ?>
