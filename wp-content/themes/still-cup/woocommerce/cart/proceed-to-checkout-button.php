<?php
/**
 * Proceed to checkout — Pencil bag CTA copy.
 *
 * @package Still_Cup
 * @version 7.0.1
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
?>
<a href="<?php echo esc_url( wc_get_checkout_url() ); ?>" class="checkout-button button alt wc-forward !flex !w-full max-w-full justify-center items-center min-h-[52px] whitespace-nowrap !px-4 text-[15px] leading-tight no-underline box-border !float-none bg-primary !text-inverse<?php echo esc_attr( wc_wp_theme_get_element_class_name( 'button' ) ? ' ' . wc_wp_theme_get_element_class_name( 'button' ) : '' ); ?>">
	<?php esc_html_e( 'Checkout', 'still-cup' ); ?>
</a>
