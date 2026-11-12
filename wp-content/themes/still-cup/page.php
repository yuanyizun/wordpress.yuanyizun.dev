<?php
/**
 * Supporting pages template.
 *
 * @package Still_Cup
 */

get_header();
?>

<div class="sc-page">
	<?php while ( have_posts() ) : ?>
		<?php the_post(); ?>
		<article <?php post_class( 'sc-page__article' ); ?>>
			<header class="sc-page__header">
				<h1 class="sc-page__title"><?php the_title(); ?></h1>
			</header>
			<div class="sc-page__content entry-content">
				<?php the_content(); ?>
			</div>
		</article>
	<?php endwhile; ?>
</div>

<?php
get_footer();
