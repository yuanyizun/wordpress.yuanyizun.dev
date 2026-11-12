<?php
/**
 * Homepage template — editable via Customizer + featured products.
 *
 * @package Still_Cup
 */

get_header();

$shop_url = still_cup_shop_url();
$cta_url  = still_cup_mod( 'still_cup_hero_cta_url', '' );
if ( $cta_url === '' ) {
	$cta_url = $shop_url;
}

$story_url = still_cup_mod( 'still_cup_story_link_url', '/our-story/' );
if ( str_starts_with( $story_url, '/' ) ) {
	$story_url = home_url( $story_url );
}

$hero_image_id = (int) get_theme_mod( 'still_cup_hero_image', 0 );
?>

<section class="sc-hero" aria-label="<?php esc_attr_e( 'Hero', 'still-cup' ); ?>">
	<div class="sc-hero__copy">
		<p class="sc-hero__eyebrow"><?php echo esc_html( still_cup_mod( 'still_cup_hero_eyebrow', __( 'Handmade ceramic cups', 'still-cup' ) ) ); ?></p>
		<h1 class="sc-hero__heading"><?php echo esc_html( still_cup_mod( 'still_cup_hero_heading', __( 'Still mornings, considered cups', 'still-cup' ) ) ); ?></h1>
		<p class="sc-hero__text"><?php echo esc_html( still_cup_mod( 'still_cup_hero_text', __( 'Quiet forms and calm finishes for everyday rituals across Australia.', 'still-cup' ) ) ); ?></p>
		<a class="sc-button sc-hero__cta" href="<?php echo esc_url( $cta_url ); ?>">
			<?php echo esc_html( still_cup_mod( 'still_cup_hero_cta', __( 'Shop collection', 'still-cup' ) ) ); ?>
		</a>
	</div>
	<figure class="sc-hero__media">
		<?php if ( $hero_image_id ) : ?>
			<?php echo wp_get_attachment_image( $hero_image_id, 'large', false, array( 'class' => 'sc-hero__image', 'alt' => '' ) ); ?>
		<?php else : ?>
			<div class="sc-hero__placeholder" aria-hidden="true"></div>
		<?php endif; ?>
		<figcaption class="sc-hero__caption"><?php echo esc_html( still_cup_mod( 'still_cup_hero_caption', __( 'Studio light on sand finish', 'still-cup' ) ) ); ?></figcaption>
	</figure>
</section>

<p class="sc-benefits"><?php echo esc_html( still_cup_mod( 'still_cup_benefits', __( 'Made in small batches  ·  Thoughtful finishes  ·  Ships Australia-wide', 'still-cup' ) ) ); ?></p>

<section class="sc-featured" aria-labelledby="sc-featured-heading">
	<div class="sc-featured__intro">
		<p class="sc-featured__eyebrow"><?php echo esc_html( still_cup_mod( 'still_cup_featured_eyebrow', __( 'Featured', 'still-cup' ) ) ); ?></p>
		<h2 id="sc-featured-heading" class="sc-featured__heading"><?php echo esc_html( still_cup_mod( 'still_cup_featured_heading', __( 'Cups for the slow hours', 'still-cup' ) ) ); ?></h2>
		<a class="sc-featured__link" href="<?php echo esc_url( $shop_url ); ?>"><?php esc_html_e( 'Shop all', 'still-cup' ); ?></a>
	</div>

	<?php if ( class_exists( 'WooCommerce' ) ) : ?>
		<?php
		$featured = new WP_Query(
			array(
				'post_type'      => 'product',
				'posts_per_page' => 3,
				'post_status'    => 'publish',
				'tax_query'      => array( // phpcs:ignore WordPress.DB.SlowDBQuery.slow_db_query_tax_query
					array(
						'taxonomy' => 'product_visibility',
						'field'    => 'name',
						'terms'    => 'featured',
					),
				),
			)
		);

		if ( ! $featured->have_posts() ) {
			$featured = new WP_Query(
				array(
					'post_type'      => 'product',
					'posts_per_page' => 3,
					'post_status'    => 'publish',
					'orderby'        => 'date',
					'order'          => 'DESC',
				)
			);
		}
		?>

		<?php if ( $featured->have_posts() ) : ?>
			<ul class="sc-product-grid sc-product-grid--featured">
				<?php
				while ( $featured->have_posts() ) {
					$featured->the_post();
					wc_get_template_part( 'content', 'product' );
				}
				wp_reset_postdata();
				?>
			</ul>
		<?php else : ?>
			<p class="sc-featured__empty">
				<?php esc_html_e( 'Featured products will appear here once the catalogue is added. Mark products as Featured in WooCommerce, or they will fall back to the latest products.', 'still-cup' ); ?>
			</p>
			<p><a class="sc-button" href="<?php echo esc_url( $shop_url ); ?>"><?php esc_html_e( 'Browse shop', 'still-cup' ); ?></a></p>
		<?php endif; ?>
	<?php endif; ?>
</section>

<section class="sc-story" aria-labelledby="sc-story-heading">
	<div class="sc-story__inner">
		<div class="sc-story__lead">
			<p class="sc-story__eyebrow"><?php echo esc_html( still_cup_mod( 'still_cup_story_eyebrow', __( 'Our story', 'still-cup' ) ) ); ?></p>
			<h2 id="sc-story-heading" class="sc-story__heading"><?php echo esc_html( still_cup_mod( 'still_cup_story_heading', __( 'Clay, patience, and a quieter table', 'still-cup' ) ) ); ?></h2>
		</div>
		<div class="sc-story__copy">
			<p><?php echo esc_html( still_cup_mod( 'still_cup_story_text', __( 'Still Cup is a small Australian brand making ceramic cups meant to be held, used, and kept.', 'still-cup' ) ) ); ?></p>
			<a class="sc-story__link" href="<?php echo esc_url( $story_url ); ?>">
				<?php echo esc_html( still_cup_mod( 'still_cup_story_link_label', __( 'Read our story', 'still-cup' ) ) ); ?>
			</a>
		</div>
	</div>
</section>

<?php
get_footer();
