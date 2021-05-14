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

	$priorities = array(
		'theme_fonts',
		'theme_colors',
	);

	// Theme Fonts Group
	// Theme Fonts Separator.
	$wp_customize->add_setting( 'xten_theme_fonts_group', array() );

	$wp_customize->add_control(
		new Prefix_Custom_Content(
			$wp_customize,
			'xten_theme_fonts_group',
			array(
				'section'    => 'theme_options',
				'content'    => __( '<h2 style="font-size: 1.6em;">Theme Fonts</h2> <hr style="border-color: rgb(140, 140, 140);">', 'xten' ),
				'priority'   => array_search('theme_fonts', $priorities),
			)
		)
	);
	// /Theme Fonts Separator.

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
				'priority'    => array_search('theme_fonts', $priorities),
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
				'priority'   => array_search('theme_fonts', $priorities),
			)
		)
	);
	$wp_customize->get_setting( 'secondary_font_family' )->transport = 'postMessage';
	// /Secondary Font-Family.
	// /Theme Fonts Group

	// Theme Colors Group
	// Theme Colors Separator.
	$wp_customize->add_setting( 'xten_theme_colors_group', array() );

	$wp_customize->add_control(
		new Prefix_Custom_Content(
			$wp_customize,
			'xten_theme_colors_group',
			array(
				'section'    => 'theme_options',
				'content'    => __( '<h2 style="font-size: 1.6em;">Theme Colors</h2> <hr style="border-color: rgb(140, 140, 140);">', 'xten' ),
				'priority'   => array_search('theme_colors', $priorities),
			)
		)
	);
	// /Theme Colors Separator.

	// TODO: Place Defaults into a $GLOBALS, for a SINGLE SOURCE OF TRUTH.
	// Primary Theme Color.
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
				'label'       => __( 'Primary Theme Color', 'xten' ),
				'section'     => 'theme_options',
				'settings'    => 'xten_theme_color',
				'priority'    => array_search('theme_colors', $priorities),
			)
		)
	);
	$wp_customize->get_setting( 'xten_theme_color' )->transport = 'postMessage';
	// /Primary Theme Color.

	// Secondary Theme Color.
	$wp_customize->add_setting(
		'xten_secondary_theme_color',
		array(
			'default'           => '#ffffff',
			'sanitize_callback' => 'sanitize_hex_color',
			'transport'         => 'postMessage',
		)
	);

	$wp_customize->add_control(
		new WP_Customize_Color_Control(
			$wp_customize,
			'xten_secondary_theme_color',
			array(
				'label'       => __( 'Secondary Theme Color', 'xten' ),
				'section'     => 'theme_options',
				'settings'    => 'xten_secondary_theme_color',
				'priority'    => array_search('theme_colors', $priorities),
			)
		)
	);
	$wp_customize->get_setting( 'xten_secondary_theme_color' )->transport = 'postMessage';
	// /Secondary Theme Color.

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
				'priority'    => array_search('theme_colors', $priorities),
			)
		)
	);
	$wp_customize->get_setting( 'xten_link_color' )->transport = 'postMessage';
	// /Theme Colors Group

}
add_action( 'customize_register', 'xten_customize_theme_register' );
