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
	echo '<div class="contents">';
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
	<div class="grid gap-4 desktop:grid-cols-[minmax(0,480px)_260px] desktop:justify-between desktop:items-center mb-4 desktop:mb-5">
		<div class="flex flex-wrap items-center gap-0 min-h-[52px] px-5 border border-border bg-surface" role="navigation" aria-label="<?php esc_attr_e( 'Product categories', 'still-cup' ); ?>">
			<?php
			$filter_i = 0;
			foreach ( $cats as $cat ) :
				$is_all = ! empty( $cat['all'] );
				$active = ( $is_all && $current_slug === '' && ( is_shop() || is_post_type_archive( 'product' ) ) )
					|| ( ! $is_all && $cat['slug'] !== '' && $cat['slug'] === $current_slug );
				if ( $filter_i > 0 ) {
					echo '<span class="mx-[0.55rem] opacity-55" aria-hidden="true">/</span>';
				}
				++$filter_i;
				?>
				<a
					class="inline-flex items-center min-h-touch text-[15px] no-underline text-primary<?php echo $active ? ' underline underline-offset-[0.2em]' : ''; ?>"
					href="<?php echo esc_url( $cat['url'] ); ?>"
					<?php echo $active ? ' aria-current="page"' : ''; ?>
				>
					<?php echo esc_html( $cat['label'] ); ?>
				</a>
			<?php endforeach; ?>
			<?php if ( $current_slug !== '' ) : ?>
				<span class="mx-[0.55rem] opacity-55" aria-hidden="true">/</span>
				<a class="inline-flex items-center min-h-touch text-[15px] no-underline text-primary" href="<?php echo esc_url( $shop_url ); ?>">
					<?php esc_html_e( 'Reset', 'still-cup' ); ?>
				</a>
			<?php endif; ?>
		</div>

		<form class="relative flex items-stretch min-h-[52px] border border-border bg-surface" method="get" action="">
			<label class="sr-only" for="sc-orderby"><?php esc_html_e( 'Sort', 'still-cup' ); ?></label>
			<select name="orderby" id="sc-orderby" class="w-full min-h-[52px] px-5 border-0 bg-transparent font-body text-[15px] text-primary" onchange="this.form.submit()">
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
	if ( ! is_front_page() ) {
		$classes[] = 'sc-has-header-rule';
	}
	return $classes;
}
add_filter( 'body_class', 'still_cup_body_classes' );

/**
 * Shop archive heading matches Pencil shop artboard.
 *
 * @param string $title Title.
 */
function still_cup_shop_page_title( string $title ): string {
	if ( function_exists( 'is_shop' ) && is_shop() ) {
		return __( 'Find your kind of cup.', 'still-cup' );
	}
	return $title;
}
add_filter( 'woocommerce_page_title', 'still_cup_shop_page_title' );

/**
 * Hide the bare H1 from woocommerce_content(); theme prints Pencil shop intro instead.
 */
add_filter( 'woocommerce_show_page_title', '__return_false' );

/**
 * Pencil shop intro (eyebrow + title + copy).
 * Hooked on archive_description because theme woocommerce.php uses woocommerce_content().
 */
function still_cup_shop_intro(): void {
	if ( ! is_shop() && ! is_product_taxonomy() ) {
		return;
	}
	?>
	<header class="woocommerce-products-header mb-7">
		<p class="m-0 mb-3 text-[12px] tracking-[0.02em]"><?php esc_html_e( 'The collection', 'still-cup' ); ?></p>
		<h1 class="woocommerce-products-header__title page-title m-0 mb-3 font-display text-[clamp(2rem,5vw,3.875rem)] font-normal leading-[1.2]"><?php woocommerce_page_title(); ?></h1>
		<p class="m-0 text-base desktop:text-[18px] max-w-[40rem]"><?php esc_html_e( 'A small collection, made for everyday moments.', 'still-cup' ); ?></p>
	</header>
	<?php
}
add_action( 'woocommerce_archive_description', 'still_cup_shop_intro', 5 );

/**
 * Product: breadcrumbs above the product grid (Pencil).
 */
function still_cup_product_breadcrumb(): void {
	if ( ! is_product() ) {
		return;
	}
	woocommerce_breadcrumb(
		array(
			'delimiter'   => ' / ',
			'wrap_before' => '<nav class="woocommerce-breadcrumb desktop:col-span-2 text-[12px] desktop:text-[13px] m-0 mb-4 desktop:mb-6" aria-label="' . esc_attr__( 'Breadcrumb', 'still-cup' ) . '">',
			'wrap_after'  => '</nav>',
		)
	);
}
remove_action( 'woocommerce_before_main_content', 'woocommerce_breadcrumb', 20 );

/**
 * Collection label above product title.
 */
