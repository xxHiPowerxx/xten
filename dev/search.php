<?php
/**
 * The template for displaying search results pages
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/#search-result
 *
 * @package xten
 */

get_header(); ?>

<div class="sizeContent container container-ext main-container">
	<main id="primary" class="content-area site-main card-style">
		<div class="row">
			<div class="col-12 col-md-8 mx-auto search-wrapper">
				<?php
				wp_print_styles( array( 'xten-search-css' ) );
				if ( have_posts() ) :

					/* Display the appropriate header when required. */
					$allsearch = new WP_Query( "s=$s&showposts=-1" );
					$count     = $allsearch->post_count;
					/**
					 * Wrap Search Term in span with yellow background color.
					 *
					 * @param string $string the full string that has the search term inside.
					 * @param string $search_word the actual search term.
					 */
					function search_term( $string, $search_word ) {
						$wrap_before = '<span class="yellow bold">';
						$wrap_after  = '</span>';
						echo wp_kses_post( preg_replace( "/($search_word)/i", "$wrap_before$1$wrap_after", $string ) );
					}
					?>
					<h2 class="heading">Search</h2>
					<?php
					get_search_form();
					?>
					<h4 class="result-count"><?php echo esc_html( $count ); ?> results</h4>
					<?php

					/* Start the Loop */
					while ( have_posts() ) :
						the_post();

						/*
						* Include the component stylesheet for the content.
						* This call runs only once on index and archive pages.
						* At some point, override functionality should be built in similar to the template part below.
						*/
						wp_print_styles( array( 'xten-content-css' ) ); // Note: If this was already done it will be skipped.
						/**
						 * Run the loop for the search to output the results.
						 * If you want to overload this in a child theme then include a file
						 * called content-search.php and that will be used instead.
						 */
						get_template_part( 'template-parts/content', 'search' );

					endwhile;

					bootstrap_pagination();

				else :

					get_template_part( 'template-parts/content', 'none' );

				endif;
				?>
			</div>
		</div>
	</main><!-- #primary -->
</div> <!-- end sizeContent -->

<?php
get_footer();
