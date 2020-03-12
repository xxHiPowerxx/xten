<?php
/**
 * Collection of Shortcodes.
 *
 * @package xten
 */

/**
 * Year shortcode.
 */
function get_year_func() {
	$year = date( 'Y' );
	return $year;
}
add_shortcode( 'year', 'get_year_func' );

/**
 * Site-Info Shortcode
 * 
 * This allows site-info to be rendered through shortcode, thus allowing it to be rendered in ACF Default Value.
 * 
 */
function site_info_default_func() {
	$site_url                = esc_url( home_url( '/' ) );
	$site_name               = esc_attr( get_bloginfo() );
	$site_name_anchor_tag    = '<a href="' . $site_url . '" class="site-name-url">' . $site_name . '</a>';
	$policy_page_id          = (int) get_option( 'wp_page_for_privacy_policy' );
	if ( ! empty( $policy_page_id ) && get_post_status( $policy_page_id ) === 'publish' ) :
		$privacy_policy_permalink = (string) get_permalink( $policy_page_id );
		$privacy_policy_elements  = ' | <a href="' . $privacy_policy_permalink . '">Privacy Policy</a>';
	endif;

	$site_info_default = '© ' . get_year_func() . ' ' . $site_name_anchor_tag . $privacy_policy_elements;

	return $site_info_default;
}
add_shortcode( 'site-info-default', 'site_info_default_func' );

/**
 * Facebook shortcode.
 *
 * @param array $atts attributes from shortcode.
 */
function fontawesome_link_shortcode_func( $atts ) {
	$a = shortcode_atts( array(
		'icon'  => 'fas fa-home',
		'url'   => 'http://xxhipowerxx.github.io/xten',
		'color' => '#696B6E',
		'size'  => '2em',
	), $atts );

	$content = '<a class="socia-icon ' . esc_attr( $a['icon'] ) . '" href="' . esc_url( $a['url'] ) . '" style="color:' . esc_attr( $a['color'] ) . ';font-size:' . esc_attr( $a['size'] ) . '"></a>';

	return $content;
}
add_shortcode( 'fontawesome_link', 'fontawesome_link_shortcode_func' );

/**
 * Text Modification shortcode.
 *
 * @param array $atts attributes from shortcode.
 */
function text_modification_shortcode_func( $atts, $content = null ) {
	$a = shortcode_atts( array(
		'size'  => '',
		'color'   => '',
	), $atts );

	$styles = '';
	$class  = '';

	if ( $a['size'] ) :
		$styles = 'font-size:' . esc_attr( preg_replace( "/&#?[a-z0-9]+;/i",'', $a['size'] ) ) . ';';
	endif;

	if ( $a['color'] ) :
		$class = 'has-' . esc_attr( preg_replace( "/&#?[a-z0-9]+;/i",'', $a['color'] ) ) . '-color';
	endif;


	return '<span class="' . $class . '" style="' . $styles . '">' . $content . '</span>';
}
add_shortcode( 'text_mod', 'text_modification_shortcode_func' );
