<?php
/**
 * Main template — thin shell until page templates land.
 *
 * @package Still_Cup
 */

get_header();
?>

<div class="sc-shell">
	<?php if ( have_posts() ) : ?>
		<?php while ( have_posts() ) : ?>
			<?php the_post(); ?>
			<article <?php post_class( 'sc-shell__article' ); ?>>
				<header class="sc-shell__header">
					<h1 class="sc-shell__title"><?php the_title(); ?></h1>
				</header>
				<div class="sc-shell__content">
					<?php the_content(); ?>
				</div>
			</article>
		<?php endwhile; ?>
	<?php else : ?>
		<article class="sc-shell__article">
			<header class="sc-shell__header">
				<h1 class="sc-shell__title"><?php bloginfo( 'name' ); ?></h1>
			</header>
			<div class="sc-shell__content">
				<p><?php esc_html_e( 'Calm ceramic cups for everyday rituals. Shop templates and catalogue arrive in upcoming features.', 'still-cup' ); ?></p>
			</div>
		</article>
	<?php endif; ?>
</div>

<?php
get_footer();
