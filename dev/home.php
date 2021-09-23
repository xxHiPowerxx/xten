<?php
/**
 * The template for displaying the Blog Overview page
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package xten
 */

get_header();

wp_print_styles( array( 'xten-archive-css' ) );

$sidebar_location = get_theme_mod( 'sidebar_location', 'sidebar_right' );
$column            = '';
$article_col_class = 'col-xxl-4 col-md-6';
if ( 'sidebar_none' !== $sidebar_location ) {
	$column            = '-xl-8';
	$article_col_class = 'col-md-6';
};
?>
<div class="sizeContent container container-ext main-container">
	<div class="row">
		<div class="col<?php echo esc_attr( $column ); ?> order-xl-1 content-area" id="primary">
			<main id="main" class="site-main archive-page">

				<?php
				$page_for_posts       = get_option( 'page_for_posts' );
				$before_posts_archive = xten_kses_post( get_field( 'before_posts_archive', $page_for_posts, false ) );
				$after_posts_archive  = xten_kses_post( get_field( 'after_posts_archive', $page_for_posts, false ) );
				$separator            = ' <!-- separator --> ';
				$full_string          = $before_posts_archive . $separator . $after_posts_archive;
				$full_string          = apply_filters( 'the_content', $full_string );
				$full_string_array    = explode( $separator, $full_string );
				$before_posts_archive = reset( $full_string_array );
				$after_posts_archive  = end( $full_string_array );

				if ( $before_posts_archive ) :
					?>
					<div class="before-post-archive">
						<?php echo $before_posts_archive; ?>
					</div>
					<?php
				endif;

				if ( have_posts() ) :
					/*
					* Include the component stylesheet for the content.
					* This call runs only once on index and archive pages.
					* At some point, override functionality should be built in similar to the template part below.
					*/
					wp_print_styles( array( 'xten-content-css' ) ); // Note: If this was already done it will be skipped.

					/* Display the appropriate header when required. */
					xten_index_header();

					?>

					<div class="archive-container d-flex flex-row flex-wrap align-items-stretch">
						<?php

						/* Start the Loop */
						while ( have_posts() ) :
							?>
							<div class="article-container <?php echo esc_attr( $article_col_class ); ?>">
								<?php
								the_post();

								/*
								* Include the Post-Type-specific template for the content.
								* If you want to override this in a child theme, then include a file
								* called content-___.php (where ___ is the Post Type name) and that will be used instead.
								*/
								get_template_part( 'template-parts/content-archive', get_post_type() );
								?>
							</div><!-- .article-container -->
							<?php
						endwhile;
						?>
					</div><!-- /.archive-container -->
					<?php

					the_posts_navigation(
						array(
							'prev_text'          => __( '<i class="fas fa-arrow-left"></i> Older posts', 'xten' ),
							'next_text'          => __( 'Newer posts <i class="fas fa-arrow-right"></i>', 'xten' ),
							'screen_reader_text' => __( 'Posts navigation', 'xten' ),
						)
					);

					if ( $after_posts_archive ) :
						$after_posts_archive = apply_filters( 'the_content', $after_posts_archive );
						?>
						<div class="after-post-archive">
							<?php echo $after_posts_archive; ?>
						</div>
						<?php
					endif;

				else :

					get_template_part( 'template-parts/content', 'none' );

				endif;

				?>

			</main><!-- #main-->
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