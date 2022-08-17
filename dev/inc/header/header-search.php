<?php
/**
 * Header search template
 *
 * @package xten
 * @version 1.0
 */

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
?>

<div id="search-outer">
	<div class="container container-header-search">
<?php /* save for filtering post-types
		// Limit post type
		// $post_types_list = array('post','product','portfolio');

		// if( isset($xten_options['header-search-limit']) && in_array($xten_options['header-search-limit'],$post_types_list) ) {
		// 	echo '<input type="hidden" name="post_type" value="'.esc_attr($xten_options['header-search-limit']).'">';
		// }
*/ ?>
		<?php get_search_form(); ?>
	</div><!-- /.container-header-search -->
</div><!--/#search-outer-->
