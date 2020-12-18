<?php
/**
 * XTen Site Header Customizer
 *
 * @package xten
 */

/**
 * Add support for Site Header Options in Customizer.
 *
 * @param WP_Customize_Manager $wp_customize Site Header Customizer object.
 */
function xten_customize_site_header_register( $wp_customize ) {
	$font_selection = include get_template_directory() . '/inc/customizer/font-selection.php';
	/**
	 * Header options.
	 */
	$wp_customize->add_section(
		'xten_header_options',
		array(
			'title'       => __( 'Header Options', 'xten' ),
			'priority'    => 130, // Before Additional CSS.
		)
	);

	// Header Main Nav Start!
	// Create Custom Separator.
	$wp_customize->add_setting( 'xten_header_options_group', array() );

	$wp_customize->add_control(
		new Prefix_Custom_Content(
			$wp_customize,
			'xten_header_options_group',
			array(
				'section'    => 'xten_header_options',
				'content'    => __( '<h2 style="font-size: 1.6em;">Select Header</h2> <hr style="border-color: rgb(140, 140, 140);">', 'xten' ),
			)
		)
	);

	// Header Background Color.
	$wp_customize->add_setting(
		'xten_header_bg_color',
		array(
			'default'           => '#2e528a',
			'sanitize_callback' => 'sanitize_hex_color',
			'transport'         => 'postMessage',
		)
	);

	$wp_customize->add_control(
		new WP_Customize_Color_Control(
			$wp_customize,
			'xten_header_bg_color',
			array(
				'label'       => __( 'Header Background Color', 'xten' ),
				'section'     => 'xten_header_options',
				'settings'    => 'xten_header_bg_color',
				'description' => __( 'Set Header Background Color', 'xten' ),
			)
		)
	);
	$wp_customize->get_setting( 'xten_header_bg_color' )->transport = 'postMessage';
	// /Header Background Color.

	// Header Background Color Opacity
	$wp_customize->add_setting(
		'xten_header_bg_color_opacity',
		array(
			'default'           => '100',
			'sanitize_callback' => 'wp_filter_nohtml_kses',
			'transport'         => 'postMessage',
		)
	);

	$wp_customize->add_control(
		new WP_Customize_Range_Control(
			$wp_customize,
			'xten_header_bg_color_opacity',
			array(
				'label'       => __( 'Header Background Opacity', 'xten' ),
				'section'     => 'xten_header_options',
				'settings'    => 'xten_header_bg_color_opacity',
				'description' => __( 'Set Opacity for Header Background Color', 'xten' ),
				// 'type'        => 'range',
				'input_attrs' => array(
					'min'   => 0,
					'max'   => 100,
					'unit'  => '%',
					'step'  => 1,
					'class' => 'updateTextInput',
					'style' => 'color: #0a0',
				),
			)
		)
	);

	// Mobile Nav Breakpoint.
	$wp_customize->add_setting(
		'mobile_nav_breakpoint',
		array(
			'default'           => '1050',
			'sanitize_callback' => 'wp_filter_nohtml_kses',
			'transport'         => 'postMessage',
		)
	);

	$wp_customize->add_control(
		new WP_Customize_Range_Control(
			$wp_customize,
			'mobile_nav_breakpoint',
			array(
				'priority'    => 4,
				'label'       => __( 'Mobile Nav Breakpoint', 'xten' ),
				'section'     => 'xten_header_options',
				'settings'    => 'mobile_nav_breakpoint',
				'description' => __( 'Set the Minimum Viewport Width before the Mobile Navigation is Enabled', 'xten' ),
				// 'type'        => 'range',
				'input_attrs' => array(
					'min'   => 1050,
					'max'   => 3000,
					'unit'  => 'px',
					'step'  => 1,
					'class' => 'updateTextInput',
					'style' => 'color: #0a0',
				),
			)
		)
	);

	// Header Main Nav End!
}
add_action( 'customize_register', 'xten_customize_site_header_register' );
