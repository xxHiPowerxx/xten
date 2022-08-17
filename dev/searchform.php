<?php
/**
 * Template for displaying search forms in Twenty Eleven
 *
 * @package WordPress
 * @subpackage XTen
 */

$css_path = '/css/search.css';
wp_enqueue_style(
	'xten-search',
	get_template_directory_uri() . $css_path,
	array( 'xten-base-style', ),
	filemtime( get_template_directory() . $css_path )
);
$placeholder_text = esc_attr__( 'Search', 'xten' );
$helper_text      = xten_kses_post( 'Hit <b>Enter</b> to Search or <b>ESC</b> to close', 'xten' );
?>
<form method="get" class="search-form" action="<?php echo esc_url( home_url( '/' ) ); ?>">
	<div class="input-group">
		<input type="text" class="form-control field search-field" name="s" title="Search" aria-label="Search" placeholder="<?php echo esc_attr($placeholder_text); ?>" onfocus="this.placeholder = ''" onblur="this.placeholder = '<?php echo esc_attr($placeholder_text); ?>'" value="<?php the_search_query(); ?>">
		<div class="input-group-append">
			<button type="submit" role="button" aria-label="Search Button" class="btn submit btn-theme-style btn-submit-search" name="submit-search">See All Results</button>
		</div>
	</div>
	<div class="search-form-helper-text"><?php echo $helper_text; ?></div>
</form>
