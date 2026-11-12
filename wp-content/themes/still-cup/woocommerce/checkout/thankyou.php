<?php
/**
 * Thank you / order result.
 *
 * @package Still_Cup
 * @version 8.1.0
 */

defined( 'ABSPATH' ) || exit;

$btn       = 'inline-flex items-center justify-center min-h-touch px-5 border-0 bg-primary text-inverse font-body text-[15px] no-underline cursor-pointer hover:opacity-[0.92] hover:text-inverse';
$btn_ghost = 'inline-flex items-center justify-center min-h-touch px-5 bg-transparent text-primary border border-border font-body text-[15px] no-underline cursor-pointer';
$notice    = 'font-display text-[clamp(1.75rem,4vw,2.5rem)] leading-[1.25]';
?>

<div class="woocommerce-order max-w-[40rem]">

	<?php
	if ( $order ) :

		do_action( 'woocommerce_before_thankyou', $order->get_id() );
		?>

		<?php if ( $order->has_status( 'failed' ) ) : ?>

			<p class="woocommerce-notice woocommerce-notice--error woocommerce-thankyou-order-failed <?php echo esc_attr( $notice ); ?>">
				<?php esc_html_e( 'Your payment could not be completed. Please try again or choose another method.', 'still-cup' ); ?>
			</p>

			<p class="woocommerce-notice woocommerce-notice--error woocommerce-thankyou-order-failed-actions">
				<a href="<?php echo esc_url( $order->get_checkout_payment_url() ); ?>" class="button pay <?php echo esc_attr( $btn ); ?>"><?php esc_html_e( 'Try again', 'still-cup' ); ?></a>
				<?php if ( is_user_logged_in() ) : ?>
					<a href="<?php echo esc_url( wc_get_page_permalink( 'myaccount' ) ); ?>" class="button pay <?php echo esc_attr( $btn_ghost ); ?>"><?php esc_html_e( 'My account', 'still-cup' ); ?></a>
				<?php endif; ?>
			</p>

		<?php elseif ( ! $order->has_status( array( 'completed', 'processing' ) ) && ! $order->is_paid() ) : ?>

			<p class="woocommerce-notice woocommerce-notice--info <?php echo esc_attr( $notice ); ?>">
				<?php esc_html_e( 'Your order is received and payment confirmation is still pending. We will email you when it is confirmed.', 'still-cup' ); ?>
			</p>
			<ul class="woocommerce-order-overview woocommerce-thankyou-order-details order_details m-0 my-6 p-0 list-none grid gap-3">
				<li class="woocommerce-order-overview__order order">
					<?php esc_html_e( 'Order number:', 'woocommerce' ); ?>
					<strong><?php echo esc_html( $order->get_order_number() ); ?></strong>
				</li>
			</ul>

		<?php else : ?>

			<p class="woocommerce-notice woocommerce-notice--success <?php echo esc_attr( $notice ); ?>">
				<?php esc_html_e( 'Thank you. Your order is confirmed.', 'still-cup' ); ?>
			</p>
			<p>
				<?php esc_html_e( 'A confirmation email is on its way with your order details.', 'still-cup' ); ?>
			</p>
			<p>
				<?php esc_html_e( 'Dispatch estimate: 2–3 business days, then standard delivery about 3–7 business days (Australia).', 'still-cup' ); ?>
			</p>

			<ul class="woocommerce-order-overview woocommerce-thankyou-order-details order_details m-0 my-6 p-0 list-none grid gap-3">
				<li class="woocommerce-order-overview__order order">
					<?php esc_html_e( 'Order number:', 'woocommerce' ); ?>
					<strong><?php echo esc_html( $order->get_order_number() ); ?></strong>
				</li>
				<li class="woocommerce-order-overview__date date">
					<?php esc_html_e( 'Date:', 'woocommerce' ); ?>
					<strong><?php echo esc_html( wc_format_datetime( $order->get_date_created() ) ); ?></strong>
				</li>
				<?php if ( is_user_logged_in() && $order->get_user_id() === get_current_user_id() && $order->get_billing_email() ) : ?>
					<li class="woocommerce-order-overview__email email">
						<?php esc_html_e( 'Email:', 'woocommerce' ); ?>
						<strong><?php echo esc_html( $order->get_billing_email() ); ?></strong>
					</li>
				<?php endif; ?>
				<li class="woocommerce-order-overview__total total">
					<?php esc_html_e( 'Total:', 'woocommerce' ); ?>
					<strong><?php echo wp_kses_post( $order->get_formatted_order_total() ); ?></strong>
				</li>
				<?php if ( $order->get_payment_method_title() ) : ?>
					<li class="woocommerce-order-overview__payment-method method">
						<?php esc_html_e( 'Payment method:', 'woocommerce' ); ?>
						<strong><?php echo wp_kses_post( $order->get_payment_method_title() ); ?></strong>
					</li>
				<?php endif; ?>
			</ul>

		<?php endif; ?>

		<?php do_action( 'woocommerce_thankyou_' . $order->get_payment_method(), $order->get_id() ); ?>
		<?php do_action( 'woocommerce_thankyou', $order->get_id() ); ?>

	<?php else : ?>

		<p class="woocommerce-notice woocommerce-notice--success <?php echo esc_attr( $notice ); ?>">
			<?php echo esc_html( apply_filters( 'woocommerce_thankyou_order_received_text', __( 'Thank you. Your order has been received.', 'woocommerce' ), null ) ); ?>
		</p>

	<?php endif; ?>

</div>
