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

$btn = 'inline-flex items-center justify-center min-h-touch px-5 border-0 bg-primary text-inverse font-body text-[15px] no-underline cursor-pointer hover:opacity-[0.92] hover:text-inverse';
?>

<section class="grid gap-6 desktop:grid-cols-2 desktop:items-end desktop:min-h-[570px] desktop:gap-0 pt-6 px-[var(--sc-gutter)] desktop:p-0 bg-hero" aria-label="<?php esc_attr_e( 'Hero', 'still-cup' ); ?>">
	<div class="desktop:px-[var(--sc-gutter)] desktop:pt-[4.5rem] desktop:pb-16">
		<p class="m-0 mb-2 text-[11px] desktop:text-[13px] tracking-[0.02em]"><?php echo esc_html( still_cup_mod( 'still_cup_hero_eyebrow', __( 'Handmade ceramic cups', 'still-cup' ) ) ); ?></p>
		<h1 class="m-0 mb-4 font-display text-[clamp(2.5rem,8vw,5rem)] desktop:text-[80px] font-normal leading-[1.15] desktop:leading-[1.2]"><?php echo esc_html( still_cup_mod( 'still_cup_hero_heading', __( 'Still mornings, considered cups', 'still-cup' ) ) ); ?></h1>
		<p class="m-0 mb-6 max-w-[32rem] text-base desktop:text-[18px]"><?php echo esc_html( still_cup_mod( 'still_cup_hero_text', __( 'Quiet forms and calm finishes for everyday rituals across Australia.', 'still-cup' ) ) ); ?></p>
		<a class="<?php echo esc_attr( $btn ); ?>" href="<?php echo esc_url( $cta_url ); ?>">
			<?php echo esc_html( still_cup_mod( 'still_cup_hero_cta', __( 'Shop collection', 'still-cup' ) ) ); ?>
		</a>
	</div>
	<figure class="relative m-0 -mx-[var(--sc-gutter)] desktop:mx-0 desktop:h-full desktop:min-h-[570px]">
		<?php if ( $hero_image_id ) : ?>
			<?php
			echo wp_get_attachment_image(
				$hero_image_id,
				'large',
				false,
				array(
					'class' => 'w-full aspect-[390/330] object-cover bg-[#d4c4b0] desktop:!h-full desktop:min-h-[570px] desktop:aspect-auto',
					'alt'   => '',
				)
			);
			?>
		<?php else : ?>
			<div class="w-full aspect-[390/330] bg-[#d4c4b0] desktop:h-full desktop:min-h-[570px] desktop:aspect-auto" aria-hidden="true"></div>
		<?php endif; ?>
		<figcaption class="absolute left-[var(--sc-gutter)] desktop:left-8 bottom-3 desktop:bottom-6 m-0 text-[12px] text-inverse [text-shadow:0_1px_2px_rgba(0,0,0,0.35)]"><?php echo esc_html( still_cup_mod( 'still_cup_hero_caption', __( 'Studio light on sand finish', 'still-cup' ) ) ); ?></figcaption>
	</figure>
</section>

<p class="m-0 px-[var(--sc-gutter)] py-5 desktop:py-6 text-center text-[14px] desktop:text-[15px]"><?php echo esc_html( still_cup_mod( 'still_cup_benefits', __( 'Made in small batches  ·  Thoughtful finishes  ·  Ships Australia-wide', 'still-cup' ) ) ); ?></p>

<section class="px-[var(--sc-gutter)] pt-6 pb-12 mx-auto max-w-[calc(var(--sc-content-max)+2*var(--sc-gutter))]" aria-labelledby="sc-featured-heading">
	<div class="grid gap-[0.35rem] desktop:grid-cols-[1fr_auto] desktop:grid-rows-[auto_auto] desktop:items-end mb-5">
		<p class="m-0 text-[12px] desktop:col-start-1"><?php echo esc_html( still_cup_mod( 'still_cup_featured_eyebrow', __( 'Featured', 'still-cup' ) ) ); ?></p>
		<h2 id="sc-featured-heading" class="m-0 font-display text-[clamp(1.75rem,4vw,2.875rem)] font-normal desktop:col-start-1"><?php echo esc_html( still_cup_mod( 'still_cup_featured_heading', __( 'Cups for the slow hours', 'still-cup' ) ) ); ?></h2>
		<a class="text-[14px] desktop:text-[15px] desktop:col-start-2 desktop:row-start-2" href="<?php echo esc_url( $shop_url ); ?>"><?php esc_html_e( 'Shop all', 'still-cup' ); ?></a>
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
			<ul class="grid grid-cols-1 min-[360px]:grid-cols-2 desktop:grid-cols-3 gap-x-[0.875rem] gap-y-5 desktop:gap-x-[1.4rem] desktop:gap-y-6 m-0 p-0 list-none">
				<?php
				while ( $featured->have_posts() ) {
					$featured->the_post();
					wc_get_template_part( 'content', 'product' );
				}
				wp_reset_postdata();
				?>
			</ul>
		<?php else : ?>
			<p class="text-muted">
				<?php esc_html_e( 'Featured products will appear here once the catalogue is added. Mark products as Featured in WooCommerce, or they will fall back to the latest products.', 'still-cup' ); ?>
			</p>
			<p><a class="<?php echo esc_attr( $btn ); ?>" href="<?php echo esc_url( $shop_url ); ?>"><?php esc_html_e( 'Browse shop', 'still-cup' ); ?></a></p>
		<?php endif; ?>
	<?php endif; ?>
</section>

<section class="bg-story px-[var(--sc-gutter)] py-8 desktop:py-12" aria-labelledby="sc-story-heading">
	<div class="mx-auto max-w-[calc(var(--sc-content-max)+2*var(--sc-gutter))] grid gap-4 desktop:grid-cols-2 desktop:gap-12 desktop:items-center">
		<div>
			<p class="m-0 mb-2 text-[12px]"><?php echo esc_html( still_cup_mod( 'still_cup_story_eyebrow', __( 'Our story', 'still-cup' ) ) ); ?></p>
			<h2 id="sc-story-heading" class="m-0 font-display text-[clamp(1.75rem,4vw,2.75rem)] font-normal leading-[1.2]"><?php echo esc_html( still_cup_mod( 'still_cup_story_heading', __( 'Clay, patience, and a quieter table', 'still-cup' ) ) ); ?></h2>
		</div>
		<div>
			<p class="mt-0 text-base desktop:text-[18px] leading-normal"><?php echo esc_html( still_cup_mod( 'still_cup_story_text', __( 'Still Cup is a small Australian brand making ceramic cups meant to be held, used, and kept.', 'still-cup' ) ) ); ?></p>
			<a class="text-base" href="<?php echo esc_url( $story_url ); ?>">
				<?php echo esc_html( still_cup_mod( 'still_cup_story_link_label', __( 'Read our story', 'still-cup' ) ) ); ?>
			</a>
		</div>
	</div>
</section>

<?php
get_footer();
