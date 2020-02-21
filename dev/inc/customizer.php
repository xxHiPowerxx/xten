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
	$wp_customize->remove_section( 'colors' );
	$wp_customize->remove_section( 'header_image' );
	$wp_customize->remove_section( 'background_image' );
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
 * Standard Header Options.
 */
require get_template_directory() . '/inc/customizer/standard-header-options.php';

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

