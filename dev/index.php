<?php
/**
 * The main template file
 *
 * This is the most generic template file in a WordPress theme
 * and one of the two required files for a theme (the other being style.css).
 * It is used to display a page when nothing more specific matches a query.
 * E.g., it puts together the home page when no home.php file exists.
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package xten
 */

get_header(); ?>

	<?php
	$sidebar_location = get_theme_mod( 'sidebar_location', 'sidebar_right' );
	$column           = '';
	if ( 'sidebar_none' !== $sidebar_location ) {
		$column = '-xl-8';
	};
	?>
	<div class="sizeContent container container-ext main-container">
		<div class="row">
			<div class="col<?php echo esc_attr( $column ); ?> order-xl-1 content-area card-style" id="primary">
				<main id="main" class="site-main">

				<?php

				if ( have_posts() ) :

					/**
					 * Include the component stylesheet for the content.
					 * This call runs only once on index and archive pages.
					 * At some point, override functionality should be built in similar to the template part below.
					 */
					wp_print_styles( array( 'xten-content-css' ) ); // Note: If this was already done it will be skipped.

					/* Display the appropriate header when required. */
					xten_index_header();

					/* Start the Loop. */
					while ( have_posts() ) :
						the_post();

						/*
						* Include the Post-Type-specific template for the content.
						* If you want to override this in a child theme, then include a file
						* called content-___.php (where ___ is the Post Type name) and that will be used instead.
						*/
						get_template_part( 'template-parts/content', get_post_type() );

					endwhile;

					if ( ! is_singular() ) :
						the_posts_navigation();
					endif;

				else :

					get_template_part( 'template-parts/content', 'none' );

				endif;
				?>

				</main><!-- #primary -->
			</div> <!-- end column -->
			<?php
			/**
		 * Customizer Ordered sidebar.
		 */
		require get_template_directory() . '/inc/sidebar-display-order.php';
		?>

		</div> <!-- end row -->
	</div> <!-- end sizeContent -->
<?php

get_footer();
