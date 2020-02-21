<?php
/**
 * Template Name: Fixed Width
 *
 * @package     XTen
 */

get_header();
?>
<div class="sizeContent container container-ext main-container">
	<div class="content-area card-style" id="primary">
		<?php

			/*
			* Include the component stylesheet for the content.
			* This call runs only once on index and archives pages.
			* At some point, override functionality should be built in similar to the template part below.
			*/
			wp_print_styles( array( 'xten-content-css' ) ); // Note: If this was already done it will be skipped.

		while ( have_posts() ) :
			the_post();
			get_template_part( 'template-parts/content-blank', get_post_type() );
		endwhile; // End of the loop.
		?>
	</div><!-- #primary -->
	</div>
<?php
get_footer();