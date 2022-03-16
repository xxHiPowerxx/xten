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
	$privacy_policy_elements = null;
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

/**
 * Site Phone Number Shortcode.
 * Will Render Site Phone Number in Widget or Content.
 */
function get_site_phone_number_func( $atts = '' ) {
	$site_phone_number      = esc_attr( get_theme_mod('site_phone_number', '') );
	$site_phone_number_span = '<span class="site-phone-number">' . $site_phone_number . '</span>';
	if ( $atts !== '' ) :
		$return_result = '<a class="anchor-site-phone-number desktop" href="tel:' . $site_phone_number . '">' . $site_phone_number_span . '</a>';
	else :
		$return_result = $site_phone_number_span;
	endif;
	return $return_result;
}
add_shortcode( 'site_phone_number', 'get_site_phone_number_func' );
add_filter( 'widget_text', 'do_shortcode' );

/**
 * Post Title Shortcode
 */
function post_title_shortcode(){
	return get_the_title();
}
add_shortcode('post_title','post_title_shortcode');

/**
 * Social Media Icons List Shortcode
 * Renders ALL Social Media Icons Configured on "Site Settings Page"
 */
function social_media_icons_list_shortcode( $atts = '' ) {
	// When Shortcode is used $atts defaults to ''.
	// Ensure that this gets converted to an array.
	$atts = $atts === '' ? array() : $atts;

	// Get Component Function.
	return xten_render_component( 'social-media-icons-list' );
}
add_shortcode( 'social_media_icons_list', 'social_media_icons_list_shortcode' );

/**
 * Recent Posts shortcode.
 */
function recent_posts_function( $atts ) {
	// Set Post Type Default to post.
	$atts['post_type'] = $atts['post_type'] ? : 'post';

	if ( ! empty( $atts['post_parent'] ) && ! is_numeric( $atts['post_parent'] ) ) :
		$parent_post = get_page_by_title( $atts['post_parent'], 'OBJECT', $atts['post_type'] );
		$atts['post_parent'] = $parent_post ? $parent_post->ID : null;
	endif;
	foreach( $atts as $key=>$att ) :
		// TODO: figure out an identifier for Arrays instead of this crude method of finding the key.
		if ( $key === 'post__not_in' ) :
			// Create our array of values
			// First, sanitize the data and remove white spaces
			$no_whitespaces = preg_replace( '/\s*,\s*/', ',', filter_var( $att, FILTER_SANITIZE_STRING ) ); 
			$atts[$key] = explode( ',', $no_whitespaces );
		endif;
	endforeach;

	$posts = query_posts( $atts );

	ob_start();
	if ( have_posts() ) :
		?>
		<div class="archive-list display-flex theme-content component-blog-archive">
			<?php
			while ( have_posts() ):
				the_post();
				$post_type               = get_post_type();
				$template_part_post_type = get_post_type() == 'page' ? 'post' : $post_type;
				$args = array(
					'use_meta_description' => true,
					'exclude_date'          => true,
				);
				get_template_part( 'template-parts/content-archive', $template_part_post_type, $args );
			endwhile;
			?>
		</div>
		<?php
	endif;

	wp_reset_query();
	return ob_get_clean();
}
add_shortcode('recent-posts', 'recent_posts_function');

/**
 * Office Locations Shortcode
 * Renders Office Locations.
 */
function xten_button_shortcode( $atts = '', $content = null ) {
	$atts = shortcode_atts(
		array(
			'alt'   => true,
			'href'  => null,
			'target'=> null,
			'class' => '',
		),
		$atts
	);
	if ( ! $content ) :
		return;
	endif;
	$tag = $atts['href'] ? 'a' : 'button';
	$href_atts = 'href="' . esc_url( $atts['href'] ) . '"';
	$href_target = $atts['target'] ?
		' target="' . $atts['target'] . '"' :
		null;
	$tag_atts .= $atts['href'] ?
		$href_atts . $href_target :
		'type="button"';
	$btn_default_classes = 'btn btn-theme-style';
	$btn_classes = "$btn_default_classes $atts[class]";
	$tag_atts .= " class=\"$btn_classes\"";
	ob_start();
	?>
	<<?php echo $tag; ?> <?php echo $tag_atts; ?>>
		<?php echo wp_kses_post( $content ); ?>
	</<?php echo $tag; ?>>
	<?php
	return do_shortcode( ob_get_clean() );

}
add_shortcode( 'xten_button', 'xten_button_shortcode' );