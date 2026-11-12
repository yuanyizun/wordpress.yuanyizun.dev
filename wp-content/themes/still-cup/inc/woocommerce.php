<?php
/**
 * WooCommerce integration for Still Cup.
 *
 * @package Still_Cup
 */

declare(strict_types=1);

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Declare image sizes and gallery features.
 */
function still_cup_woocommerce_setup(): void {
	add_theme_support(
		'woocommerce',
		array(
			'thumbnail_image_width' => 422,
			'single_image_width'    => 690,
			'product_grid'          => array(
				'default_rows'    => 2,
				'min_rows'        => 1,
				'default_columns' => 3,
				'min_columns'     => 1,
				'max_columns'     => 3,
			),
		)
	);

	add_theme_support( 'wc-product-gallery-zoom' );
	add_theme_support( 'wc-product-gallery-lightbox' );
	add_theme_support( 'wc-product-gallery-slider' );
}
add_action( 'after_setup_theme', 'still_cup_woocommerce_setup' );

/**
 * Six products per shop page (delivery.md / decisions.md).
 *
 * @param int $cols Columns or posts per page context.
 */
function still_cup_products_per_page( int $cols ): int {
	return 6;
}
add_filter( 'loop_shop_per_page', 'still_cup_products_per_page', 20 );

/**
 * Default shop columns.
 */
function still_cup_loop_columns(): int {
	return 3;
}
add_filter( 'loop_shop_columns', 'still_cup_loop_columns', 20 );

/**
 * Related products count.
 *
 * @param array $args Args.
 */
function still_cup_related_products_args( array $args ): array {
	$args['posts_per_page'] = 3;
	$args['columns']        = 3;
	return $args;
}
add_filter( 'woocommerce_output_related_products_args', 'still_cup_related_products_args' );

/**
 * Remove default Woo wrappers; theme uses its own shell.
 */
remove_action( 'woocommerce_before_main_content', 'woocommerce_output_content_wrapper', 10 );
remove_action( 'woocommerce_after_main_content', 'woocommerce_output_content_wrapper_end', 10 );
remove_action( 'woocommerce_sidebar', 'woocommerce_get_sidebar', 10 );
remove_action( 'woocommerce_before_shop_loop', 'woocommerce_catalog_ordering', 30 );

/**
 * Theme Woo wrappers.
 */
function still_cup_woo_wrapper_start(): void {
	echo '<div class="sc-woo">';
}
function still_cup_woo_wrapper_end(): void {
	echo '</div>';
}
add_action( 'woocommerce_before_main_content', 'still_cup_woo_wrapper_start', 10 );
add_action( 'woocommerce_after_main_content', 'still_cup_woo_wrapper_end', 10 );

/**
 * Remove loop add-to-cart (selection happens on product page).
 */
remove_action( 'woocommerce_after_shop_loop_item', 'woocommerce_template_loop_add_to_cart', 10 );
remove_action( 'woocommerce_after_shop_loop_item_title', 'woocommerce_template_loop_rating', 5 );

/**
 * Collect Finish attribute option labels for a product.
 *
 * @param WC_Product $product Product.
 * @return string[]
 */
function still_cup_product_finish_labels( WC_Product $product ): array {
	$labels = array();

	if ( $product->is_type( 'variable' ) ) {
		$attributes = $product->get_variation_attributes();
		foreach ( $attributes as $attr_name => $options ) {
			if ( ! still_cup_is_finish_attribute( $attr_name ) ) {
				continue;
			}
			foreach ( (array) $options as $option ) {
				$labels[] = still_cup_attribute_label_text( $attr_name, (string) $option );
			}
		}
	} else {
		$attributes = $product->get_attributes();
		foreach ( $attributes as $attribute ) {
			if ( ! $attribute instanceof WC_Product_Attribute ) {
				continue;
			}
			$name = $attribute->get_name();
			if ( ! still_cup_is_finish_attribute( $name ) ) {
				continue;
			}
			if ( $attribute->is_taxonomy() ) {
				$terms = wc_get_product_terms( $product->get_id(), $name, array( 'fields' => 'names' ) );
				if ( is_array( $terms ) ) {
					$labels = array_merge( $labels, $terms );
				}
			} else {
				$labels = array_merge( $labels, $attribute->get_options() );
			}
		}
	}

	$labels = array_values( array_unique( array_filter( array_map( 'strval', $labels ) ) ) );
	return $labels;
}

