<?php
/**
 * Bag order summary (Pencil 04 Bag).
 *
 * @package Still_Cup
 * @version 2.3.6
 */

defined( 'ABSPATH' ) || exit;

$shipping_live     = WC()->cart->needs_shipping() && WC()->cart->show_shipping();
$estimate_shipping = (float) apply_filters( 'still_cup_estimated_shipping', 9.95 );
$using_estimate    = ! $shipping_live;
?>
<div class="cart_totals sc-bag-summary <?php echo ( WC()->customer->has_calculated_shipping() ) ? 'calculated_shipping' : ''; ?>">

	<?php do_action( 'woocommerce_before_cart_totals' ); ?>

	<h2 class="sc-bag-summary__title"><?php esc_html_e( 'Order summary', 'still-cup' ); ?></h2>

	<table cellspacing="0" class="shop_table sc-bag-summary__table">

		<tr class="cart-subtotal">
			<th><?php esc_html_e( 'Subtotal', 'still-cup' ); ?></th>
			<td data-title="<?php esc_attr_e( 'Subtotal', 'still-cup' ); ?>"><?php wc_cart_totals_subtotal_html(); ?></td>
		</tr>

		<?php foreach ( WC()->cart->get_coupons() as $code => $coupon ) : ?>
			<tr class="cart-discount coupon-<?php echo esc_attr( sanitize_title( $code ) ); ?>">
				<th><?php wc_cart_totals_coupon_label( $coupon ); ?></th>
				<td data-title="<?php echo esc_attr( wc_cart_totals_coupon_label( $coupon, false ) ); ?>"><?php wc_cart_totals_coupon_html( $coupon ); ?></td>
			</tr>
		<?php endforeach; ?>

		<?php if ( $shipping_live ) : ?>

			<?php do_action( 'woocommerce_cart_totals_before_shipping' ); ?>

			<?php wc_cart_totals_shipping_html(); ?>

			<?php do_action( 'woocommerce_cart_totals_after_shipping' ); ?>

		<?php else : ?>

			<tr class="shipping">
				<th><?php esc_html_e( 'Standard shipping', 'still-cup' ); ?></th>
				<td data-title="<?php esc_attr_e( 'Shipping', 'still-cup' ); ?>">
					<?php echo wp_kses_post( wc_price( $estimate_shipping ) ); ?>
					<small class="sc-bag-summary__note"><?php esc_html_e( 'Estimate · confirmed at checkout', 'still-cup' ); ?></small>
				</td>
			</tr>

		<?php endif; ?>

		<?php foreach ( WC()->cart->get_fees() as $fee ) : ?>
			<tr class="fee">
				<th><?php echo esc_html( $fee->name ); ?></th>
				<td data-title="<?php echo esc_attr( $fee->name ); ?>"><?php wc_cart_totals_fee_html( $fee ); ?></td>
			</tr>
		<?php endforeach; ?>

		<?php
		if ( wc_tax_enabled() && ! WC()->cart->display_prices_including_tax() ) {
			$taxable_address = WC()->customer->get_taxable_address();
			$estimated_text  = '';

			if ( WC()->customer->is_customer_outside_base() && ! WC()->customer->has_calculated_shipping() ) {
				$estimated_text = sprintf( ' <small>' . esc_html__( '(estimated for %s)', 'woocommerce' ) . '</small>', WC()->countries->estimated_for_prefix( $taxable_address[0] ) . WC()->countries->countries[ $taxable_address[0] ] );
			}

			if ( 'itemized' === get_option( 'woocommerce_tax_total_display' ) ) {
				foreach ( WC()->cart->get_tax_totals() as $code => $tax ) { // phpcs:ignore WordPress.WP.GlobalVariablesOverride.Prohibited
					?>
					<tr class="tax-rate tax-rate-<?php echo esc_attr( sanitize_title( $code ) ); ?>">
						<th><?php echo esc_html( $tax->label ) . $estimated_text; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?></th>
						<td data-title="<?php echo esc_attr( $tax->label ); ?>"><?php echo wp_kses_post( $tax->formatted_amount ); ?></td>
					</tr>
					<?php
				}
			} else {
				?>
				<tr class="tax-total">
					<th><?php echo esc_html( WC()->countries->tax_or_vat() ) . $estimated_text; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?></th>
					<td data-title="<?php echo esc_attr( WC()->countries->tax_or_vat() ); ?>"><?php wc_cart_totals_taxes_total_html(); ?></td>
				</tr>
				<?php
			}
		}
		?>

		<?php do_action( 'woocommerce_cart_totals_before_order_total' ); ?>

		<tr class="order-total">
			<th><?php esc_html_e( 'Estimated total', 'still-cup' ); ?></th>
			<td data-title="<?php esc_attr_e( 'Estimated total', 'still-cup' ); ?>">
				<?php
				if ( $using_estimate ) {
					$subtotal = (float) WC()->cart->get_displayed_subtotal();
					if ( WC()->cart->display_prices_including_tax() ) {
						$subtotal = (float) WC()->cart->get_subtotal() + (float) WC()->cart->get_subtotal_tax();
					} else {
						$subtotal = (float) WC()->cart->get_subtotal();
					}
					foreach ( WC()->cart->get_coupons() as $coupon ) {
						$subtotal -= (float) WC()->cart->get_coupon_discount_amount( $coupon->get_code(), WC()->cart->display_cart_ex_tax );
					}
					echo wp_kses_post( wc_price( max( 0, $subtotal ) + $estimate_shipping ) );
				} else {
					wc_cart_totals_order_total_html();
				}
				?>
			</td>
		</tr>

		<?php do_action( 'woocommerce_cart_totals_after_order_total' ); ?>

	</table>

	<div class="wc-proceed-to-checkout">
		<?php do_action( 'woocommerce_proceed_to_checkout' ); ?>
	</div>

	<?php do_action( 'woocommerce_after_cart_totals' ); ?>

</div>