function still_cup_product_collection_label(): void {
	global $product;
	if ( ! $product instanceof WC_Product ) {
		return;
	}
	$label = still_cup_product_collection_text( $product );
	if ( $label === '' ) {
		return;
	}
	echo '<p class="m-0 mb-2 text-[12px] tracking-[0.06em] uppercase">' . esc_html( $label ) . '</p>';
}
add_action( 'woocommerce_single_product_summary', 'still_cup_product_collection_label', 4 );

/**
 * Collection / category label for product summary.
 */
function still_cup_product_collection_text( WC_Product $product ): string {
	$custom = get_post_meta( $product->get_id(), '_sc_collection', true );
	if ( is_string( $custom ) && $custom !== '' ) {
		return $custom;
	}
	$terms = get_the_terms( $product->get_id(), 'product_cat' );
	if ( ! is_array( $terms ) ) {
		return '';
	}
	foreach ( $terms as $term ) {
		if ( $term instanceof WP_Term && $term->slug !== 'uncategorized' ) {
			return sprintf(
				/* translators: %s: category name */
				__( '%s collection', 'still-cup' ),
				$term->name
			);
		}
	}
	return '';
}

/**
 * Photo caption under gallery.
 */
function still_cup_product_photo_note(): void {
	echo '<p class="m-0 mt-3 text-[13px]">' . esc_html__( 'Photography reflects the product shape, texture and tone.', 'still-cup' ) . '</p>';
}
add_action( 'woocommerce_before_single_product_summary', 'still_cup_product_photo_note', 25 );

/**
 * Shipping policy under add-to-bag.
 */
function still_cup_product_shipping_note(): void {
	echo '<p class="m-0 mt-3 text-[14px]">' . esc_html__( '$9.95 standard shipping · free over $100. Australia-wide.', 'still-cup' ) . '</p>';
}
add_action( 'woocommerce_single_product_summary', 'still_cup_product_shipping_note', 35 );

/**
 * Stock message styling hook placement after price/description.
 */
function still_cup_product_stock_message(): void {
	global $product;
	if ( ! $product instanceof WC_Product || ! $product->is_in_stock() ) {
		return;
	}
	echo '<p class="m-0 my-3 text-[14px]">' . esc_html__( 'In stock · Ready to dispatch in 2–3 business days.', 'still-cup' ) . '</p>';
}
add_action( 'woocommerce_single_product_summary', 'still_cup_product_stock_message', 25 );

/**
 * Add to bag button label.
 *
 * @param string     $text    Text.
 * @param WC_Product $product Product.
 */
function still_cup_add_to_cart_text( string $text, WC_Product $product ): string {
	if ( is_product() ) {
		$price = $product->get_price();
		if ( $price !== '' && $price !== null ) {
			return sprintf(
				/* translators: %s: formatted price */
				__( 'Add to bag — %s', 'still-cup' ),
				wp_strip_all_tags( wc_price( (float) $price ) )
			);
		}
		return __( 'Add to bag', 'still-cup' );
	}
	return __( 'View product', 'still-cup' );
}
add_filter( 'woocommerce_product_single_add_to_cart_text', 'still_cup_add_to_cart_text', 10, 2 );
add_filter( 'woocommerce_product_add_to_cart_text', 'still_cup_add_to_cart_text', 10, 2 );

/**
 * Hide default meta / rating (Pencil uses breadcrumb + details instead).
 */
remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_meta', 40 );
remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_rating', 10 );

/**
 * Replace Reviews tabs with Pencil details rows.
 */
remove_action( 'woocommerce_after_single_product_summary', 'woocommerce_output_product_data_tabs', 10 );
remove_action( 'woocommerce_after_single_product_summary', 'woocommerce_upsell_display', 15 );
remove_action( 'woocommerce_after_single_product_summary', 'woocommerce_output_related_products', 20 );

/**
 * Render Pencil product details rows.
 */
function still_cup_output_product_details(): void {
	wc_get_template( 'single-product/product-details.php' );
}
add_action( 'woocommerce_after_single_product_summary', 'still_cup_output_product_details', 10 );

/**
 * Detail rows for product page (desktop expanded / mobile accordion via CSS).
 *
 * @param WC_Product $product Product.
 * @return array<int, array{label: string, value: string}>
 */
