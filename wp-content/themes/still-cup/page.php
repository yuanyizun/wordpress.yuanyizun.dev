<?php
/**
 * Supporting pages template.
 * Cart/Checkout skip the page H1 — those templates render Pencil headings.
 *
 * @package Still_Cup
 */

get_header();

$is_woo_flow = ( function_exists( 'is_cart' ) && is_cart() )
	|| ( function_exists( 'is_checkout' ) && is_checkout() );
?>

<div class="<?php echo $is_woo_flow ? 'sc-woo-page' : 'sc-page'; ?>">
	<?php while ( have_posts() ) : ?>
		<?php the_post(); ?>
		<article <?php post_class( $is_woo_flow ? 'sc-woo-flow' : 'sc-page__article' ); ?>>
			<?php if ( ! $is_woo_flow ) : ?>
				<header class="sc-page__header">
					<h1 class="sc-page__title"><?php the_title(); ?></h1>
				</header>
			<?php endif; ?>
			<div class="<?php echo $is_woo_flow ? 'sc-woo-flow__content entry-content' : 'sc-page__content entry-content'; ?>">
				<?php the_content(); ?>
			</div>
		</article>
	<?php endwhile; ?>
</div>

<?php
get_footer();
