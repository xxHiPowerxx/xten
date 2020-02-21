<?php
/**
 * XTen Theme Customizer
 *
 * @package xten
 */

/**
 * Add support for Theme Options in Customizer.
 *
 * @param WP_Customize_Manager $wp_customize Theme Customizer object.
 */
function xten_customize_theme_register( $wp_customize ) {
	$pairing_selection = include get_template_directory() . '/inc/customizer/pairing-selection.php';
	// var_dump( $pairing_selection );
	/**
	 * Theme options.
	 */
	$wp_customize->add_section(
		'theme_options',
		array(
			'title'    => __( 'Theme Options', 'xten' ),
			'priority' => 130, // Before Additional CSS.
		)
	);

	// Font Pairing Selection
	$wp_customize->add_setting(
		'font_pairings',
		array(
			'default'           => '{"heading":"roboto","heading_fallback":"Arial, sans-serif","body":"opensans","body_fallback":"Arial, sans-serif"}',
			'transport'         => 'postMessage',
		)
	);

	$wp_customize->add_control(
		'font_pairings',
		array(
			'label'           => __( 'Font Pairings', 'xten' ),
			'section'         => 'theme_options',
			'type'            => 'radio',
			'description'     => __( 'Six standardized font treatments are provided below as follows: The first font listed in each pairing is used for Headings H1-H3 while the second font is used for Headings H4-H6, P and Body tags.', 'xten' ),
			'choices'         => $pairing_selection,
		)
	);

	$wp_customize->get_setting( 'font_pairings' )->transport = 'postMessage';

	// Theme Font-Family.

	// $wp_customize->add_setting(
	// 'theme_font_family',
	// array(
	// 'default'   => '{"type":"google","value":"cabin"}',
	// 'transport' => 'postMessage',
	// )
	// );

	// $wp_customize->add_control(
	// new WP_Customize_Control(
	// $wp_customize,
	// 'theme_font_family',
	// array(
	// 'label'       => __( 'Theme Font Family', 'xten' ),
	// 'section'     => 'theme_options',
	// 'settings'    => 'theme_font_family',
	// 'description' => __( 'Theme Body, P Font-Family', 'xten' ),
	// 'type'        => 'select',
	// 'choices'     => $font_selection,
	// )
	// )
	// );
	// $wp_customize->get_setting( 'theme_font_family' )->transport = 'postMessage';

	// // Theme Heading Font-Family.
	// $wp_customize->add_setting(
	// 'theme_heading_font_family',
	// array(
	// 'default'   => '{"type":"google","value":"roboto"}',
	// 'transport' => 'postMessage',
	// )
	// );

	// $wp_customize->add_control(
	// new WP_Customize_Control(
	// $wp_customize,
	// 'theme_heading_font_family',
	// array(
	// 'label'       => __( 'Theme Heading Font Family', 'xten' ),
	// 'section'     => 'theme_options',
	// 'settings'    => 'theme_heading_font_family',
	// 'description' => __( 'Theme Heading Font-Family', 'xten' ),
	// 'type'        => 'select',
	// 'choices'     => $font_selection,
	// )
	// )
	// );

	// $wp_customize->get_setting( 'theme_heading_font_family' )->transport = 'postMessage';

	// Theme Color.
	$wp_customize->add_setting(
		'xten_theme_color',
		array(
			'default'           => '#003366',
			'sanitize_callback' => 'sanitize_hex_color',
			'transport'         => 'postMessage',
		)
	);

	$wp_customize->add_control(
		new WP_Customize_Color_Control(
			$wp_customize,
			'xten_theme_color',
			array(
				'label'       => __( 'Theme Color', 'xten' ),
				'section'     => 'theme_options',
				'settings'    => 'xten_theme_color',
			)
		)
	);
	$wp_customize->get_setting( 'xten_theme_color' )->transport = 'postMessage';

	// Link Color.
	$wp_customize->add_setting(
		'xten_link_color',
		array(
			'default'           => '#007db6',
			'sanitize_callback' => 'sanitize_hex_color',
			'transport'         => 'postMessage',
		)
	);

	$wp_customize->add_control(
		new WP_Customize_Color_Control(
			$wp_customize,
			'xten_link_color',
			array(
				'label'       => __( 'Link Color', 'xten' ),
				'section'     => 'theme_options',
				'settings'    => 'xten_link_color',
			)
		)
	);
	$wp_customize->get_setting( 'xten_link_color' )->transport = 'postMessage';
}
add_action( 'customize_register', 'xten_customize_theme_register' );