function still_cup_product_detail_rows( WC_Product $product ): array {
	$details = get_post_meta( $product->get_id(), '_sc_details', true );
	$care    = get_post_meta( $product->get_id(), '_sc_care', true );
	$ship    = get_post_meta( $product->get_id(), '_sc_shipping', true );

	if ( ! is_string( $details ) || $details === '' ) {
		$parts = array();
		$attrs = $product->get_attributes();
		foreach ( $attrs as $attribute ) {
			if ( ! $attribute instanceof WC_Product_Attribute ) {
				continue;
			}
			$name = $attribute->get_name();
			if ( still_cup_is_capacity_attribute( $name ) ) {
				if ( $attribute->is_taxonomy() ) {
					$terms = wc_get_product_terms( $product->get_id(), $name, array( 'fields' => 'names' ) );
					if ( is_array( $terms ) && $terms ) {
						$parts[] = implode( ' · ', $terms );
					}
				} else {
					$parts[] = implode( ' · ', array_map( 'strval', $attribute->get_options() ) );
				}
			}
		}
		$short = $product->get_short_description();
		if ( $short ) {
			$parts[] = wp_strip_all_tags( $short );
		}
		$details = $parts ? implode( ' · ', $parts ) : __( 'Capacity and dimensions listed with each finish.', 'still-cup' );
	}

	if ( ! is_string( $care ) || $care === '' ) {
		$care = __( 'Dishwasher safe; hand wash for best finish.', 'still-cup' );
	}
	if ( ! is_string( $ship ) || $ship === '' ) {
		$ship = __( 'Dispatch in 1–3 business days. Packed with care.', 'still-cup' );
	}

	return array(
		array(
			'label' => __( 'Details', 'still-cup' ),
			'value' => $details,
		),
		array(
			'label' => __( 'Care', 'still-cup' ),
			'value' => $care,
		),
		array(
			'label' => __( 'Shipping & returns', 'still-cup' ),
			'value' => $ship,
		),
	);
}

/**
 * Free-shipping threshold message on bag.
 */
function still_cup_bag_threshold_message(): void {
	if ( ! WC()->cart ) {
		return;
	}
	$threshold = (float) apply_filters( 'still_cup_free_shipping_threshold', 100 );
	$subtotal  = (float) WC()->cart->get_displayed_subtotal();
	if ( WC()->cart->display_prices_including_tax() ) {
		$subtotal = (float) WC()->cart->get_subtotal() + (float) WC()->cart->get_subtotal_tax();
	} else {
		$subtotal = (float) WC()->cart->get_subtotal();
	}
	// Prefer discounted merchandise subtotal when coupons apply.
	$discounted = (float) WC()->cart->get_cart_contents_total();
	if ( $discounted > 0 ) {
		$subtotal = $discounted;
	}

	if ( $subtotal >= $threshold ) {
		echo '<p class="my-6 mb-4 text-base">' . esc_html__( 'You’ve unlocked free standard shipping.', 'still-cup' ) . '</p>';
		return;
	}

	$remaining = $threshold - $subtotal;
	echo '<p class="my-6 mb-4 text-base">' . esc_html(
		sprintf(
			/* translators: %s: formatted remaining amount */
			__( 'You’re %s away from free shipping.', 'still-cup' ),
			wp_strip_all_tags( wc_price( $remaining ) )
		)
	) . '</p>';
}

/**
 * Move result count below toolbar.
 */
remove_action( 'woocommerce_before_shop_loop', 'woocommerce_result_count', 20 );
add_action( 'woocommerce_before_shop_loop', 'woocommerce_result_count', 25 );

/**
 * Add-to-bag success notice — Pencil/delivery: announce with View bag link.
 *
 * @param string     $message Message HTML.
 * @param int|array  $products Product ID(s).
 * @param bool       $show_qty Whether qty is shown.
 */
function still_cup_add_to_cart_message_html( string $message, $products, bool $show_qty = false ): string {
	$titles = array();
	$count  = 0;

	if ( ! is_array( $products ) ) {
		$products = array( $products => 1 );
	}

	foreach ( $products as $product_id => $qty ) {
		$product = wc_get_product( $product_id );
		if ( ! $product ) {
			continue;
		}
		$count   += (int) $qty;
		$titles[] = $show_qty && (int) $qty > 1
			? sprintf( '%s &times; %s', (int) $qty, $product->get_name() )
			: sprintf( '&ldquo;%s&rdquo;', $product->get_name() );
	}

	if ( empty( $titles ) ) {
		return $message;
	}

	$added = $count > 1
		? sprintf(
			/* translators: %s: product names */
			__( '%s have been added to your bag.', 'still-cup' ),
			wc_format_list_of_items( $titles )
		)
		: sprintf(
			/* translators: %s: product name */
			__( '%s has been added to your bag.', 'still-cup' ),
			$titles[0]
		);

	return sprintf(
		'<span class="flex-auto">%1$s</span> <a href="%2$s" class="shrink-0 text-[15px] underline underline-offset-[0.2em] text-primary whitespace-nowrap hover:opacity-85" tabindex="1">%3$s</a>',
		wp_kses_post( $added ),
		esc_url( wc_get_cart_url() ),
		esc_html__( 'View bag', 'still-cup' )
	);
}
add_filter( 'wc_add_to_cart_message_html', 'still_cup_add_to_cart_message_html', 10, 3 );
