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

$on_home  = is_front_page();
$finishes = still_cup_product_finish_labels( $product );
?>
<li <?php wc_product_class( 'm-0 p-0 list-none', $product ); ?>>
	<a class="flex flex-col gap-3 no-underline text-inherit h-full" href="<?php echo esc_url( $product->get_permalink() ); ?>">
		<span class="<?php echo esc_attr( $on_home ? 'block bg-hero overflow-hidden aspect-[168/210] desktop:aspect-[422/350]' : 'block bg-hero overflow-hidden aspect-[422/390]' ); ?>">
			<?php echo $product->get_image( 'woocommerce_thumbnail', array( 'class' => 'w-full h-full object-cover' ) ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
		</span>
		<span class="flex flex-col gap-1">
			<?php if ( $on_home ) : ?>
				<span class="flex flex-col gap-1 desktop:flex-row desktop:items-baseline desktop:justify-between desktop:gap-3">
					<span class="font-display text-[19px] desktop:text-[20px] leading-[1.25]"><?php echo esc_html( $product->get_name() ); ?></span>
					<span class="text-[14px] desktop:text-[15px] leading-[1.25] whitespace-nowrap"><?php echo wp_kses_post( $product->get_price_html() ); ?></span>
				</span>
				<?php if ( ! empty( $finishes ) ) : ?>
					<span class="hidden desktop:block text-[14px] leading-[1.2]"><?php echo esc_html( implode( ' / ', $finishes ) ); ?></span>
				<?php endif; ?>
			<?php else : ?>
				<span class="flex items-baseline justify-between gap-3">
					<span class="font-display text-[20px] desktop:text-[24px] leading-[1.25]"><?php echo esc_html( $product->get_name() ); ?></span>
					<span class="text-[15px] leading-[1.25] whitespace-nowrap"><?php echo wp_kses_post( $product->get_price_html() ); ?></span>
				</span>
				<?php if ( ! empty( $finishes ) ) : ?>
					<span class="block text-[14px] leading-[1.25]">
						<?php
						echo esc_html(
							sprintf(
								/* translators: %d: number of finishes */
								_n( '%d finish available', '%d finishes available', count( $finishes ), 'still-cup' ),
								count( $finishes )
							)
						);
						?>
					</span>
				<?php endif; ?>
			<?php endif; ?>
		</span>
	</a>
</li>
