<?php
/**
 * Theme header — announcement, site header, mobile menu panel.
 *
 * @package Still_Cup
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$bag              = still_cup_bag_data();
$is_checkout_form = function_exists( 'is_checkout' ) && is_checkout() && function_exists( 'is_order_received_page' ) && ! is_order_received_page();
?><!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>
<?php wp_body_open(); ?>

<a class="absolute left-[var(--sc-gutter)] top-[-100px] z-1000 px-3 py-2 bg-primary !text-inverse no-underline focus:top-2" href="#main"><?php esc_html_e( 'Skip to content', 'still-cup' ); ?></a>

<?php if ( is_front_page() ) : ?>
<div class="flex items-center justify-center min-h-[30px] desktop:min-h-8 px-[var(--sc-gutter)] py-[0.4rem] bg-primary text-inverse text-center overflow-x-clip max-w-full" role="region" aria-label="<?php esc_attr_e( 'Site announcement', 'still-cup' ); ?>">
	<p class="m-0 text-[12px] desktop:text-[13px] leading-tight"><?php echo esc_html( still_cup_announcement_text() ); ?></p>
</div>
<?php endif; ?>

<header class="relative overflow-x-clip max-w-full" role="banner">
	<?php if ( $is_checkout_form ) : ?>
		<div class="sc-header-inner flex items-center justify-between gap-4 min-h-[72px] desktop:min-h-[100px] px-[var(--sc-gutter)] mx-auto max-w-[calc(var(--sc-content-max)+2*var(--sc-gutter))]">
			<a class="font-display text-[32px] desktop:text-[38px] leading-[1.2] no-underline text-primary whitespace-nowrap hover:!opacity-100" href="<?php echo esc_url( home_url( '/' ) ); ?>">
				<?php bloginfo( 'name' ); ?>
			</a>
			<p class="m-0 text-right text-[12px] desktop:text-[14px] leading-tight">
				<?php esc_html_e( 'Secure checkout', 'still-cup' ); ?>
				<span class="hidden desktop:inline" aria-hidden="true"> / </span>
				<a class="hidden desktop:inline no-underline text-primary" href="<?php echo esc_url( $bag['url'] ); ?>"><?php esc_html_e( '← Return to bag', 'still-cup' ); ?></a>
			</p>
		</div>
	<?php else : ?>
	<div class="sc-header-inner grid grid-cols-[var(--sc-touch)_1fr_auto] desktop:grid-cols-[auto_1fr_auto] items-center gap-2 desktop:gap-6 min-h-[72px] desktop:min-h-[82px] px-[var(--sc-gutter)] py-2 mx-auto max-w-[calc(var(--sc-content-max)+2*var(--sc-gutter))]">
		<button
			type="button"
			class="justify-self-start inline-flex items-center justify-center min-w-touch min-h-touch p-0 border-0 bg-transparent text-primary font-body text-[24px] leading-none cursor-pointer desktop:hidden"
			id="sc-menu-open"
			aria-expanded="false"
			aria-controls="sc-mobile-nav"
		>
			<span aria-hidden="true">☰</span>
			<span class="sr-only"><?php esc_html_e( 'Menu', 'still-cup' ); ?></span>
		</button>

		<a class="justify-self-center desktop:justify-self-start font-display text-[32px] desktop:text-[38px] leading-[1.2] no-underline text-primary whitespace-nowrap hover:!opacity-100" href="<?php echo esc_url( home_url( '/' ) ); ?>">
			<?php bloginfo( 'name' ); ?>
		</a>

		<nav class="hidden desktop:block justify-self-center" aria-label="<?php esc_attr_e( 'Primary', 'still-cup' ); ?>">
			<?php still_cup_render_primary_nav( 'desktop' ); ?>
		</nav>

		<div class="flex items-center justify-self-end gap-6">
			<button
				type="button"
				class="hidden desktop:inline-flex items-center justify-center min-h-touch px-[0.5rem] text-[14px] leading-tight no-underline text-primary bg-transparent border-0 font-body cursor-pointer"
				id="sc-search-open"
				aria-expanded="false"
				aria-controls="sc-search-panel"
			>
				<?php esc_html_e( 'Search', 'still-cup' ); ?>
			</button>
			<a class="hidden desktop:inline-flex items-center justify-center min-h-touch px-[0.5rem] text-[14px] leading-tight no-underline text-primary" href="<?php echo esc_url( still_cup_account_url() ); ?>">
				<?php esc_html_e( 'Account', 'still-cup' ); ?>
			</a>
			<a class="inline-flex items-center justify-center min-h-touch px-[0.35rem] desktop:px-[0.5rem] text-[13px] desktop:text-[14px] leading-tight no-underline text-primary" href="<?php echo esc_url( $bag['url'] ); ?>">
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
	<?php endif; ?>

	<?php if ( ! $is_checkout_form ) : ?>
	<div class="px-[var(--sc-gutter)] pt-3 pb-4 border-t border-border bg-page" id="sc-search-panel" hidden>
		<form class="flex flex-wrap items-end gap-3 mx-auto max-w-[calc(var(--sc-content-max)+2*var(--sc-gutter))]" role="search" method="get" action="<?php echo esc_url( home_url( '/' ) ); ?>">
			<label class="w-full text-[13px]" for="sc-search-field"><?php esc_html_e( 'Search products', 'still-cup' ); ?></label>
			<input
				class="flex-1 min-w-[200px] min-h-touch px-3 py-2 border border-border bg-surface font-body text-base text-primary"
				type="search"
				id="sc-search-field"
				name="s"
				placeholder="<?php esc_attr_e( 'Search cups…', 'still-cup' ); ?>"
			>
			<button class="min-h-touch min-w-touch px-4 border-0 bg-primary text-inverse font-body text-[14px] cursor-pointer" type="submit"><?php esc_html_e( 'Search', 'still-cup' ); ?></button>
			<button type="button" class="min-h-touch min-w-touch px-4 border border-border bg-transparent text-primary font-body text-[14px] cursor-pointer" id="sc-search-close"><?php esc_html_e( 'Close', 'still-cup' ); ?></button>
		</form>
	</div>
	<?php endif; ?>
</header>

<?php if ( ! $is_checkout_form ) : ?>
<div
	class="fixed inset-0 z-[200] bg-[rgba(36,58,49,0.35)] desktop:!hidden"
	id="sc-mobile-nav"
	hidden
	role="dialog"
	aria-modal="true"
	aria-labelledby="sc-mobile-nav-title"
>
	<div class="w-[min(100%,360px)] h-full px-[var(--sc-gutter)] pt-4 pb-8 bg-page overflow-y-auto">
		<div class="flex items-center justify-between mb-6">
			<p class="m-0 font-display text-[28px]" id="sc-mobile-nav-title"><?php esc_html_e( 'Menu', 'still-cup' ); ?></p>
			<button type="button" class="min-w-touch min-h-touch border-0 bg-transparent font-body text-[14px] text-primary cursor-pointer" id="sc-menu-close">
				<?php esc_html_e( 'Close', 'still-cup' ); ?>
			</button>
		</div>
		<nav aria-label="<?php esc_attr_e( 'Mobile primary', 'still-cup' ); ?>">
			<?php still_cup_render_primary_nav( 'mobile' ); ?>
		</nav>
		<ul class="mt-8 mb-0 p-0 list-none">
			<li><a class="flex items-center min-h-touch text-base no-underline" href="<?php echo esc_url( still_cup_account_url() ); ?>"><?php esc_html_e( 'Account', 'still-cup' ); ?></a></li>
			<li>
				<a class="flex items-center min-h-touch text-base no-underline" href="<?php echo esc_url( $bag['url'] ); ?>">
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
<?php endif; ?>

<main id="main" class="min-h-[40vh] overflow-x-clip max-w-full">
