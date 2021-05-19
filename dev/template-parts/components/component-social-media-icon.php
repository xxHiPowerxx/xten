<?php
/**
 * This Component Renders ONE Social Media Icon w/ Link.
 * @package xten
 */
function component_social_media_icon( $account ) {

	// Enqueue Stylesheet.
	$handle             = 'social-media-icon';
	$component_handle   = 'component-' . $handle;
	$style_handle       = $component_handle . '-css';
	$component_css_path = '/css/' . $component_handle . '.css';
	wp_register_style(
		$style_handle,
		get_theme_file_uri( $component_css_path ),
		array(),
		filemtime( get_template_directory() . $component_css_path ),
		'all'
	);
	wp_enqueue_style( $style_handle );

	$styles = '';

	$component_id    = xten_register_component_id( $handle );
	$account_name    = esc_attr( $account['account_name'] );
	$account_url     = esc_url( $account['account_url'] );
	$href            = $account_url ?
		'href="' . $account_url . '" target="_blank"' :
		null;
	$icon            = esc_attr( $account['icon'] );
	$icon_class      = $icon ?
		' fa-' . $icon :
		null;
	$title_attribute = esc_attr( $account['title_attribute'] );
	$title_attr      = $title_attribute ?
		' title="' . $title_attribute . '"' :
		null;
	ob_start();
	?>
	<a id="<?php echo esc_attr( $component_id ); ?>" class="component-<?php echo $handle; ?> fab<?php echo $icon_class; ?>" <?php echo $href; ?><?php echo $title_attr ?>></a>
	<?php
	$html = ob_get_clean();

	return $html;

}
