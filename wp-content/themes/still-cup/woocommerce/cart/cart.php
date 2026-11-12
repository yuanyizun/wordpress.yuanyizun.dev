<?php
/**
 * Bag page — Pencil 04 Bag layout.
 *
 * @package Still_Cup
 * @version 11.3.0
 */

defined( 'ABSPATH' ) || exit;

$count = WC()->cart ? (int) WC()->cart->get_cart_contents_count() : 0;
$ghost = 'inline-flex items-center min-h-[52px] w-full desktop:w-[270px] px-5 bg-surface text-primary border-0 font-body text-[15px] leading-[1.25] no-underline cursor-pointer hover:opacity-[0.92]';

do_action( 'woocommerce_before_cart' );
?>
<div>
	<header class="mb-8">
		<h1 class="m-0 mb-2 font-display text-[40px] desktop:text-[60px] font-normal leading-[1.25]"><?php esc_html_e( 'Your bag', 'still-cup' ); ?></h1>
		<p class="m-0 text-[16px] desktop:text-[18px] leading-[1.25]">
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

	<div class="grid gap-8 desktop:grid-cols-[minmax(0,1fr)_376px] desktop:gap-14 desktop:items-start">
		<div>
			<form class="woocommerce-cart-form" action="<?php echo esc_url( wc_get_cart_url() ); ?>" method="post">
				<?php do_action( 'woocommerce_before_cart_table' ); ?>

				<ul class="sc-bag-items shop_table shop_table_responsive cart woocommerce-cart-form__contents m-0 p-0 list-none grid gap-7" role="list">
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
						$thumbnail         = apply_filters( 'woocommerce_cart_item_thumbnail', $_product->get_image( 'woocommerce_thumbnail', array( 'class' => 'w-full aspect-square object-cover bg-hero' ) ), $cart_item, $cart_item_key );
						?>
						<li class="grid grid-cols-[96px_1fr] desktop:grid-cols-[180px_minmax(0,1fr)_auto] gap-x-4 gap-y-3 desktop:gap-x-9 items-start woocommerce-cart-form__cart-item <?php echo esc_attr( apply_filters( 'woocommerce_cart_item_class', 'cart_item', $cart_item, $cart_item_key ) ); ?>">
							<div class="w-full aspect-square bg-hero">
								<?php
								if ( ! $product_permalink ) {
									echo $thumbnail; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
								} else {
									printf( '<a href="%s">%s</a>', esc_url( $product_permalink ), $thumbnail ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
								}
								?>
							</div>

							<div>
								<p class="m-0 mb-[0.35rem] font-display text-[22px] desktop:text-[28px] leading-[1.25]" data-title="<?php esc_attr_e( 'Product', 'still-cup' ); ?>">
									<?php
									if ( ! $product_permalink ) {
										echo wp_kses_post( $product_name );
									} else {
										echo wp_kses_post( apply_filters( 'woocommerce_cart_item_name', sprintf( '<a class="no-underline" href="%s">%s</a>', esc_url( $product_permalink ), $cart_item_name ), $cart_item, $cart_item_key ) );
									}
									?>
								</p>
								<?php
								do_action( 'woocommerce_after_cart_item_name', $cart_item, $cart_item_key );
								echo wc_get_formatted_cart_item_data( $cart_item ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
								?>

								<div class="flex flex-wrap items-center gap-x-6 gap-y-4 mt-3">
									<div class="product-quantity" data-title="<?php esc_attr_e( 'Quantity', 'still-cup' ); ?>">
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
											'<a href="%s" class="remove text-[14px] underline underline-offset-[0.2em] !text-primary !w-auto !h-auto !border-0 !bg-transparent !opacity-100 !inline !leading-[1.4] hover:!opacity-85 hover:!text-primary" aria-label="%s" data-product_id="%s" data-product_sku="%s">%s</a>',
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

							<div class="col-start-2 desktop:col-auto text-[18px] desktop:text-[20px] desktop:justify-self-end product-subtotal" data-title="<?php esc_attr_e( 'Subtotal', 'still-cup' ); ?>">
								<?php echo apply_filters( 'woocommerce_cart_item_subtotal', WC()->cart->get_product_subtotal( $_product, $cart_item['quantity'] ), $cart_item, $cart_item_key ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
							</div>
						</li>
						<?php
					}
					?>

					<?php do_action( 'woocommerce_cart_contents' ); ?>
					<?php do_action( 'woocommerce_after_cart_contents' ); ?>
				</ul>

				<div class="actions mt-4">
					<button type="submit" class="button !hidden<?php echo esc_attr( wc_wp_theme_get_element_class_name( 'button' ) ? ' ' . wc_wp_theme_get_element_class_name( 'button' ) : '' ); ?>" name="update_cart" value="<?php esc_attr_e( 'Update bag', 'still-cup' ); ?>">
						<?php esc_html_e( 'Update bag', 'still-cup' ); ?>
					</button>
					<?php do_action( 'woocommerce_cart_actions' ); ?>
					<?php wp_nonce_field( 'woocommerce-cart', 'woocommerce-cart-nonce' ); ?>
				</div>

				<?php do_action( 'woocommerce_after_cart_table' ); ?>
			</form>

			<?php still_cup_bag_threshold_message(); ?>

			<p class="mb-6">
				<a class="<?php echo esc_attr( $ghost ); ?>" href="<?php echo esc_url( still_cup_shop_url() ); ?>">
					<?php esc_html_e( '← Continue shopping', 'still-cup' ); ?>
				</a>
			</p>

			<p class="m-0 text-[14px] text-muted"><?php esc_html_e( 'Prices include applicable tax. Final shipping confirmed at checkout.', 'still-cup' ); ?></p>
		</div>

		<?php do_action( 'woocommerce_before_cart_collaterals' ); ?>

		<aside class="cart-collaterals !float-none !w-full desktop:!w-[376px] !m-0">
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
