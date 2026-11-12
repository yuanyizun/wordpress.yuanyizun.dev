<?php
/**
 * Main template fallback.
 *
 * @package Still_Cup
 */

get_header();
?>

<div class="mx-auto max-w-[calc(var(--sc-content-max)+2*var(--sc-gutter))] px-[var(--sc-gutter)] pt-10 pb-16">
	<?php if ( have_posts() ) : ?>
		<?php while ( have_posts() ) : ?>
			<?php the_post(); ?>
			<article <?php post_class(); ?>>
				<header>
					<h1 class="m-0 mb-4 font-display text-[clamp(2rem,4vw,3.5rem)] font-normal leading-[1.2]"><?php the_title(); ?></h1>
				</header>
				<div class="max-w-[40rem] text-[1.05rem] [&>p:first-child]:mt-0">
					<?php the_content(); ?>
				</div>
			</article>
		<?php endwhile; ?>
	<?php else : ?>
		<article>
			<header>
				<h1 class="m-0 mb-4 font-display text-[clamp(2rem,4vw,3.5rem)] font-normal leading-[1.2]"><?php bloginfo( 'name' ); ?></h1>
			</header>
			<div class="max-w-[40rem] text-[1.05rem]">
				<p><?php esc_html_e( 'Calm ceramic cups for everyday rituals. Shop templates and catalogue arrive in upcoming features.', 'still-cup' ); ?></p>
			</div>
		</article>
	<?php endif; ?>
</div>

<?php
get_footer();