/**
 * Whether an attribute key is Finish.
 */
function still_cup_is_finish_attribute( string $attr_name ): bool {
	$key = strtolower( str_replace( 'attribute_', '', $attr_name ) );
	$key = str_replace( 'pa_', '', $key );
	return in_array( $key, array( 'finish', 'finishes', 'colour', 'color' ), true );
}

/**
 * Whether an attribute key is Capacity.
 */
function still_cup_is_capacity_attribute( string $attr_name ): bool {
	$key = strtolower( str_replace( 'attribute_', '', $attr_name ) );
	$key = str_replace( 'pa_', '', $key );
	return in_array( $key, array( 'capacity', 'size', 'volume' ), true );
}

/**
 * Human label for an attribute option.
 */
function still_cup_attribute_label_text( string $attr_name, string $option ): string {
	$taxonomy = str_replace( 'attribute_', '', $attr_name );
	if ( taxonomy_exists( $taxonomy ) ) {
		$term = get_term_by( 'slug', $option, $taxonomy );
		if ( $term instanceof WP_Term ) {
			return $term->name;
		}
	}
	return $option;
}

/**
 * Swatch hex for known finishes.
 */
function still_cup_finish_swatch_color( string $label ): string {
	$map = array(
		'sand'  => '#CBB89E',
		'olive' => '#7F8D70',
		'chalk' => '#E5E0D7',
	);
	$key = strtolower( trim( $label ) );
	return $map[ $key ] ?? '#CFCFC4';
}

/**
 * Shop toolbar: category filters + sort.
 */
function still_cup_shop_toolbar(): void {
	if ( ! is_shop() && ! is_product_taxonomy() ) {
		return;
	}

	$shop_url = wc_get_page_permalink( 'shop' );
	$cats     = array(
		array(
			'label' => __( 'All cups', 'still-cup' ),
			'url'   => $shop_url,
			'slug'  => '',
		),
	);

	foreach ( array( 'Mugs', 'Cups', 'Tumblers' ) as $name ) {
		$term = get_term_by( 'name', $name, 'product_cat' );
		$url  = $shop_url;
		$slug = sanitize_title( $name );
		if ( $term instanceof WP_Term && ! is_wp_error( $term ) ) {
			$link = get_term_link( $term );
			if ( ! is_wp_error( $link ) ) {
				$url  = $link;
				$slug = $term->slug;
			}
		} else {
			// Category not created yet — keep label visible; catalogue feature will wire URLs.
			$url = add_query_arg( 'product_cat', $slug, $shop_url );
		}
		$cats[] = array(
			'label' => $name,
			'url'   => $url,
			'slug'  => $slug,
			'all'   => false,
		);
	}

	$cats[0]['all'] = true;

	$current_slug = is_product_category() ? get_queried_object()->slug : '';
	$orderby      = isset( $_GET['orderby'] ) ? wc_clean( wp_unslash( (string) $_GET['orderby'] ) ) : 'menu_order'; // phpcs:ignore WordPress.Security.NonceVerification.Recommended
	?>
	<div class="sc-shop-toolbar">
		<div class="sc-shop-filters" role="navigation" aria-label="<?php esc_attr_e( 'Product categories', 'still-cup' ); ?>">
			<?php foreach ( $cats as $cat ) : ?>
				<?php
				$is_all = ! empty( $cat['all'] );
				$active = ( $is_all && $current_slug === '' && ( is_shop() || is_post_type_archive( 'product' ) ) )
					|| ( ! $is_all && $cat['slug'] !== '' && $cat['slug'] === $current_slug );
				?>
				<a
					class="sc-shop-filters__link<?php echo $active ? ' is-active' : ''; ?>"
					href="<?php echo esc_url( $cat['url'] ); ?>"
					<?php echo $active ? ' aria-current="page"' : ''; ?>
				>
					<?php echo esc_html( $cat['label'] ); ?>
				</a>
			<?php endforeach; ?>
			<?php if ( $current_slug !== '' ) : ?>
				<a class="sc-shop-filters__reset" href="<?php echo esc_url( $shop_url ); ?>">
					<?php esc_html_e( 'Reset', 'still-cup' ); ?>
				</a>
			<?php endif; ?>
		</div>

		<form class="sc-shop-sort" method="get" action="">
			<label class="sc-shop-sort__label" for="sc-orderby"><?php esc_html_e( 'Sort', 'still-cup' ); ?></label>
			<select name="orderby" id="sc-orderby" class="sc-shop-sort__select" onchange="this.form.submit()">
				<?php
				$options = array(
					'menu_order' => __( 'Featured', 'still-cup' ),
					'price'      => __( 'Price low to high', 'still-cup' ),
					'price-desc' => __( 'Price high to low', 'still-cup' ),
					'date'       => __( 'Latest', 'still-cup' ),
				);
				foreach ( $options as $value => $label ) {
					printf(
						'<option value="%1$s" %2$s>%3$s</option>',
						esc_attr( $value ),
						selected( $orderby, $value, false ),
						esc_html( $label )
					);
				}
				?>
			</select>
			<?php wc_query_string_form_fields( null, array( 'orderby', 'submit', 'paged' ) ); ?>
		</form>
	</div>
	<?php
}
add_action( 'woocommerce_before_shop_loop', 'still_cup_shop_toolbar', 15 );
add_action( 'woocommerce_no_products_found', 'still_cup_shop_toolbar', 5 );

