<?php
/**
 * Checkout form — summary first on mobile via flex order.
 *
 * @package Still_Cup
 * @version 9.4.0
 */

defined( 'ABSPATH' ) || exit;

do_action( 'woocommerce_before_checkout_form', $checkout );

if ( ! $checkout->is_registration_enabled() && $checkout->is_registration_required() && ! is_user_logged_in() ) {
	echo esc_html( apply_filters( 'woocommerce_checkout_must_be_logged_in_message', __( 'You must be logged in to checkout.', 'woocommerce' ) ) );
	return;
}
?>

<form name="checkout" method="post" class="checkout woocommerce-checkout desktop:grid desktop:grid-cols-[minmax(0,730px)_minmax(0,476px)] desktop:items-start desktop:gap-x-16" action="<?php echo esc_url( wc_get_checkout_url() ); ?>" enctype="multipart/form-data" aria-label="<?php echo esc_attr__( 'Checkout', 'woocommerce' ); ?>">

	<header class="mb-8 desktop:col-span-2">
		<h1 class="m-0 mb-2 font-display text-[40px] desktop:text-[54px] font-normal leading-[1.25]"><?php esc_html_e( 'Checkout', 'still-cup' ); ?></h1>
		<p class="m-0 text-[14px] desktop:text-[15px] leading-[1.25]">
			<span class="hidden desktop:inline"><?php esc_html_e( 'No account needed. Already a customer?', 'still-cup' ); ?></span>
			<span class="desktop:hidden"><?php esc_html_e( 'Guest checkout ·', 'still-cup' ); ?></span>
			<a class="no-underline" href="<?php echo esc_url( still_cup_account_url() ); ?>"><?php esc_html_e( 'Sign in', 'still-cup' ); ?></a>
		</p>
	</header>

	<div class="flex flex-col gap-8 desktop:contents">
		<div>
			<?php if ( $checkout->get_checkout_fields() ) : ?>
				<?php do_action( 'woocommerce_checkout_before_customer_details' ); ?>

				<div class="col2-set" id="customer_details">
					<div class="col-1 desktop:!w-full desktop:!float-none">
						<?php do_action( 'woocommerce_checkout_billing' ); ?>
					</div>
					<div class="col-2 desktop:!w-full desktop:!float-none">
						<?php do_action( 'woocommerce_checkout_shipping' ); ?>
					</div>
				</div>

				<?php do_action( 'woocommerce_checkout_after_customer_details' ); ?>
			<?php endif; ?>
		</div>

		<aside class="order-first desktop:order-none bg-summary p-4 desktop:p-8 desktop:sticky desktop:top-4">
			<?php do_action( 'woocommerce_checkout_before_order_review_heading' ); ?>
			<h2 id="order_review_heading" class="font-display font-normal text-[18px] desktop:text-[30px] leading-[1.25] mt-0 mb-4"><?php esc_html_e( 'Your order', 'still-cup' ); ?></h2>
			<?php do_action( 'woocommerce_checkout_before_order_review' ); ?>
			<div id="order_review" class="woocommerce-checkout-review-order">
				<?php do_action( 'woocommerce_checkout_order_review' ); ?>
			</div>
			<?php do_action( 'woocommerce_checkout_after_order_review' ); ?>
		</aside>
	</div>

</form>

<?php do_action( 'woocommerce_after_checkout_form', $checkout ); ?>
