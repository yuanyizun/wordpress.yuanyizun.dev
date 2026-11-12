<?php
/**
 * Product details / care / shipping rows (Pencil product artboard).
 *
 * @package Still_Cup
 */

defined( 'ABSPATH' ) || exit;

global $product;

if ( ! $product instanceof WC_Product ) {
	return;
}

$rows = still_cup_product_detail_rows( $product );
if ( empty( $rows ) ) {
	return;
}
?>
<div class="mt-6 border-t border-border" data-sc-product-details>
	<?php foreach ( $rows as $index => $row ) : ?>
		<details class="sc-details-row border-b border-border py-[0.85rem] desktop:py-[0.9rem]" <?php echo $index === 0 ? 'open' : ''; ?>>
			<summary class="sc-details-summary grid grid-cols-1 gap-[0.35rem] desktop:grid-cols-[350px_1fr] desktop:items-baseline desktop:gap-4 list-none cursor-pointer desktop:cursor-default">
				<span class="font-display text-[18px]"><?php echo esc_html( $row['label'] ); ?></span>
				<span class="sc-details-value text-[15px] leading-[1.4]"><?php echo esc_html( $row['value'] ); ?></span>
			</summary>
			<p class="sc-details-panel hidden m-0 mt-2 text-[15px]"><?php echo esc_html( $row['value'] ); ?></p>
		</details>
	<?php endforeach; ?>
</div>
