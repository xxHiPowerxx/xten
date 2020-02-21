<?php
/**
 * The template for displaying 404 pages (not found)
 *
 * @link https://codex.wordpress.org/Creating_an_Error_404_Page
 *
 * @package xten
 */

get_header(); ?>

<?php wp_print_styles( array( 'xten-404-css' ) ); ?>
	<div class="sizeContent page-full-width main-container">
		<main class="content-area" id="primary">

			<section class="error-404 not-found">
				<header class="page-header">
					<h1 class="page-title"><?php esc_html_e( 'The page you&rsquo;re looking for can&rsquo;t be found.', 'xten' ); ?></h1>
				</header><!-- .page-header -->

				<div class="page-content">
					<p class="message"><?php esc_html_e( 'It looks like nothing was found at this location. The URL may be misspelled, or the page may no longer be available.', 'xten' ); ?></p>
					<div class="row">
						<div class="col-lg-8 offset-lg-2">
							<div class="search">
								<?php
									get_search_form();
								?>
							</div>

							<!-- widget areas classes -->
							<div class="row">

								<div class="widget widget_404-left col-md-6">
									<?php dynamic_sidebar( 'error-404-left' ); ?>
								</div><!-- .widget- Left -->

								<div class="widget widget_404-right col-md-6">
									<?php dynamic_sidebar( 'error-404-right' ); ?>
								</div><!-- .widget- Right -->

							</div>
						</div>
					</div>

				</div><!-- .page-content -->
			</section><!-- .error-404 -->
		</main><!-- #primary -->
	</div><!-- sizeContent -->
<?php
get_footer();
