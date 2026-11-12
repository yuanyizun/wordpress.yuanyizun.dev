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

$shell = 'mx-auto max-w-[calc(var(--sc-content-max)+2*var(--sc-gutter))] px-[var(--sc-gutter)] ' . ( $is_woo_flow ? 'pt-6 pb-16' : 'pt-10 pb-16' );
?>

<div class="<?php echo esc_attr( $shell ); ?>">
	<?php while ( have_posts() ) : ?>
		<?php the_post(); ?>
		<article <?php post_class(); ?>>
			<?php if ( ! $is_woo_flow ) : ?>
				<header>
					<h1 class="m-0 mb-5 font-display text-[clamp(2rem,5vw,3.5rem)] font-normal"><?php the_title(); ?></h1>
				</header>
			<?php endif; ?>
			<div class="<?php echo $is_woo_flow ? 'entry-content' : 'entry-content max-w-prose-page text-[1.05rem] leading-normal [&>*:first-child]:mt-0'; ?>">
				<?php the_content(); ?>
			</div>
		</article>
	<?php endwhile; ?>
</div>

<?php
get_footer();
