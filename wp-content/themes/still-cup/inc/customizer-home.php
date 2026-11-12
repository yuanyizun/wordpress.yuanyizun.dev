<?php
/**
 * Homepage Customizer settings (editable without PHP).
 *
 * @package Still_Cup
 */

declare(strict_types=1);

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Register home content controls.
 *
 * @param WP_Customize_Manager $wp_customize Customizer.
 */
function still_cup_customize_home( WP_Customize_Manager $wp_customize ): void {
	$wp_customize->add_section(
		'still_cup_home',
		array(
			'title'    => __( 'Still Cup homepage', 'still-cup' ),
			'priority' => 31,
		)
	);

	$fields = array(
		'still_cup_hero_eyebrow' => array(
			'label'   => __( 'Hero eyebrow', 'still-cup' ),
			'default' => __( 'Small moments, well made', 'still-cup' ),
		),
		'still_cup_hero_heading' => array(
			'label'   => __( 'Hero heading', 'still-cup' ),
			'default' => __( 'Make room for a slower sip.', 'still-cup' ),
		),
		'still_cup_hero_text'    => array(
			'label'   => __( 'Hero description', 'still-cup' ),
			'default' => __( 'Thoughtfully made ceramic cups for the coffee, the conversation, and the pause in between.', 'still-cup' ),
			'type'    => 'textarea',
		),
		'still_cup_hero_cta'     => array(
			'label'   => __( 'Hero CTA label', 'still-cup' ),
			'default' => __( 'Shop the collection', 'still-cup' ),
		),
		'still_cup_hero_cta_url' => array(
			'label'   => __( 'Hero CTA URL', 'still-cup' ),
			'default' => '',
		),
		'still_cup_hero_caption' => array(
			'label'   => __( 'Hero image caption', 'still-cup' ),
			'default' => __( 'The everyday collection / 01', 'still-cup' ),
		),
		'still_cup_benefits'     => array(
			'label'   => __( 'Benefits strip', 'still-cup' ),
			'default' => __( 'Considered ceramics  ·  Carefully packed  ·  Australian owned', 'still-cup' ),
		),
		'still_cup_featured_eyebrow' => array(
			'label'   => __( 'Featured eyebrow', 'still-cup' ),
			'default' => __( 'Find your everyday favourite', 'still-cup' ),
		),
		'still_cup_featured_heading' => array(
			'label'   => __( 'Featured heading', 'still-cup' ),
			'default' => __( 'Good mornings start here.', 'still-cup' ),
		),
		'still_cup_story_eyebrow' => array(
			'label'   => __( 'Story eyebrow', 'still-cup' ),
			'default' => __( 'Our approach', 'still-cup' ),
		),
		'still_cup_story_heading' => array(
			'label'   => __( 'Story heading', 'still-cup' ),
			'default' => __( 'Less, but loved more.', 'still-cup' ),
		),
		'still_cup_story_text' => array(
			'label'   => __( 'Story copy', 'still-cup' ),
			'default' => __( 'Simple shapes. Tactile finishes. Cups that feel at home in your hands, and earn their place on your shelf.', 'still-cup' ),
			'type'    => 'textarea',
		),
		'still_cup_story_link_label' => array(
			'label'   => __( 'Story link label', 'still-cup' ),
			'default' => __( 'Meet Still Cup', 'still-cup' ),
		),
		'still_cup_story_link_url' => array(
			'label'   => __( 'Story link URL', 'still-cup' ),
			'default' => '/our-story/',
		),
	);

	foreach ( $fields as $id => $field ) {
		$wp_customize->add_setting(
			$id,
			array(
				'default'           => $field['default'],
				'sanitize_callback' => ( $field['type'] ?? '' ) === 'textarea' ? 'sanitize_textarea_field' : 'sanitize_text_field',
				'transport'         => 'refresh',
			)
		);
		$wp_customize->add_control(
			$id,
			array(
				'label'   => $field['label'],
				'section' => 'still_cup_home',
				'type'    => $field['type'] ?? 'text',
			)
		);
	}

	$wp_customize->add_setting(
		'still_cup_hero_image',
		array(
			'default'           => 0,
			'sanitize_callback' => 'absint',
		)
	);
	$wp_customize->add_control(
		new WP_Customize_Media_Control(
			$wp_customize,
			'still_cup_hero_image',
			array(
				'label'     => __( 'Hero image', 'still-cup' ),
				'section'   => 'still_cup_home',
				'mime_type' => 'image',
			)
		)
	);
}
add_action( 'customize_register', 'still_cup_customize_home' );

/**
 * Theme mod helper with default.
 */
function still_cup_mod( string $key, string $default = '' ): string {
	$value = get_theme_mod( $key, $default );
	return is_string( $value ) && $value !== '' ? $value : $default;
}
