<?php
/**
 * Product card in loops — title + price row per Pencil shop/home cards.
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
<li <?php wc_product_class( 'm-0 p-0 list-none', $product ); ?>>
	<a class="flex flex-col gap-[0.65rem] no-underline text-inherit h-full" href="<?php echo esc_url( $product->get_permalink() ); ?>">
		<span class="block bg-hero overflow-hidden aspect-[422/350] sc-shop:aspect-[422/390]">
			<?php echo $product->get_image( 'woocommerce_thumbnail', array( 'class' => 'w-full h-full object-cover' ) ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
		</span>
		<span class="flex flex-col gap-[0.35rem]">
			<span class="flex items-baseline justify-between gap-3">
				<span class="font-display text-[19px] desktop:text-[20px] sc-shop:desktop:text-[24px] leading-[1.25]"><?php echo esc_html( $product->get_name() ); ?></span>
				<span class="text-[14px] desktop:text-[15px] whitespace-nowrap"><?php echo wp_kses_post( $product->get_price_html() ); ?></span>
			</span>
			<?php
			$finishes = still_cup_product_finish_labels( $product );
			if ( ! empty( $finishes ) ) :
				$count = count( $finishes );
				?>
				<span class="block text-[14px] text-muted">
					<?php
					echo esc_html(
						sprintf(
							/* translators: %d: number of finishes */
							_n( '%d finish available', '%d finishes available', $count, 'still-cup' ),
							$count
						)
					);
					?>
				</span>
			<?php endif; ?>
		</span>
	</a>
</li>
