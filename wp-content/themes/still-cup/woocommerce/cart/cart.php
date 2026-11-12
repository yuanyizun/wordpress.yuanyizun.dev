<?php
/**
 * Bag page — Pencil 04 Bag layout.
 *
 * @package Still_Cup
 * @version 11.3.0
 */

defined( 'ABSPATH' ) || exit;

$count = WC()->cart ? (int) WC()->cart->get_cart_contents_count() : 0;

do_action( 'woocommerce_before_cart' );
?>
<div class="sc-bag">
	<header class="sc-bag__header">
		<h1 class="sc-bag__title"><?php esc_html_e( 'Your bag', 'still-cup' ); ?></h1>
		<p class="sc-bag__subtitle">
			<?php
			echo esc_html(
				$count === 1
					? __( 'One good thing for your everyday.', 'still-cup' )
					: sprintf(
						/* translators: %d: number of items */
						_n( '%d items in your bag.', '%d items in your bag.', $count, 'still-cup' ),
						$count
					)
			);
			?>
		</p>
	</header>

	<div class="sc-bag__layout">
		<div class="sc-bag__main">
			<form class="woocommerce-cart-form sc-bag__form" action="<?php echo esc_url( wc_get_cart_url() ); ?>" method="post">
				<?php do_action( 'woocommerce_before_cart_table' ); ?>

				<ul class="sc-bag__items shop_table shop_table_responsive cart woocommerce-cart-form__contents" role="list">
					<?php do_action( 'woocommerce_before_cart_contents' ); ?>

					<?php
					foreach ( WC()->cart->get_cart() as $cart_item_key => $cart_item ) {
						$_product   = apply_filters( 'woocommerce_cart_item_product', $cart_item['data'], $cart_item, $cart_item_key );
						$product_id = apply_filters( 'woocommerce_cart_item_product_id', $cart_item['product_id'], $cart_item, $cart_item_key );
						$visible    = apply_filters( 'woocommerce_cart_item_visible', true, $cart_item, $cart_item_key );

						if ( ! ( $_product instanceof WC_Product ) || ! $_product->exists() || $cart_item['quantity'] <= 0 || ! $visible ) {
							continue;
						}

						$cart_item_name    = WC()->cart->get_item_product_name( $cart_item, $_product );
						$product_name      = apply_filters( 'woocommerce_cart_item_name', $cart_item_name, $cart_item, $cart_item_key );
						$product_permalink = apply_filters( 'woocommerce_cart_item_permalink', $_product->is_visible() ? $_product->get_permalink( $cart_item ) : '', $cart_item, $cart_item_key );
						$thumbnail         = apply_filters( 'woocommerce_cart_item_thumbnail', $_product->get_image( 'woocommerce_thumbnail', array( 'class' => 'sc-bag__thumb-img' ) ), $cart_item, $cart_item_key );
						?>
						<li class="sc-bag__item woocommerce-cart-form__cart-item <?php echo esc_attr( apply_filters( 'woocommerce_cart_item_class', 'cart_item', $cart_item, $cart_item_key ) ); ?>">
							<div class="sc-bag__thumb">
								<?php
								if ( ! $product_permalink ) {
									echo $thumbnail; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
								} else {
									printf( '<a href="%s">%s</a>', esc_url( $product_permalink ), $thumbnail ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
								}
								?>
							</div>

							<div class="sc-bag__info">
								<p class="sc-bag__name" data-title="<?php esc_attr_e( 'Product', 'still-cup' ); ?>">
									<?php
									if ( ! $product_permalink ) {
										echo wp_kses_post( $product_name );
									} else {
										echo wp_kses_post( apply_filters( 'woocommerce_cart_item_name', sprintf( '<a href="%s">%s</a>', esc_url( $product_permalink ), $cart_item_name ), $cart_item, $cart_item_key ) );
									}
									?>
								</p>
								<?php
								do_action( 'woocommerce_after_cart_item_name', $cart_item, $cart_item_key );
								echo wc_get_formatted_cart_item_data( $cart_item ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
								?>

								<div class="sc-bag__controls">
									<div class="sc-bag__qty product-quantity" data-title="<?php esc_attr_e( 'Quantity', 'still-cup' ); ?>">
										<?php
										if ( $_product->is_sold_individually() ) {
											$min_quantity = 1;
											$max_quantity = 1;
										} else {
											$min_quantity = 0;
											$max_quantity = $_product->get_max_purchase_quantity();
										}

										$product_quantity = woocommerce_quantity_input(
											array(
												'input_name'   => "cart[{$cart_item_key}][qty]",
												'input_value'  => $cart_item['quantity'],
												'max_value'    => $max_quantity,
												'min_value'    => $min_quantity,
												'product_name' => $product_name,
											),
											$_product,
											false
										);

										echo apply_filters( 'woocommerce_cart_item_quantity', $product_quantity, $cart_item_key, $cart_item ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
										?>
									</div>

									<?php
									echo apply_filters( // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
										'woocommerce_cart_item_remove_link',
										sprintf(
											'<a href="%s" class="sc-bag__remove remove" aria-label="%s" data-product_id="%s" data-product_sku="%s">%s</a>',
											esc_url( wc_get_cart_remove_url( $cart_item_key ) ),
											esc_attr( sprintf( __( 'Remove %s from bag', 'still-cup' ), wp_strip_all_tags( $product_name ) ) ),
											esc_attr( $product_id ),
											esc_attr( $_product->get_sku() ),
											esc_html__( 'Remove', 'still-cup' )
										),
										$cart_item_key
									);
									?>
								</div>
							</div>

							<div class="sc-bag__price product-subtotal" data-title="<?php esc_attr_e( 'Subtotal', 'still-cup' ); ?>">
								<?php echo apply_filters( 'woocommerce_cart_item_subtotal', WC()->cart->get_product_subtotal( $_product, $cart_item['quantity'] ), $cart_item, $cart_item_key ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
							</div>
						</li>
						<?php
					}
					?>

					<?php do_action( 'woocommerce_cart_contents' ); ?>
					<?php do_action( 'woocommerce_after_cart_contents' ); ?>
				</ul>

				<div class="sc-bag__actions actions">
					<button type="submit" class="button sc-bag__update<?php echo esc_attr( wc_wp_theme_get_element_class_name( 'button' ) ? ' ' . wc_wp_theme_get_element_class_name( 'button' ) : '' ); ?>" name="update_cart" value="<?php esc_attr_e( 'Update bag', 'still-cup' ); ?>">
						<?php esc_html_e( 'Update bag', 'still-cup' ); ?>
					</button>
					<?php do_action( 'woocommerce_cart_actions' ); ?>
					<?php wp_nonce_field( 'woocommerce-cart', 'woocommerce-cart-nonce' ); ?>
				</div>

				<?php do_action( 'woocommerce_after_cart_table' ); ?>
			</form>

			<?php still_cup_bag_threshold_message(); ?>

			<p class="sc-bag__continue">
				<a class="sc-button sc-button--ghost" href="<?php echo esc_url( still_cup_shop_url() ); ?>">
					<?php esc_html_e( '← Continue shopping', 'still-cup' ); ?>
				</a>
			</p>

			<p class="sc-bag__tax-note"><?php esc_html_e( 'Prices include applicable tax. Final shipping confirmed at checkout.', 'still-cup' ); ?></p>
		</div>

		<?php do_action( 'woocommerce_before_cart_collaterals' ); ?>

		<aside class="cart-collaterals sc-bag__aside">
			<?php
			/**
			 * Cart collaterals hook.
			 *
			 * @hooked woocommerce_cross_sell_display
			 * @hooked woocommerce_cart_totals - 10
			 */
			do_action( 'woocommerce_cart_collaterals' );
			?>
		</aside>
	</div>
</div>
<?php do_action( 'woocommerce_after_cart' ); ?>
