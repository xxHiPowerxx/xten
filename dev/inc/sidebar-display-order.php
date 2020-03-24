<?php
/**
 * Updates sidebar order accordiong to customizer options.
 *
 * @package xten
 */

$sidebar_location = get_theme_mod( 'sidebar_location', 'sidebar_right' );
switch ( $sidebar_location ) {
	case 'sidebar_left':
		?>
			<div class="col-xl-4 order-xl-0 widget-area" id="left-sidebar" role="complementary">
				<?php get_sidebar(); ?>
			</div> <!-- end column -->
		<?php
		break;
	case 'sidebar_right':
		?>
			<div class="col-xl-4 order-xl-2 widget-area" id="right-sidebar" role="complementary">
				<?php get_sidebar(); ?>
			</div> <!-- end column -->
		<?php
		break;
	case 'sidebar_none':
			// No sidebar.
		break;
}
