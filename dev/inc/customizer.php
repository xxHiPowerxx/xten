<?php
/**
 * XTen Theme Customizer
 *
 * @package xten
 */

/**
 * Add postMessage support for site title and description for the Theme Customizer.
 *
 * @param WP_Customize_Manager $wp_customize Theme Customizer object.
 */
function xten_customize_register( $wp_customize ) {
	$wp_customize->get_setting( 'blogname' )->transport         = 'postMessage';
	$wp_customize->get_setting( 'blogdescription' )->transport  = 'postMessage';
	$wp_customize->get_setting( 'header_textcolor' )->transport = 'postMessage';

	if ( isset( $wp_customize->selective_refresh ) ) {
		$wp_customize->selective_refresh->add_partial(
			'blogname',
			array(
				'selector'        => '.site-title a',
				'render_callback' => 'xten_customize_partial_blogname',
			)
		);
		$wp_customize->selective_refresh->add_partial(
			'blogdescription',
			array(
				'selector'        => '.site-description',
				'render_callback' => 'xten_customize_partial_blogdescription',
			)
		);
	}

	/* Remove Sections */
	// $wp_customize->remove_section( 'colors' );
	$wp_customize->remove_section( 'header_image' );
	$wp_customize->remove_section( 'background_image' );

	// Custom Logo SVG.
	$wp_customize->add_setting(
		'custom_logo_svg',
		array(
			'default'           => null,
			'transport'         => 'postMessage',
		)
	);

	$wp_customize->add_control(
		new WP_Customize_Control(
			$wp_customize,
			'custom_logo_svg',
			array(
				'priority'    => 8,
				'label'       => __( 'Custom Logo SVG', 'xten' ),
				'section'     => 'title_tagline',
				'settings'    => 'custom_logo_svg',
				'description' => __( 'The <b>Custom Logo SVG</b> will be shown in all places throughout the site where the <b>Logo</b> would normally be found, including the Header and the Footer. Place the <code>SVG Code</code> in the Textarea Below.', 'xten' ),
				'type'        => 'textarea',
			)
		)
	);
	$wp_customize->get_setting( 'custom_logo_svg' )->transport = 'postMessage';
	// /Custom Logo SVG.

	// Site Phone Number.
	$wp_customize->add_setting(
		'site_phone_number',
		array(
			'default'           => null,
			'transport'         => 'postMessage',
		)
	);

	$wp_customize->add_control(
		new WP_Customize_Control(
			$wp_customize,
			'site_phone_number',
			array(
				'priority'    => 12,
				'label'       => __( 'Site Phone Number', 'xten' ),
				'section'     => 'title_tagline',
				'settings'    => 'site_phone_number',
				'description' => __( 'The Site Phone Number Will Be displayed in multple areas', 'xten' ),
				'type'        => 'text',
			)
		)
	);
	$wp_customize->get_setting( 'site_phone_number' )->transport = 'postMessage';
	// /Site Phone Number.
}
add_action( 'customize_register', 'xten_customize_register' );

/**
 * New Fields.
 */
require get_template_directory() . '/inc/customizer/new-fields.php';

/**
 * Theme Options.
 */
require get_template_directory() . '/inc/customizer/theme-options.php';

/**
 * Header Options.
 */
require get_template_directory() . '/inc/customizer/header-options.php';

/**
 * Content Options.
 */
require get_template_directory() . '/inc/customizer/content-options.php';

/**
 * Render the site title for the selective refresh partial.
 *
 * @return void
 */
function xten_customize_partial_blogname() {
	bloginfo( 'name' );
}

/**
 * Render the site tagline for the selective refresh partial.
 *
 * @return void
 */
function xten_customize_partial_blogdescription() {
	bloginfo( 'description' );
}

/**
 * Binds JS handlers to make Theme Customizer preview reload changes asynchronously.
 */
function xten_customize_preview_js() {
	$xten_customizer_path = '/js/customizer.js';
	wp_enqueue_script( 'xten-customizer', get_theme_file_uri( $xten_customizer_path ), array( 'customize-preview' ), filemtime( get_template_directory() . $xten_customizer_path ), true );

	// Send theme Directory to customizer.js.
	wp_localize_script(
		'xten-customizer',
		'wpScriptVars',
		array(
			'themeDirectory' => get_template_directory_uri(),
		)
	);
}
add_action( 'customize_preview_init', 'xten_customize_preview_js' );

