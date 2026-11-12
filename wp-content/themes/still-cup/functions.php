<?php
/**
 * Still Cup theme functions.
 *
 * @package Still_Cup
 */

declare(strict_types=1);

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

define( 'STILL_CUP_VERSION', '0.2.3' );
define( 'STILL_CUP_DIR', get_template_directory() );
define( 'STILL_CUP_URI', get_template_directory_uri() );

require_once STILL_CUP_DIR . '/inc/customizer-home.php';
require_once STILL_CUP_DIR . '/inc/woocommerce.php';

/**
 * Theme setup.
 */
function still_cup_setup(): void {
	add_theme_support( 'title-tag' );
	add_theme_support( 'post-thumbnails' );
	add_theme_support( 'html5', array( 'search-form', 'comment-form', 'comment-list', 'gallery', 'caption', 'style', 'script' ) );
	add_theme_support( 'editor-styles' );
	add_theme_support( 'align-wide' );
	add_theme_support( 'responsive-embeds' );

	register_nav_menus(
		array(
			'primary' => __( 'Primary', 'still-cup' ),
			'footer'  => __( 'Footer', 'still-cup' ),
		)
	);
}
add_action( 'after_setup_theme', 'still_cup_setup' );

/**
 * Enqueue fonts, styles and scripts.
 */
function still_cup_enqueue_assets(): void {
	wp_enqueue_style(
		'still-cup-fonts',
		'https://fonts.googleapis.com/css2?family=Inter:wght@400;500&family=Newsreader:opsz,wght@6..72,400;6..72,500&display=swap',
		array(),
		null
	);

	wp_enqueue_style(
		'still-cup-main',
		STILL_CUP_URI . '/assets/css/main.css',
		array( 'still-cup-fonts' ),
		STILL_CUP_VERSION
	);

	wp_enqueue_style(
		'still-cup-templates',
		STILL_CUP_URI . '/assets/css/templates.css',
		array( 'still-cup-main' ),
		STILL_CUP_VERSION
	);

	wp_enqueue_script(
		'still-cup-navigation',
		STILL_CUP_URI . '/assets/js/navigation.js',
		array(),
		STILL_CUP_VERSION,
		array(
			'strategy'  => 'defer',
			'in_footer' => true,
		)
	);

	if ( function_exists( 'is_product' ) && is_product() ) {
		wp_enqueue_script(
			'still-cup-product',
			STILL_CUP_URI . '/assets/js/product.js',
			array( 'jquery' ),
			STILL_CUP_VERSION,
			array(
				'strategy'  => 'defer',
				'in_footer' => true,
			)
		);
	}
}
add_action( 'wp_enqueue_scripts', 'still_cup_enqueue_assets' );

/**
 * Announcement bar text (theme mod).
 */
function still_cup_announcement_text(): string {
	$default = __( 'Free standard shipping on orders $100+ · Australia only', 'still-cup' );
	$text    = get_theme_mod( 'still_cup_announcement', $default );
	return is_string( $text ) && $text !== '' ? $text : $default;
}

/**
 * Register Customizer control for announcement.
 *
 * @param WP_Customize_Manager $wp_customize Customizer.
 */
function still_cup_customize_register( WP_Customize_Manager $wp_customize ): void {
	$wp_customize->add_section(
		'still_cup_chrome',
		array(
			'title'    => __( 'Still Cup chrome', 'still-cup' ),
			'priority' => 30,
		)
	);

	$wp_customize->add_setting(
		'still_cup_announcement',
		array(
			'default'           => __( 'Free standard shipping on orders $100+ · Australia only', 'still-cup' ),
			'sanitize_callback' => 'sanitize_text_field',
			'transport'         => 'refresh',
		)
	);

	$wp_customize->add_control(
		'still_cup_announcement',
		array(
			'label'   => __( 'Announcement bar', 'still-cup' ),
			'section' => 'still_cup_chrome',
			'type'    => 'text',
		)
	);
}
add_action( 'customize_register', 'still_cup_customize_register' );

/**
 * Default primary nav items when no menu is assigned.
 *
 * @return array<int, array{label: string, url: string}>
 */
function still_cup_default_nav_items(): array {
	$shop_url = function_exists( 'wc_get_page_permalink' ) ? wc_get_page_permalink( 'shop' ) : home_url( '/shop/' );

	$items = array(
		array(
			'label' => __( 'Shop all', 'still-cup' ),
			'url'   => $shop_url,
		),
	);

	$categories = array( 'Mugs', 'Cups', 'Tumblers' );
	foreach ( $categories as $name ) {
		$url = $shop_url;
		if ( taxonomy_exists( 'product_cat' ) ) {
			$term = get_term_by( 'name', $name, 'product_cat' );
			if ( $term instanceof WP_Term && ! is_wp_error( $term ) ) {
				$link = get_term_link( $term );
				if ( ! is_wp_error( $link ) ) {
					$url = $link;
				}
			}
		}
		$items[] = array(
			'label' => $name,
			'url'   => $url,
		);
	}

	return $items;
}

/**
 * Render primary navigation links.
 *
 * @param string $class_prefix BEM-ish class prefix for list items.
 */
function still_cup_render_primary_nav( string $class_prefix = 'sc-nav' ): void {
	if ( has_nav_menu( 'primary' ) ) {
		wp_nav_menu(
			array(
				'theme_location' => 'primary',
				'container'      => false,
				'menu_class'     => $class_prefix . '__list',
				'fallback_cb'    => false,
				'depth'          => 1,
			)
		);
		return;
	}

	echo '<ul class="' . esc_attr( $class_prefix . '__list' ) . '">';
	foreach ( still_cup_default_nav_items() as $item ) {
		printf(
			'<li class="%1$s__item"><a class="%1$s__link" href="%2$s">%3$s</a></li>',
			esc_attr( $class_prefix ),
			esc_url( $item['url'] ),
			esc_html( $item['label'] )
		);
	}
	echo '</ul>';
}

/**
 * Cart / bag URL and count.
 *
 * @return array{url: string, count: int}
 */
function still_cup_bag_data(): array {
	$url   = function_exists( 'wc_get_cart_url' ) ? wc_get_cart_url() : home_url( '/cart/' );
	$count = ( function_exists( 'WC' ) && WC()->cart ) ? (int) WC()->cart->get_cart_contents_count() : 0;

	return array(
		'url'   => $url,
		'count' => $count,
	);
}

/**
 * Account URL.
 */
function still_cup_account_url(): string {
	if ( function_exists( 'wc_get_page_permalink' ) ) {
		return wc_get_page_permalink( 'myaccount' );
	}
	return wp_login_url();
}

/**
 * Default footer link placeholders.
 *
 * @return array<int, array{label: string, path: string}>
 */
function still_cup_footer_links(): array {
	return array(
		array( 'label' => __( 'Our story', 'still-cup' ), 'path' => '/our-story/' ),
		array( 'label' => __( 'Care guide', 'still-cup' ), 'path' => '/care-guide/' ),
		array( 'label' => __( 'Shipping & returns', 'still-cup' ), 'path' => '/shipping-returns/' ),
		array( 'label' => __( 'Contact', 'still-cup' ), 'path' => '/contact/' ),
		array( 'label' => __( 'Privacy', 'still-cup' ), 'path' => '/privacy/' ),
		array( 'label' => __( 'Terms', 'still-cup' ), 'path' => '/terms/' ),
	);
}

/**
 * Shop URL helper.
 */
function still_cup_shop_url(): string {
	return function_exists( 'wc_get_page_permalink' ) ? (string) wc_get_page_permalink( 'shop' ) : home_url( '/shop/' );
}
