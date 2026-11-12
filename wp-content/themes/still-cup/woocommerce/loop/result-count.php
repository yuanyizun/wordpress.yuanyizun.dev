<?php
/**
 * Result count — Pencil shop “N products”.
 *
 * @package Still_Cup
 * @version 3.7.0
 */

defined( 'ABSPATH' ) || exit;

$total = (int) wc_get_loop_prop( 'total' );
if ( $total < 1 ) {
	return;
}
?>
<p class="woocommerce-result-count sc-shop-count">
	<?php
	echo esc_html(
		sprintf(
			/* translators: %d: product count */
			_n( '%d product', '%d products', $total, 'still-cup' ),
			$total
		)
	);
	?>
</p>
