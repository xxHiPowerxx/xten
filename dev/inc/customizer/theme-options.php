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
	$font_selection = include get_template_directory() . '/inc/customizer/font-selection.php';
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

	// Primary Font-Family.

	$wp_customize->add_setting(
	'primary_font_family',
	array(
		'default'   => '{"type":"google","value":"cabin"}',
		'transport' => 'postMessage',
	)
	);

	$wp_customize->add_control(
		new WP_Customize_Control(
			$wp_customize,
			'primary_font_family',
			array(
				'label'       => __( 'Primary Font Family', 'xten' ),
				'section'     => 'theme_options',
				'settings'    => 'primary_font_family',
				'description' => __( 'Font Family for Body, &lt;p&gt;, &lt;ul&gt;, &lt;ol&gt;, etc...', 'xten' ),
				'type'        => 'select',
				'choices'     => $font_selection,
			)
		)
	);
	$wp_customize->get_setting( 'primary_font_family' )->transport = 'postMessage';
	// /Primary Font-Family.

	// Secondary Font-Family.
	$wp_customize->add_setting(
	'secondary_font_family',
		array(
			'default'   => '{"type":"google","value":"roboto"}',
			'transport' => 'postMessage',
		)
	);

	$wp_customize->add_control(
		new WP_Customize_Control(
			$wp_customize,
			'secondary_font_family',
			array(
				'label'       => __( 'Secondary Font Family', 'xten' ),
				'section'     => 'theme_options',
				'settings'    => 'secondary_font_family',
				'description' => __( 'Font-Family mostly used for Headings', 'xten' ),
				'type'        => 'select',
				'choices'     => $font_selection,
			)
		)
	);
	$wp_customize->get_setting( 'secondary_font_family' )->transport = 'postMessage';
	// /Secondary Font-Family.
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
