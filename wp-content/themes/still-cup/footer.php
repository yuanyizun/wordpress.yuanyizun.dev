<?php
/**
 * Theme footer.
 *
 * @package Still_Cup
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
?>
</main>

<footer class="sc-footer" role="contentinfo">
	<div class="sc-footer__inner">
		<a class="sc-footer__brand" href="<?php echo esc_url( home_url( '/' ) ); ?>">
			<?php bloginfo( 'name' ); ?>
		</a>

		<?php if ( has_nav_menu( 'footer' ) ) : ?>
			<nav class="sc-footer__nav" aria-label="<?php esc_attr_e( 'Footer', 'still-cup' ); ?>">
				<?php
				wp_nav_menu(
					array(
						'theme_location' => 'footer',
						'container'      => false,
						'menu_class'     => 'sc-footer__list',
						'fallback_cb'    => false,
						'depth'          => 1,
					)
				);
				?>
			</nav>
		<?php else : ?>
			<nav class="sc-footer__nav" aria-label="<?php esc_attr_e( 'Footer', 'still-cup' ); ?>">
				<ul class="sc-footer__list">
					<?php foreach ( still_cup_footer_links() as $link ) : ?>
						<li class="sc-footer__item">
							<a class="sc-footer__link" href="<?php echo esc_url( home_url( $link['path'] ) ); ?>">
								<?php echo esc_html( $link['label'] ); ?>
							</a>
						</li>
					<?php endforeach; ?>
				</ul>
			</nav>
		<?php endif; ?>

		<p class="sc-footer__details">
			<?php
			echo esc_html(
				sprintf(
					/* translators: %s: current year */
					__( '© %s Still Cup · Ceramic cups · Australia', 'still-cup' ),
					gmdate( 'Y' )
				)
			);
			?>
		</p>
	</div>
</footer>

<?php wp_footer(); ?>
</body>
</html>
