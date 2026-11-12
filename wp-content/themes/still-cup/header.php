<?php
/**
 * Theme header — announcement, site header, mobile menu panel.
 *
 * @package Still_Cup
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$bag = still_cup_bag_data();
?><!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>
<?php wp_body_open(); ?>

<a class="sc-skip-link" href="#main"><?php esc_html_e( 'Skip to content', 'still-cup' ); ?></a>

<div class="sc-announcement" role="region" aria-label="<?php esc_attr_e( 'Site announcement', 'still-cup' ); ?>">
	<p class="sc-announcement__text"><?php echo esc_html( still_cup_announcement_text() ); ?></p>
</div>

<header class="sc-header" role="banner">
	<div class="sc-header__inner">
		<button
			type="button"
			class="sc-header__menu-toggle"
			id="sc-menu-open"
			aria-expanded="false"
			aria-controls="sc-mobile-nav"
		>
			<span class="sc-header__menu-toggle-label"><?php esc_html_e( 'Menu', 'still-cup' ); ?></span>
		</button>

		<a class="sc-header__wordmark" href="<?php echo esc_url( home_url( '/' ) ); ?>">
			<?php bloginfo( 'name' ); ?>
		</a>

		<nav class="sc-nav sc-nav--desktop" aria-label="<?php esc_attr_e( 'Primary', 'still-cup' ); ?>">
			<?php still_cup_render_primary_nav( 'sc-nav' ); ?>
		</nav>

		<div class="sc-header__utilities">
			<button
				type="button"
				class="sc-header__utility sc-header__search-toggle"
				id="sc-search-open"
				aria-expanded="false"
				aria-controls="sc-search-panel"
			>
				<?php esc_html_e( 'Search', 'still-cup' ); ?>
			</button>
			<a class="sc-header__utility" href="<?php echo esc_url( still_cup_account_url() ); ?>">
				<?php esc_html_e( 'Account', 'still-cup' ); ?>
			</a>
			<a class="sc-header__utility sc-header__bag" href="<?php echo esc_url( $bag['url'] ); ?>">
				<?php
				printf(
					/* translators: %d: number of items in the bag */
					esc_html__( 'Bag (%d)', 'still-cup' ),
					(int) $bag['count']
				);
				?>
			</a>
		</div>
	</div>

	<div class="sc-search" id="sc-search-panel" hidden>
		<form class="sc-search__form" role="search" method="get" action="<?php echo esc_url( home_url( '/' ) ); ?>">
			<label class="sc-search__label" for="sc-search-field"><?php esc_html_e( 'Search products', 'still-cup' ); ?></label>
			<input
				class="sc-search__input"
				type="search"
				id="sc-search-field"
				name="s"
				placeholder="<?php esc_attr_e( 'Search cups…', 'still-cup' ); ?>"
			>
			<button class="sc-search__submit" type="submit"><?php esc_html_e( 'Search', 'still-cup' ); ?></button>
			<button type="button" class="sc-search__close" id="sc-search-close"><?php esc_html_e( 'Close', 'still-cup' ); ?></button>
		</form>
	</div>
</header>

<div
	class="sc-mobile-nav"
	id="sc-mobile-nav"
	hidden
	role="dialog"
	aria-modal="true"
	aria-labelledby="sc-mobile-nav-title"
>
	<div class="sc-mobile-nav__panel">
		<div class="sc-mobile-nav__top">
			<p class="sc-mobile-nav__title" id="sc-mobile-nav-title"><?php esc_html_e( 'Menu', 'still-cup' ); ?></p>
			<button type="button" class="sc-mobile-nav__close" id="sc-menu-close">
				<?php esc_html_e( 'Close', 'still-cup' ); ?>
			</button>
		</div>
		<nav class="sc-nav sc-nav--mobile" aria-label="<?php esc_attr_e( 'Mobile primary', 'still-cup' ); ?>">
			<?php still_cup_render_primary_nav( 'sc-nav' ); ?>
		</nav>
		<ul class="sc-mobile-nav__utilities">
			<li><a href="<?php echo esc_url( still_cup_account_url() ); ?>"><?php esc_html_e( 'Account', 'still-cup' ); ?></a></li>
			<li>
				<a href="<?php echo esc_url( $bag['url'] ); ?>">
					<?php
					printf(
						esc_html__( 'Bag (%d)', 'still-cup' ),
						(int) $bag['count']
					);
					?>
				</a>
			</li>
		</ul>
	</div>
</div>

<main id="main" class="sc-main">
