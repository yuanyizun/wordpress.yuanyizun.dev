<?php
/**
 * Empty cart.
 *
 * @package Still_Cup
 * @version 7.0.1
 */

defined( 'ABSPATH' ) || exit;

/*
 * @hooked wc_empty_cart_message - 10
 */
do_action( 'woocommerce_cart_is_empty' );

if ( wc_get_page_id( 'shop' ) > 0 ) :
	?>
	<p class="sc-bag-empty">
		<a class="sc-button" href="<?php echo esc_url( apply_filters( 'woocommerce_return_to_shop_redirect', wc_get_page_permalink( 'shop' ) ) ); ?>">
			<?php esc_html_e( 'Shop cups', 'still-cup' ); ?>
		</a>
	</p>
	<?php
endif;
