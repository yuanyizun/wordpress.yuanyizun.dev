<?php
/**
 * Product card in loops.
 *
 * @package Still_Cup
 * @version 9.4.0
 */

defined( 'ABSPATH' ) || exit;

global $product;

if ( ! is_a( $product, WC_Product::class ) || ! $product->is_visible() ) {
	return;
}
?>
<li <?php wc_product_class( 'sc-card', $product ); ?>>
	<a class="sc-card__link" href="<?php echo esc_url( $product->get_permalink() ); ?>">
		<span class="sc-card__media">
			<?php echo $product->get_image( 'woocommerce_thumbnail', array( 'class' => 'sc-card__image' ) ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
		</span>
		<span class="sc-card__body">
			<span class="sc-card__title"><?php echo esc_html( $product->get_name() ); ?></span>
			<span class="sc-card__price"><?php echo wp_kses_post( $product->get_price_html() ); ?></span>
			<?php
			$finishes = still_cup_product_finish_labels( $product );
			if ( ! empty( $finishes ) ) :
				?>
				<span class="sc-card__finishes"><?php echo esc_html( implode( ', ', $finishes ) ); ?></span>
			<?php endif; ?>
		</span>
	</a>
</li>
