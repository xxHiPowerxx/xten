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

	// Display Site Phone Number Next to Header Logo.
	$wp_customize->add_setting(
		'xten_site_phone_number_with_logo',
		array(
			'default'           => false,
			'transport'         => 'postMessage',
		)
	);

	$wp_customize->add_control(
		'xten_site_phone_number_with_logo',
		array(
			'priority'    => 2,
			'type'        => 'checkbox',
			'label'       => __( 'Display Site Phone Number Next to Header Logo?', 'xten' ),
			'section'     => 'xten_header_options',
			'settings'    => 'xten_site_phone_number_with_logo',
		)
	);
	$wp_customize->get_setting( 'xten_site_phone_number_with_logo' )->transport = 'postMessage';
	// /Display Site Phone Number Next to Logo.

	// Header Main Nav Start!
	// Separator.
	$wp_customize->add_setting( 'xten_header_options_group', array() );

	$wp_customize->add_control(
		new Prefix_Custom_Content(
			$wp_customize,
			'xten_header_options_group',
			array(
				'section'    => 'xten_header_options',
				'content'    => __( '<h2 style="font-size: 1.6em;">Header Colors</h2> <hr style="border-color: rgb(140, 140, 140);">', 'xten' ),
			)
		)
	);
	// /Separator.

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
	// /Header Background Color Opacity

	// Header Menu Item Color.
	$wp_customize->add_setting(
		'xten_header_menu_item_color',
		array(
			'default'           => '#fff',
			'sanitize_callback' => 'sanitize_hex_color',
			'transport'         => 'postMessage',
		)
	);

	$wp_customize->add_control(
		new WP_Customize_Color_Control(
			$wp_customize,
			'xten_header_menu_item_color',
			array(
				'label'       => __( 'Header Menu Item Color', 'xten' ),
				'section'     => 'xten_header_options',
				'settings'    => 'xten_header_menu_item_color',
				'description' => __( 'Set Header Menu Item Color', 'xten' ),
			)
		)
	);
	$wp_customize->get_setting( 'xten_header_menu_item_color' )->transport = 'postMessage';
	// /Header Menu Item Color.

	// Header Sub-Menu Background Color.
	$wp_customize->add_setting(
		'xten_header_sub_menu_bg_color',
		array(
			'default'           => '#fff',
			'sanitize_callback' => 'sanitize_hex_color',
			'transport'         => 'postMessage',
		)
	);

	$wp_customize->add_control(
		new WP_Customize_Color_Control(
			$wp_customize,
			'xten_header_sub_menu_bg_color',
			array(
				'label'       => __( 'Header Sub-Menu Background Color', 'xten' ),
				'section'     => 'xten_header_options',
				'settings'    => 'xten_header_sub_menu_bg_color',
				'description' => __( 'Set Header Sub-Menu Background Color', 'xten' ),
			)
		)
	);
	$wp_customize->get_setting( 'xten_header_sub_menu_bg_color' )->transport = 'postMessage';
	// /Header Sub-Menu Background Color.

	// Header Sub Menu Background Color Opacity
	$wp_customize->add_setting(
		'xten_header_sub_menu_bg_color_opacity',
		array(
			'default'           => '100',
			'sanitize_callback' => 'wp_filter_nohtml_kses',
			'transport'         => 'postMessage',
		)
	);

	$wp_customize->add_control(
		new WP_Customize_Range_Control(
			$wp_customize,
			'xten_header_sub_menu_bg_color_opacity',
			array(
				'label'       => __( 'Header Sub Menu Background Color Opacity', 'xten' ),
				'section'     => 'xten_header_options',
				'settings'    => 'xten_header_sub_menu_bg_color_opacity',
				'description' => __( 'Set Opacity for Header Sub Menu Background Color', 'xten' ),
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
	// /Header Sub Menu Background Color Opacity

	// Header Sub-Menu Item Color.
	$wp_customize->add_setting(
		'xten_header_sub_menu_item_color',
		array(
			'default'           => '#2e528a',
			'sanitize_callback' => 'sanitize_hex_color',
			'transport'         => 'postMessage',
		)
	);

	$wp_customize->add_control(
		new WP_Customize_Color_Control(
			$wp_customize,
			'xten_header_sub_menu_item_color',
			array(
				'label'       => __( 'Header Sub-Menu Item Color', 'xten' ),
				'section'     => 'xten_header_options',
				'settings'    => 'xten_header_sub_menu_item_color',
				'description' => __( 'Set Header Sub-Menu Item Color', 'xten' ),
			)
		)
	);
	$wp_customize->get_setting( 'xten_header_sub_menu_item_color' )->transport = 'postMessage';
	// /Header Sub-Menu Item Color.

	// TODO: Create Mobile Menu Section
	// Along with Mobile Menu Options.

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

	// Header Search Icon.
	$wp_customize->add_setting(
		'main_nav_search',
		array(
			'default'           => true,
			'transport'         => 'postMessage',
		)
	);

	$wp_customize->add_control(
		'main_nav_search',
		array(
			'label'           => __( 'Header Search Icon', 'xten' ),
			'section'         => 'xten_header_options',
			'type'            => 'checkbox',
			'description'     => __( 'Choose Whether Header Search Icon Shows or Not.', 'xten' ),
		)
	);
	$wp_customize->get_setting( 'main_nav_search' )->transport = 'postMessage';
	// /Header Search Icon.

	// Header Main Nav End!
}
add_action( 'customize_register', 'xten_customize_site_header_register' );