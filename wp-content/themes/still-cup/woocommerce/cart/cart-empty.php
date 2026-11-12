<?php
/**
 * Empty bag — Pencil-aligned empty state.
 *
 * @package Still_Cup
 * @version 7.0.1
 */

defined( 'ABSPATH' ) || exit;

remove_action( 'woocommerce_cart_is_empty', 'wc_empty_cart_message', 10 );
?>
<div class="sc-bag sc-bag--empty">
	<header class="sc-bag__header">
		<h1 class="sc-bag__title"><?php esc_html_e( 'Your bag', 'still-cup' ); ?></h1>
		<p class="sc-bag__subtitle"><?php esc_html_e( 'One good thing for your everyday.', 'still-cup' ); ?></p>
	</header>
	<p class="sc-bag__empty-message"><?php esc_html_e( 'Your bag is empty.', 'still-cup' ); ?></p>
	<?php if ( wc_get_page_id( 'shop' ) > 0 ) : ?>
		<p class="sc-bag-empty">
			<a class="sc-button" href="<?php echo esc_url( apply_filters( 'woocommerce_return_to_shop_redirect', wc_get_page_permalink( 'shop' ) ) ); ?>">
				<?php esc_html_e( 'Shop cups', 'still-cup' ); ?>
			</a>
		</p>
	<?php endif; ?>
</div>
<?php
// Keep the empty-cart action for extensions without the default notice.
do_action( 'woocommerce_cart_is_empty' );
