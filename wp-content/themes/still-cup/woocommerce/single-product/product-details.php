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
<div class="sc-product-details" data-sc-product-details>
	<?php foreach ( $rows as $index => $row ) : ?>
		<details class="sc-product-details__row" <?php echo $index === 0 ? 'open' : ''; ?>>
			<summary class="sc-product-details__summary">
				<span class="sc-product-details__label"><?php echo esc_html( $row['label'] ); ?></span>
				<span class="sc-product-details__value"><?php echo esc_html( $row['value'] ); ?></span>
			</summary>
			<p class="sc-product-details__panel"><?php echo esc_html( $row['value'] ); ?></p>
		</details>
	<?php endforeach; ?>
</div>
