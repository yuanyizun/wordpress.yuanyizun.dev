<?php
/**
 * Empty bag — Pencil-aligned empty state.
 *
 * @package Still_Cup
 * @version 7.0.1
 */

defined( 'ABSPATH' ) || exit;

remove_action( 'woocommerce_cart_is_empty', 'wc_empty_cart_message', 10 );

$btn = 'inline-flex items-center justify-center min-h-touch px-5 border-0 bg-primary text-inverse font-body text-[15px] no-underline cursor-pointer hover:opacity-[0.92] hover:text-inverse';
?>
<div>
	<header class="mb-8">
		<h1 class="m-0 mb-2 font-display text-[clamp(2.25rem,6vw,3.75rem)] font-normal leading-[1.2]"><?php esc_html_e( 'Your bag', 'still-cup' ); ?></h1>
		<p class="m-0 text-base"><?php esc_html_e( 'One good thing for your everyday.', 'still-cup' ); ?></p>
	</header>
	<p class="m-0 text-base"><?php esc_html_e( 'Your bag is empty.', 'still-cup' ); ?></p>
	<?php if ( wc_get_page_id( 'shop' ) > 0 ) : ?>
		<p class="mt-6">
			<a class="<?php echo esc_attr( $btn ); ?>" href="<?php echo esc_url( apply_filters( 'woocommerce_return_to_shop_redirect', wc_get_page_permalink( 'shop' ) ) ); ?>">
				<?php esc_html_e( 'Shop cups', 'still-cup' ); ?>
			</a>
		</p>
	<?php endif; ?>
</div>
<?php
do_action( 'woocommerce_cart_is_empty' );
