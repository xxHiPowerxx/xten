<?php
/**
 * XTen Site Footer Customizer
 *
 * @package xten
 */

/**
 * Add support for Site Footer Options in Customizer.
 *
 * @param WP_Customize_Manager $wp_customize Site Footer Customizer object.
 */
function xten_customize_site_footer_register( $wp_customize ) {
	$section_name = 'xten_footer_options';
	$font_selection = include get_template_directory() . '/inc/customizer/font-selection.php';
	/**
	 * Footer options.
	 */
	$wp_customize->add_section(
		$section_name,
		array(
			'title'       => __( 'Footer Options', 'xten' ),
			'priority'    => 130, // Before Additional CSS.
		)
	);

	$priorities = array(
		'footer_logo',
		'footer_layout',
		'footer_bg_image',
		'footer_colors',
		'site_info_colors',
	);

	// Footer Logo
	// TODO: Create function that renders this separator
	// should accept priority, and Content Arguments.
	// Separator.
	$wp_customize->add_setting( 'xten_footer_logo_group', array() );

	$wp_customize->add_control(
		new Prefix_Custom_Content(
			$wp_customize,
			'xten_footer_logo_group',
			array(
				'priority'   => array_search('footer_logo', $priorities),
				'section'    => $section_name,
				'content'    => __( '<h2 style="font-size: 1.6em;">Footer Logo</h2> <hr style="border-color: rgb(140, 140, 140);">', 'xten' ),
			)
		)
	);
	// /Separator.

	// Custom Logo (Upload).
	$wp_customize->add_setting(
		'footer_custom_logo',
		array(
			'capability'        => 'edit_theme_options',
			'default'           => null,
			'transport'         => 'postMessage',
		)
	);

	$wp_customize->add_control(
		new WP_Customize_Image_Control(
			$wp_customize,
			'footer_custom_logo',
			array(
				'priority'    => array_search('footer_logo', $priorities),
				'label'       => __( 'Footer Custom Logo', 'xten' ),
				'section'     => $section_name,
				'settings'    => 'footer_custom_logo',
				'description' => __( 'The <b>Footer Custom Logo</b> will replace the Site Logo, if set.', 'xten' ),
			)
		)
	);
	$wp_customize->get_setting( 'footer_custom_logo' )->transport = 'postMessage';
	// /Custom Logo (Upload).

	// Custom Logo SVG.
	$wp_customize->add_setting(
		'footer_custom_logo_svg',
		array(
			'default'           => null,
			'transport'         => 'postMessage',
		)
	);

	$wp_customize->add_control(
		new WP_Customize_Control(
			$wp_customize,
			'footer_custom_logo_svg',
			array(
				'priority'    => array_search('footer_logo', $priorities),
				'label'       => __( 'Footer Custom Logo SVG', 'xten' ),
				'section'     => $section_name,
				'settings'    => 'footer_custom_logo_svg',
				'description' => __( 'The <b>Footer Custom Logo SVG</b> will replace the <b>Footer Logo</b>, if set. Place the <code>SVG Code</code> in the Textarea Below.', 'xten' ),
				'type'        => 'textarea',
			)
		)
	);
	$wp_customize->get_setting( 'footer_custom_logo_svg' )->transport = 'postMessage';
	// /Custom Logo SVG.
	// /Footer Logo

	// Footer Layout
	// Separator.
	$wp_customize->add_setting( 'xten_footer_layout_group', array() );

	$wp_customize->add_control(
		new Prefix_Custom_Content(
			$wp_customize,
			'xten_footer_layout_group',
			array(
				'priority'   => array_search('footer_layout', $priorities),
				'section'    => $section_name,
				'content'    => __( '<h2 style="font-size: 1.6em;">Footer Layout</h2> <hr style="border-color: rgb(140, 140, 140);">', 'xten' ),
			)
		)
	);
	// /Separator.

	// Display Site Phone Number Next to Footer Logo.
	$wp_customize->add_setting(
		'xten_site_phone_number_with_logo_footer',
		array(
			'default'           => false,
			'transport'         => 'postMessage',
		)
	);

	$wp_customize->add_control(
		'xten_site_phone_number_with_logo_footer',
		array(
			'priority'    => array_search('footer_layout', $priorities),
			'type'        => 'checkbox',
			'label'       => __( 'Display Site Phone Number Next to Footer Logo?', 'xten' ),
			'section'     => $section_name,
			'settings'    => 'xten_site_phone_number_with_logo_footer',
		)
	);
	$wp_customize->get_setting( 'xten_site_phone_number_with_logo_footer' )->transport = 'postMessage';
	// /Display Site Phone Number Next to Logo.

	// Footer Orientation
	$wp_customize->add_setting(
		'xten_footer_orientation',
		array(
			'default'           => 'footer_logo_on_top',
			'transport'         => 'postMessage',
		)
	);

	$wp_customize->add_control(
		'xten_footer_orientation',
		array(
			'priority'    => array_search('footer_layout', $priorities),
			'label'       => __( 'Choose whether Site Logo sits above or next to Widgets in Footer', 'xten' ),
			'section'     => $section_name,
			'settings'    => 'xten_footer_orientation',
			'type'        => 'select',
			'choices'     => array(
				'footer_logo_on_top' => 'Logo On Top of Widgets',
				'footer_logo_beside' => 'Logo Next to Widgets',
			),
		)
	);
	$wp_customize->get_setting( 'xten_footer_orientation' )->transport = 'postMessage';
	// /Footer Orientation
	// /Footer Layout

	// Footer Background Image
	// Separator.
	$wp_customize->add_setting( 'xten_footer_bg_image_group', array() );

	$wp_customize->add_control(
		new Prefix_Custom_Content(
			$wp_customize,
			'xten_footer_bg_image_group',
			array(
				'priority'   => array_search('footer_bg_image', $priorities),
				'section'    => $section_name,
				'content'    => __( '<h2 style="font-size: 1.6em;">Footer Background Image</h2> <hr style="border-color: rgb(140, 140, 140);">', 'xten' ),
			)
		)
	);
	// /Separator.

	// Custom Logo (Upload).
	$wp_customize->add_setting(
		'footer_bg_image',
		array(
			'capability'        => 'edit_theme_options',
			'default'           => null,
			'transport'         => 'postMessage',
		)
	);

	$wp_customize->add_control(
		new WP_Customize_Image_Control(
			$wp_customize,
			'footer_bg_image',
			array(
				'priority'    => array_search('footer_bg_image', $priorities),
				'label'       => __( 'Footer Custom Logo', 'xten' ),
				'section'     => $section_name,
				'settings'    => 'footer_bg_image',
				'description' => __( 'The Background Image for the Footer appears behind the Footer Color', 'xten' ),
			)
		)
	);
	$wp_customize->get_setting( 'footer_bg_image' )->transport = 'postMessage';
	// /Custom Logo (Upload).
	// /Footer Background Image

	// Footer Colors
	// Separator.
	$wp_customize->add_setting( 'xten_footer_colors_group', array() );

	$wp_customize->add_control(
		new Prefix_Custom_Content(
			$wp_customize,
			'xten_footer_colors_group',
			array(
				'priority'   => array_search('footer_colors', $priorities),
				'section'    => $section_name,
				'content'    => __( '<h2 style="font-size: 1.6em;">Footer Colors</h2> <hr style="border-color: rgb(140, 140, 140);">', 'xten' ),
			)
		)
	);
	// /Separator.

	// Site Footer Colors
	// Separator.
	$wp_customize->add_setting( 'xten_site_footer_colors_group', array() );

	$wp_customize->add_control(
		new Prefix_Custom_Content(
			$wp_customize,
			'xten_site_footer_colors_group',
			array(
				'priority'   => array_search('footer_colors', $priorities),
				'section'    => $section_name,
				'content'    => __( '<h3 style="font-size: 1.25em;">Site Footer Colors</h3> <hr style="border-color: rgb(140, 140, 140);">', 'xten' ),
			)
		)
	);
	// /Separator.

	// Footer Background Color.
	$wp_customize->add_setting(
		'xten_footer_bg_color',
		array(
			'default'           => '#2e528a',
			'sanitize_callback' => 'sanitize_hex_color',
			'transport'         => 'postMessage',
		)
	);

	$wp_customize->add_control(
		new WP_Customize_Color_Control(
			$wp_customize,
			'xten_footer_bg_color',
			array(
				'priority'    => array_search('footer_colors', $priorities),
				'label'       => __( 'Footer Background Color', 'xten' ),
				'section'     => $section_name,
				'settings'    => 'xten_footer_bg_color',
				'description' => __( 'Set Footer Background Color', 'xten' ),
			)
		)
	);
	$wp_customize->get_setting( 'xten_footer_bg_color' )->transport = 'postMessage';
	// /Footer Background Color.

	// Footer Background Color Opacity
	$wp_customize->add_setting(
		'xten_footer_bg_color_opacity',
		array(
			'default'           => '100',
			'sanitize_callback' => 'wp_filter_nohtml_kses',
			'transport'         => 'postMessage',
		)
	);

	$wp_customize->add_control(
		new WP_Customize_Range_Control(
			$wp_customize,
			'xten_footer_bg_color_opacity',
			array(
				'priority'    => array_search('footer_colors', $priorities),
				'label'       => __( 'Footer Background Opacity', 'xten' ),
				'section'     => $section_name,
				'settings'    => 'xten_footer_bg_color_opacity',
				'description' => __( 'Set Opacity for Footer Background Color', 'xten' ),
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
	// /Footer Background Color Opacity

	// Footer Text Color.
	$wp_customize->add_setting(
		'xten_footer_color',
		array(
			'default'           => '#fff',
			'sanitize_callback' => 'sanitize_hex_color',
			'transport'         => 'postMessage',
		)
	);

	$wp_customize->add_control(
		new WP_Customize_Color_Control(
			$wp_customize,
			'xten_footer_color',
			array(
				'priority'    => array_search('footer_colors', $priorities),
				'label'       => __( 'Footer Text Color', 'xten' ),
				'section'     => $section_name,
				'settings'    => 'xten_footer_color',
				'description' => __( 'Set Footer Text Color', 'xten' ),
			)
		)
	);
	$wp_customize->get_setting( 'xten_footer_color' )->transport = 'postMessage';
	// /Footer Text Color.

	// Footer Link Color.
	$wp_customize->add_setting(
		'xten_footer_link_color',
		array(
			'default'           => '#fff',
			'sanitize_callback' => 'sanitize_hex_color',
			'transport'         => 'postMessage',
		)
	);

	$wp_customize->add_control(
		new WP_Customize_Color_Control(
			$wp_customize,
			'xten_footer_link_color',
			array(
				'priority'    => array_search('footer_colors', $priorities),
				'label'       => __( 'Footer Link Color', 'xten' ),
				'section'     => $section_name,
				'settings'    => 'xten_footer_link_color',
				'description' => __( 'Set Footer Link Color', 'xten' ),
			)
		)
	);
	$wp_customize->get_setting( 'xten_footer_link_color' )->transport = 'postMessage';
	// /Footer Link Color.
	// /Site Footer Colors

	// Site Info Colors
	// Separator.
	$wp_customize->add_setting( 'xten_site_info_colors_group', array() );

	$wp_customize->add_control(
		new Prefix_Custom_Content(
			$wp_customize,
			'xten_site_info_colors_group',
			array(
				'priority'   => array_search('site_info_colors', $priorities),
				'section'    => $section_name,
				'content'    => __( '<h3 style="font-size: 1.25em;">Site Info Colors</h3> <hr style="border-color: rgb(140, 140, 140);">', 'xten' ),
			)
		)
	);
	// /Separator.

	// Site Info Background Color.
	$wp_customize->add_setting(
		'xten_site_info_bg_color',
		array(
			'default'           => '#2e528a',
			'sanitize_callback' => 'sanitize_hex_color',
			'transport'         => 'postMessage',
		)
	);

	$wp_customize->add_control(
		new WP_Customize_Color_Control(
			$wp_customize,
			'xten_site_info_bg_color',
			array(
				'priority'    => array_search('site_info_colors', $priorities),
				'label'       => __( 'Site Info Background Color', 'xten' ),
				'section'     => $section_name,
				'settings'    => 'xten_site_info_bg_color',
				'description' => __( 'Set Site Info Background Color', 'xten' ),
			)
		)
	);
	$wp_customize->get_setting( 'xten_site_info_bg_color' )->transport = 'postMessage';
	// /Site Info Background Color.

	// Site Info Background Color Opacity
	$wp_customize->add_setting(
		'xten_site_info_bg_color_opacity',
		array(
			'default'           => '100',
			'sanitize_callback' => 'wp_filter_nohtml_kses',
			'transport'         => 'postMessage',
		)
	);

	$wp_customize->add_control(
		new WP_Customize_Range_Control(
			$wp_customize,
			'xten_site_info_bg_color_opacity',
			array(
				'priority'    => array_search('site_info_colors', $priorities),
				'label'       => __( 'Site Info Background Opacity', 'xten' ),
				'section'     => $section_name,
				'settings'    => 'xten_site_info_bg_color_opacity',
				'description' => __( 'Set Opacity for Site Info Background Color', 'xten' ),
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
	// /Site Info Background Color Opacity

	// Site Info Text Color.
	$wp_customize->add_setting(
		'xten_site_info_color',
		array(
			'default'           => '#fff',
			'sanitize_callback' => 'sanitize_hex_color',
			'transport'         => 'postMessage',
		)
	);

	$wp_customize->add_control(
		new WP_Customize_Color_Control(
			$wp_customize,
			'xten_site_info_color',
			array(
				'priority'    => array_search('site_info_colors', $priorities),
				'label'       => __( 'Site Info Text Color', 'xten' ),
				'section'     => $section_name,
				'settings'    => 'xten_site_info_color',
				'description' => __( 'Set Site Info Text Color', 'xten' ),
			)
		)
	);
	$wp_customize->get_setting( 'xten_site_info_color' )->transport = 'postMessage';
	// /Site Info Text Color.

	// Site Info Link Color.
	$wp_customize->add_setting(
		'xten_site_info_link_color',
		array(
			'default'           => '#fff',
			'sanitize_callback' => 'sanitize_hex_color',
			'transport'         => 'postMessage',
		)
	);

	$wp_customize->add_control(
		new WP_Customize_Color_Control(
			$wp_customize,
			'xten_site_info_link_color',
			array(
				'priority'    => array_search('site_info_colors', $priorities),
				'label'       => __( 'Site Info Link Color', 'xten' ),
				'section'     => $section_name,
				'settings'    => 'xten_site_info_link_color',
				'description' => __( 'Set Site Info Link Color', 'xten' ),
			)
		)
	);
	$wp_customize->get_setting( 'xten_site_info_link_color' )->transport = 'postMessage';
	// /Site Info Link Color.
	// /Site Info Colors

	// /Footer Colors
}
add_action( 'customize_register', 'xten_customize_site_footer_register' );