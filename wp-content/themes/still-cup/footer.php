<?php
/**
 * Theme footer.
 *
 * @package Still_Cup
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$footer_link_class = 'inline-flex items-center min-h-touch text-[14px] no-underline text-inverse';
?>
</main>

<footer class="bg-primary text-inverse px-[var(--sc-gutter)] py-8 desktop:py-10 overflow-x-clip max-w-full" role="contentinfo">
	<div class="grid gap-5 desktop:grid-cols-[auto_1fr] desktop:grid-rows-[auto_auto] desktop:items-start desktop:gap-x-12 mx-auto max-w-[calc(var(--sc-content-max)+2*var(--sc-gutter))]">
		<a class="font-display text-[28px] desktop:text-[34px] leading-[1.2] no-underline text-inverse hover:!opacity-100 desktop:row-span-2 desktop:self-center" href="<?php echo esc_url( home_url( '/' ) ); ?>">
			<?php bloginfo( 'name' ); ?>
		</a>

		<?php if ( has_nav_menu( 'footer' ) ) : ?>
			<nav class="desktop:justify-self-end" aria-label="<?php esc_attr_e( 'Footer', 'still-cup' ); ?>">
				<?php
				wp_nav_menu(
					array(
						'theme_location'       => 'footer',
						'container'            => false,
						'menu_class'           => 'm-0 p-0 list-none flex flex-wrap gap-x-5 gap-y-3',
						'fallback_cb'          => false,
						'depth'                => 1,
						'still_cup_link_class' => $footer_link_class,
					)
				);
				?>
			</nav>
		<?php else : ?>
			<nav class="desktop:justify-self-end" aria-label="<?php esc_attr_e( 'Footer', 'still-cup' ); ?>">
				<ul class="m-0 p-0 list-none flex flex-wrap gap-x-5 gap-y-3">
					<?php foreach ( still_cup_footer_links() as $link ) : ?>
						<li>
							<a class="<?php echo esc_attr( $footer_link_class ); ?>" href="<?php echo esc_url( home_url( $link['path'] ) ); ?>">
								<?php echo esc_html( $link['label'] ); ?>
							</a>
						</li>
					<?php endforeach; ?>
				</ul>
			</nav>
		<?php endif; ?>

		<p class="m-0 text-[13px] opacity-90 desktop:justify-self-end">
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
