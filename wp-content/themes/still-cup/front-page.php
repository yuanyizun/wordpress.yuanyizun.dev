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

$btn = 'inline-flex items-center min-h-[52px] w-full desktop:w-[236px] px-5 border-0 bg-primary text-inverse font-body text-[15px] leading-[1.2] no-underline cursor-pointer hover:opacity-[0.92] hover:text-inverse';
$hero_cta = still_cup_mod( 'still_cup_hero_cta', __( 'Shop the collection', 'still-cup' ) );
if ( ! preg_match( '/→\s*$/u', $hero_cta ) ) {
	$hero_cta .= '  →';
}
$story_label = still_cup_mod( 'still_cup_story_link_label', __( 'Meet Still Cup', 'still-cup' ) );
if ( ! preg_match( '/↗\s*$/u', $story_label ) ) {
	$story_label .= '  ↗';
}
$benefits_raw = still_cup_mod( 'still_cup_benefits', __( 'Considered ceramics  ·  Carefully packed  ·  Australian owned', 'still-cup' ) );
$benefits     = array_values( array_filter( array_map( 'trim', preg_split( '/\s*·\s*/u', $benefits_raw ) ?: array() ) ) );
?>

<section class="grid desktop:grid-cols-[minmax(0,754fr)_minmax(0,686fr)] desktop:min-h-[570px] bg-hero" aria-label="<?php esc_attr_e( 'Hero', 'still-cup' ); ?>">
	<div class="px-[var(--sc-gutter)] pt-8 pb-6 desktop:flex desktop:flex-col desktop:justify-center desktop:min-h-[570px] desktop:py-0">
		<p class="m-0 mb-3 text-[11px] desktop:text-[13px] uppercase leading-[1.25] desktop:leading-[1.2]"><?php echo esc_html( still_cup_mod( 'still_cup_hero_eyebrow', __( 'Small moments, well made', 'still-cup' ) ) ); ?></p>
		<h1 class="m-0 mb-4 font-display text-[50px] desktop:text-[80px] font-normal leading-[1.25] desktop:leading-[1.2]"><?php echo esc_html( still_cup_mod( 'still_cup_hero_heading', __( 'Make room for a slower sip.', 'still-cup' ) ) ); ?></h1>
		<p class="m-0 mb-6 max-w-[34rem] text-[16px] desktop:text-[18px] leading-[1.25] desktop:leading-[1.2]"><?php echo esc_html( still_cup_mod( 'still_cup_hero_text', __( 'Thoughtfully made ceramic cups for the coffee, the conversation, and the pause in between.', 'still-cup' ) ) ); ?></p>
		<a class="<?php echo esc_attr( $btn ); ?>" href="<?php echo esc_url( $cta_url ); ?>">
			<?php echo esc_html( $hero_cta ); ?>
		</a>
	</div>
	<figure class="relative m-0 -mx-[var(--sc-gutter)] desktop:mx-0 h-[330px] desktop:h-auto desktop:min-h-[570px]">
		<?php if ( $hero_image_id ) : ?>
			<?php
			echo wp_get_attachment_image(
				$hero_image_id,
				'large',
				false,
				array(
					'class' => 'w-full h-full object-cover bg-[#d4c4b0]',
					'alt'   => '',
				)
			);
			?>
		<?php else : ?>
			<div class="w-full h-full min-h-[330px] desktop:min-h-[570px] bg-[#d4c4b0]" aria-hidden="true"></div>
		<?php endif; ?>
		<figcaption class="hidden desktop:block absolute left-8 bottom-6 m-0 text-[12px] leading-[1.2] text-inverse [text-shadow:0_1px_2px_rgba(0,0,0,0.35)]"><?php echo esc_html( still_cup_mod( 'still_cup_hero_caption', __( 'The everyday collection / 01', 'still-cup' ) ) ); ?></figcaption>
	</figure>
</section>

<?php if ( $benefits ) : ?>
	<p class="hidden desktop:flex m-0 px-[var(--sc-gutter)] py-8 items-center justify-center gap-x-16 text-center text-[15px] leading-[1.2]">
		<?php foreach ( $benefits as $benefit ) : ?>
			<span><?php echo esc_html( $benefit ); ?></span>
		<?php endforeach; ?>
	</p>
<?php endif; ?>

<section class="px-[var(--sc-gutter)] pt-8 desktop:pt-4 pb-12 mx-auto max-w-[calc(var(--sc-content-max)+2*var(--sc-gutter))]" aria-labelledby="sc-featured-heading">
	<div class="mb-5 desktop:mb-6">
		<p class="hidden desktop:block m-0 mb-2 text-[12px] leading-[1.2] uppercase"><?php echo esc_html( still_cup_mod( 'still_cup_featured_eyebrow', __( 'Find your everyday favourite', 'still-cup' ) ) ); ?></p>
		<div class="flex flex-col gap-2 desktop:flex-row desktop:items-end desktop:justify-between">
			<h2 id="sc-featured-heading" class="m-0 font-display text-[33px] desktop:text-[46px] font-normal leading-[1.25] desktop:leading-[1.2]"><?php echo esc_html( still_cup_mod( 'still_cup_featured_heading', __( 'Good mornings start here.', 'still-cup' ) ) ); ?></h2>
			<a class="text-[14px] desktop:text-[15px] leading-[1.25] no-underline" href="<?php echo esc_url( $shop_url ); ?>"><?php esc_html_e( 'Shop all cups  ↗', 'still-cup' ); ?></a>
		</div>
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
			<ul class="grid grid-cols-2 desktop:grid-cols-3 gap-x-3.5 gap-y-5 desktop:gap-x-6 desktop:gap-y-6 m-0 p-0 list-none">
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

<section class="bg-story px-[var(--sc-gutter)] py-8 desktop:min-h-[240px] desktop:py-12 desktop:flex desktop:items-center" aria-labelledby="sc-story-heading">
	<div class="mx-auto w-full max-w-[calc(var(--sc-content-max)+2*var(--sc-gutter))] grid gap-3 desktop:grid-cols-2 desktop:gap-12 desktop:items-center">
		<div>
			<p class="hidden desktop:block m-0 mb-2 text-[12px] uppercase leading-[1.2]"><?php echo esc_html( still_cup_mod( 'still_cup_story_eyebrow', __( 'Our approach', 'still-cup' ) ) ); ?></p>
			<h2 id="sc-story-heading" class="m-0 font-display text-[34px] desktop:text-[44px] font-normal leading-[1.25] desktop:leading-[1.2]"><?php echo esc_html( still_cup_mod( 'still_cup_story_heading', __( 'Less, but loved more.', 'still-cup' ) ) ); ?></h2>
		</div>
		<div>
			<p class="m-0 text-[16px] desktop:text-[18px] leading-[1.25] desktop:leading-[1.2]"><?php echo esc_html( still_cup_mod( 'still_cup_story_text', __( 'Simple shapes. Tactile finishes. Cups that feel at home in your hands, and earn their place on your shelf.', 'still-cup' ) ) ); ?></p>
			<a class="hidden desktop:inline-block mt-4 text-[16px] leading-[1.2] no-underline" href="<?php echo esc_url( $story_url ); ?>">
				<?php echo esc_html( $story_label ); ?>
			</a>
		</div>
	</div>
</section>

<?php
get_footer();
