<?php
/**
 * XTen Content Customizer
 *
 * @package xten
 */

/**
 * Add support for Content Options in Customizer.
 *
 * @param WP_Customize_Manager $wp_customize Content Customizer object.
 */
function xten_customize_content_register( $wp_customize ) {
	/**
	 * Content options.
	 */
	$wp_customize->add_section(
		'content_options',
		array(
			'title'    => __( 'Content Options', 'xten' ),
			// TODO: set Priorities in $GLOBALS a array so it can be controlled at one source.
			'priority' => 130, // Before Additional CSS.
		)
	);

	$priorities = array(
		'content_layout',
		'content_colors',
		'content_misc',
	);

	// Content Layout Group
	// Create Custom Separator.
	$wp_customize->add_setting( 'section_content_group_layout', array() );

	$wp_customize->add_control(
		new Prefix_Custom_Content(
			$wp_customize, 'section_content_group_layout', array(
				'section'    => 'content_options',
				'priority'   => array_search( 'content_layout', $priorities ),
				'content'    => __( '<h2 style="font-size: 1.6em;">Layout</h2> <hr style="border-color: rgb(140, 140, 140);">', 'xten' ),
			)
		)
	);

	// Full or Fixed Width Options.
	$wp_customize->add_setting(
		'content_width',
		array(
			'default'           => 'fixed_width',
			'transport'         => 'postMessage',
		)
	);

	$wp_customize->add_control(
		new WP_Customize_Control(
			$wp_customize,
			'content_width',
			array(
				'priority'    => array_search( 'content_layout', $priorities ),
				'label'       => __( 'Content Width', 'xten' ),
				'section'     => 'content_options',
				'settings'    => 'content_width',
				'description' => __( 'Set Content width to Full or Fixed - Width', 'xten' ),
				'type'        => 'select',
				'choices'     => array(
					'fixed_width'  => __( 'Fixed-Width', 'xten' ),
					'full_width'   => __( 'Full-Width', 'xten' ),
				),
			)
		)
	);
	$wp_customize->get_setting( 'content_width' )->transport = 'postMessage';

	// Default Post Image.
	$wp_customize->add_setting(
		'default_post_image',
		array(
			'default'           => '',
			'sanitize_callback' => 'absint',
			'transport'         => 'postMessage',
		)
	);

	// Sidebar Location.
	$wp_customize->add_setting(
		'sidebar_location',
		array(
			'default'           => 'sidebar_right',
			'transport'         => 'postMessage',
		)
	);

	$wp_customize->add_control(
		new WP_Customize_Control(
			$wp_customize,
			'sidebar_location',
			array(
				'priority'    => array_search( 'content_layout', $priorities ),
				'label'       => __( 'Sidebar Location', 'xten' ),
				'section'     => 'content_options',
				'settings'    => 'sidebar_location',
				'description' => __( 'Choses the default sidebar location on dynamic pages.', 'xten' ),
				'type'        => 'select',
				'choices'     => array(
					'sidebar_right'  => __( 'Right', 'xten' ),
					'sidebar_left'   => __( 'Left', 'xten' ),
					'sidebar_none'   => __( 'None', 'xten' ),
				),
			)
		)
	);
	$wp_customize->get_setting( 'sidebar_location' )->transport = 'postMessage';
	// /Content Layout Group

	// Content Colors Group
	// Seperator
	$wp_customize->add_setting( 'section_content_group_colors', array() );

	$wp_customize->add_control(
		new Prefix_Custom_Content(
			$wp_customize, 'section_content_group_colors', array(
				'section'    => 'content_options',
				'priority'   => array_search( 'content_colors', $priorities ),
				'content'    => __( '<h2 style="font-size: 1.6em;">Colors</h2> <hr style="border-color: rgb(140, 140, 140);">', 'xten' ),
			)
		)
	);
	// /Seperator

	// Body Color.
	$wp_customize->add_setting(
		'xten_body_color',
		array(
			'default'           => '#333333',
			'sanitize_callback' => 'sanitize_hex_color',
			'transport'         => 'postMessage',
		)
	);

	$wp_customize->add_control(
		new WP_Customize_Color_Control(
			$wp_customize,
			'xten_body_color',
			array(
				'label'       => __( 'Body Color', 'xten' ),
				'section'     => 'content_options',
				'settings'    => 'xten_body_color',
				'description' => 'AKA default text color.',
				'priority'    => array_search( 'content_colors', $priorities ),
			)
		)
	);
	$wp_customize->get_setting( 'xten_body_color' )->transport = 'postMessage';
	// /Body Color.

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
				'section'     => 'content_options',
				'settings'    => 'xten_link_color',
				'priority'    => array_search( 'content_colors', $priorities ),
			)
		)
	);
	$wp_customize->get_setting( 'xten_link_color' )->transport = 'postMessage';
	// /Link Color.
	// /Content Colors Group

	// Misc Group
	// Seperator
	$wp_customize->add_setting( 'section_content_group_misc', array() );

	$wp_customize->add_control(
		new Prefix_Custom_Content(
			$wp_customize, 'section_content_group_misc', array(
				'section'    => 'content_options',
				'priority'   => array_search( 'content_misc', $priorities ),
				'content'    => __( '<h2 style="font-size: 1.6em;">Misc</h2> <hr style="border-color: rgb(140, 140, 140);">', 'xten' ),
			)
		)
	);
	// /Seperator

	// Default Featured Image
	$wp_customize->add_control(
		new WP_Customize_Cropped_Image_Control(
			$wp_customize,
			'default_post_image',
			array(
				'priority'    => array_search( 'content_misc', $priorities ),
				'settings'    => 'default_post_image',
				'section'     => 'content_options',
				'label'       => __( 'Default Post Image', 'xten' ),
				'description' => __( 'Select the image to be used when no featured image is selected.', 'xten' ),
				'width'       => 426,
				'height'      => 240,
				'flex_width'  => false,
				'flex_height' => false,
			)
		)
	);
	// /Default Featured Image
	// /Misc Group

}
add_action( 'customize_register', 'xten_customize_content_register' );
