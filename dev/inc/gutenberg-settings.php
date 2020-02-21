<?php
/**
 * Gutenberg settings.
 *
 * @package xten
 */

/**
 * Add support for wide aligments.
 *
 * @link https://wordpress.org/gutenberg/handbook/extensibility/theme-support/
 */
add_theme_support( 'align-wide' );
add_theme_support( 'disable-custom-colors' );

/**
 * Add support for block color palettes.
 *
 * @link https://wordpress.org/gutenberg/handbook/extensibility/theme-support/
 */

 //If you want to over-ride colors in child theme, copy the colors.php file into the root dir of the child theme, and update accordingly.
 if ( is_file( get_stylesheet_directory() . '/colors.php' ) ) {
	$theme_colors = include get_stylesheet_directory() . '/colors.php';
 } else {
	$theme_colors = include get_template_directory() . '/inc/colors.php';
 }

// Add neutral colors to Gutenberg
$neutral_colors = include get_template_directory() . '/inc/neutral-colors.php';

$gutenberg_colors = array();
foreach( $neutral_colors as $color ) {
	array_push(
		$gutenberg_colors,
		array(
			'name'  => __( $color['name'], 'xten' ),
			'slug'  => $color['slug'],
			'color' => $color['color'],
		)
	);
}

add_theme_support( 'editor-color-palette',  $gutenberg_colors );


// Create Theme Color CSS
$css = '';
foreach( $theme_colors as $color ) {
	$class_name = $color['slug'];
	$color_value = $color['color'];
	$css .= ".has-{$class_name}-color{color: {$color_value}}";
	$css .= "a.has-{$class_name}-color,";
	$css .= "a.has-{$class_name}-color:hover,";
	$css .= "a.has-{$class_name}-color:active,";
	$css .= "a.has-{$class_name}-color:focus{color: {$color_value}}";
	$css .= ".has-{$class_name}-background-color{background-color: {$color_value}}";
	$css .= ".has-{$class_name}-border-color{border-color: {$color_value}}";
	$css .= ".has-{$class_name}-border-color.xten-btn-outline{background-color: rgba(255,255,255,0)}";
	$css .= ".has-{$class_name}-border-color.xten-btn-outline:hover,";
	$css .= ".has-{$class_name}-border-color.xten-btn-outline:active,";
	$css .= ".has-{$class_name}-border-color.xten-btn-outline:focus{background-color: {$color_value}}";
}

function xten_colors_styles() {
	global $css;
	wp_register_style( 'xten-colors', false );
	wp_enqueue_style( 'xten-colors' );
	wp_add_inline_style( 'xten-colors', $css );
}

add_action( 'wp_enqueue_scripts', 'xten_colors_styles' );
add_action( 'enqueue_block_editor_assets', 'xten_colors_styles' );