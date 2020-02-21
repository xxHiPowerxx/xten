<?php
/**
 * XTen Standard Header Customizer
 *
 * @package xten
 */

/**
 * Add support for Standard Header Options in Customizer.
 *
 * @param WP_Customize_Manager $wp_customize Standard Header Customizer object.
 */
function xten_customize_standard_header_register( $wp_customize ) {
	$font_selection = include get_template_directory() . '/inc/customizer/font-selection.php';
	/**
	 * Header options.
	 */
	$wp_customize->add_section(
		'standard_header_options',
		array(
			'title'       => __( 'Header Options', 'xten' ),
			'priority'    => 130, // Before Additional CSS.
		)
	);

	// Header Main Nav Start!
	// Create Custom Separator.
	$wp_customize->add_setting( 'standard_header_options_group', array() );

	$wp_customize->add_control(
		new Prefix_Custom_Content(
			$wp_customize,
			'standard_header_options_group',
			array(
				'priority'    => 1,
				'section'    => 'standard_header_options',
				'content'    => __( '<h2 style="font-size: 1.6em;">Select Header</h2> <hr style="border-color: rgb(140, 140, 140);">', 'xten' ),
			)
		)
	);

	// Standard Header Selection.
	$wp_customize->add_setting(
		'standard_header_selection',
		array(
			'default'           => 'standard_internet_header',
			'transport'         => 'postMessage',
		)
	);

	$wp_customize->add_control(
		new WP_Customize_Control(
			$wp_customize,
			'standard_header_selection',
			array(
				'priority'    => 1,
				'label'       => __( 'Header Selection', 'xten' ),
				'section'     => 'standard_header_options',
				'settings'    => 'standard_header_selection',
				'description' => __( 'Select Which Header to Use', 'xten' ),
				'type'        => 'select',
				'choices'     => array(
					'standard_internet_header' => __( 'Internet', 'xten' ),
					'standard_intranet_header' => __( 'Intranet', 'xten' ),
				),
			)
		)
	);

	$wp_customize->get_setting( 'standard_header_selection' )->transport = 'postMessage';

	// Standard Header Logo Department Name.
	$wp_customize->add_setting(
		'standard_header_logo_department_name',
		array(
			'default'           => '',
			'transport'         => 'postMessage',
		)
	);

	$wp_customize->add_control(
		new WP_Customize_Control(
			$wp_customize,
			'standard_header_logo_department_name',
			array(
				'priority'    => 1,
				'label'       => __( 'Department Name', 'xten' ),
				'section'     => 'standard_header_options',
				'settings'    => 'standard_header_logo_department_name',
				'description' => __( 'Department Name will Display In Logo', 'xten' ),
				'type'        => 'text',
				'input_attrs' => array(
					'maxlength' => 50,
				),
			)
		)
	);

	$wp_customize->get_setting( 'standard_header_logo_department_name' )->transport = 'postMessage';

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
				'section'     => 'standard_header_options',
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
add_action( 'customize_register', 'xten_customize_standard_header_register' );
