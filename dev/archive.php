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
					$is_category = is_category();

					// If page is a Category Archive, get the thumbnail.
					if ( $is_category ) :
						$category_thumbnail = get_field( 'category_thumbnail', get_queried_object() );
						// var_dump($category_thumbnail);
						if ( $category_thumbnail ) :
							$thumbnail_id = $category_thumbnail['ID']
							?>
							<div class="featured-image">
								<?php
								
								$thumbnail_img = wp_get_attachment_image( 
									$thumbnail_id,
									array(957, null),
									false,
									array(
										'title' => single_cat_title( '', false )
									)
								);
								echo $thumbnail_img;
								?>
							</div>
							<?php
						endif; // endif ( $category_thumbnail ) :
					endif;// endif ( $is_category ) :
					/* Display the appropriate header when required. */
					xten_index_header();

					/**
					 * Check if is page Category, and if so, get archive-category.php
					 */
					if ( $is_category ) :

						require get_template_directory() . '/archive-category.php';

					else : // else if ( ! $is_category ) :

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