/**
 * Hide pagination when total pages <= 1.
 */
function still_cup_maybe_remove_pagination(): void {
	global $wp_query;
	if ( isset( $wp_query->max_num_pages ) && (int) $wp_query->max_num_pages <= 1 ) {
		remove_action( 'woocommerce_after_shop_loop', 'woocommerce_pagination', 10 );
	}
}
add_action( 'woocommerce_before_shop_loop', 'still_cup_maybe_remove_pagination', 5 );

/**
 * Default variation attributes: prefer Sand finish and 300 ml capacity when purchasable.
 *
 * @param array      $defaults Defaults.
 * @param WC_Product $product  Product.
 */
function still_cup_default_variation_attributes( array $defaults, WC_Product $product ): array {
	if ( ! $product->is_type( 'variable' ) ) {
		return $defaults;
	}

	/** @var WC_Product_Variable $product */
	$attributes = $product->get_variation_attributes();
	$available  = $product->get_available_variations();

	foreach ( $attributes as $attr_name => $options ) {
		$full_key = 'attribute_' . sanitize_title( $attr_name );
		if ( ! empty( $defaults[ $attr_name ] ) || ! empty( $defaults[ $full_key ] ) ) {
			continue;
		}

		$preferred = null;
		if ( still_cup_is_finish_attribute( $attr_name ) ) {
			$preferred = 'Sand';
		} elseif ( still_cup_is_capacity_attribute( $attr_name ) && stripos( $product->get_name(), 'Everyday Mug' ) !== false ) {
			$preferred = '300';
		}

		if ( null === $preferred ) {
			continue;
		}

		foreach ( (array) $options as $option ) {
			$label = still_cup_attribute_label_text( $attr_name, (string) $option );
			if ( stripos( $label, $preferred ) === false && strcasecmp( (string) $option, $preferred ) !== 0 ) {
				continue;
			}
			// Ensure at least one purchasable variation includes this option.
			foreach ( $available as $variation ) {
				if ( empty( $variation['is_purchasable'] ) || empty( $variation['is_in_stock'] ) ) {
					continue;
				}
				$vattrs = $variation['attributes'];
				$slug   = 'attribute_' . sanitize_title( $attr_name );
				if ( isset( $vattrs[ $slug ] ) && (string) $vattrs[ $slug ] === (string) $option ) {
					$defaults[ $attr_name ] = $option;
					break 2;
				}
			}
		}
	}

	return $defaults;
}
add_filter( 'woocommerce_product_get_default_attributes', 'still_cup_default_variation_attributes', 10, 2 );

/**
 * Body classes for templates.
 *
 * @param string[] $classes Classes.
 */
function still_cup_body_classes( array $classes ): array {
	if ( is_front_page() ) {
		$classes[] = 'sc-is-home';
	}
	if ( function_exists( 'is_shop' ) && ( is_shop() || is_product_taxonomy() ) ) {
		$classes[] = 'sc-is-shop';
	}
	if ( function_exists( 'is_product' ) && is_product() ) {
		$classes[] = 'sc-is-product';
	}
	if ( function_exists( 'is_cart' ) && is_cart() ) {
		$classes[] = 'sc-is-bag';
	}
	if ( function_exists( 'is_checkout' ) && is_checkout() ) {
		$classes[] = 'sc-is-checkout';
	}
	return $classes;
}
add_filter( 'body_class', 'still_cup_body_classes' );
