<?php
/**
 * The template for displaying archive pages
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package xten
 */

get_header(); ?>

<?php wp_print_styles( array( 'xten-archive-css' ) ); ?>
	<?php
	$sidebar_location = get_theme_mod( 'sidebar_location', 'sidebar_right' );
	$column           = '';
	if ( 'none' !== $sidebar_location ) {
		$column = '-xl-8';
	};
	?>
	<div class="sizeContent container container-ext main-container">
		<div class="row">
			<div class="col<?php echo esc_attr( $column ); ?> order-xl-1" id="primary">
				<main id="main" class="site-main archive-page">

					<?php
					/*
					* Include the component stylesheet for the content.
					* This call runs only once on index and archive pages.
					* At some point, override functionality should be built in similar to the template part below.
					*/
					wp_print_styles( array( 'xten-content-css' ) ); // Note: If this was already done it will be skipped.

					global $wp_query;
					$is_category = $wp_query->is_category;
					$is_custom_post_type = $wp_query->is_post_type_archive;
					// If page is a Category Archive OR is Investigation Archive, get the thumbnail.
					if ( $is_category || $is_custom_post_type ) :
						if ( $is_category ) :
							$archive_thumbnail = get_field( 'category_thumbnail', get_queried_object() );
						else :
							// For this to work programatically, the thumbnail field must be named 'post-type'_thumbnail.
							// EG: $post_type === 'products' Field Name = 'products_thumbnail';
							$post_type = $wp_query->query['post_type'];
							$thumbnail_handle = $post_type . '_thumbnail';

							$archive_thumbnail = get_field( $thumbnail_handle, 'option' );
						endif;
						if ( $archive_thumbnail ) :
							$thumbnail_id = $archive_thumbnail['ID']
							?>
							<div class="featured-image card-style main-featured-image">
								<?php
								
								$thumbnail_img = wp_get_attachment_image( 
									$thumbnail_id,
									array(930, null),
									false,
									array(
										'title' => single_cat_title( '', false )
									)
								);
								echo $thumbnail_img;
								?>
							</div>
							<?php
						endif; // endif ( $archive_thumbnail ) :
					endif;// endif ( $is_category || $is_investigations ) :
					/* Display the appropriate header when required. */
					xten_index_header();

					/**
					 * Check if is page Category, and if so, get archive-category.php
					 */
					if ( $is_category ) :

						get_template_part( 'template-parts/archive-category' );

					elseif ( $is_custom_post_type ) :

						get_template_part( 'template-parts/archive-custom-post-type' );

					else : // else if ( ! $is_category || ! $is_custom_post_type ) :

						if ( have_posts() ) :
							?>

							<div class="archive-container d-flex flex-row flex-wrap align-items-stretch posts-list">
								<?php
								/* Start the Loop */
								while ( have_posts() ) :
									?>
									<div class="article-container col-md-6">
										<?php
										the_post();

										/*
										* Include the Post-Type-specific template for the content.
										* If you want to override this in a child theme, then include a file
										* called content-___.php (where ___ is the Post Type name) and that will be used instead.
										*/
										get_template_part( 'template-parts/content', 'archive-post' );
										?>
									</div><!-- .article-container -->
									<?php
								endwhile;
								?>
							</div>
							<?php

							the_posts_navigation(
								array(
									'prev_text'          => __( '<i class="fas fa-arrow-left"></i> Older posts', 'xten' ),
									'next_text'          => __( 'Newer posts <i class="fas fa-arrow-right"></i>', 'xten' ),
									'screen_reader_text' => __( 'Posts navigation', 'xten' ),
								)
							);

						else : // else if ( ! have_posts() ) :

							get_template_part( 'template-parts/content', 'none' );

						endif; // endif ( have_posts() ) :

					endif; // endif ( $is_category ) :
					?>

				</main><!-- #main -->
			</div> <!-- end column -->
			<?php
			/**
			 * Customizer Ordered sidebar.
			 */
			require get_template_directory() . '/inc/sidebar-display-order.php';
			?>
		</div> <!-- row -->
	</div><!-- end sizeContent -->
<?php

get_footer();
