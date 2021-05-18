<?php
/**
 * The template for displaying the footer
 *
 * Contains the closing of the #content div and all content after.
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package xten
 */

// Get Post Custom CSS if it exists.
xten_post_custom_css();
?>
						</div> <!-- /.content-wrapper -->
					</div> <!-- /#page-wrapper -->

					<?php
					$site_name         = esc_attr( get_bloginfo() );
					$site_info_content = wp_kses_post( get_field_without_wpautop( 'site_info_content', 'option' ) );
					$site_info_default = do_shortcode( wp_kses_post( '[site-info-default]' ) );
					$site_info_content = ( ! $site_info_content ) ? $site_info_default : $site_info_content;

					// Site Footer   //
					?>
					<footer id="colophon" class="site-footer">
						<div class="container container-ext footer-container">
							<div class="footer-content-wrapper">
							<div class="site-logo-wrapper">
									<?php
									$child_logo_type   = ' logo-type-' . str_replace( '_', '-', $GLOBALS['xten-logo-type'] );
									$logo_link_classes = 'custom-logo-link' . $child_logo_type;
									$logo_link_attrs   = xten_stringify_attrs( array(
										'class'    => $logo_link_classes,
										'href'     => esc_url( home_url( '/' ) ),
										'rel'      => 'home',
										'itemprop' => 'url',
										'title'    => $site_name,
									) );
									?>
									<a <?php echo $logo_link_attrs; ?>>
										<span class="hide-me">Home Link</span>
										<div class="ctnr-custom-logo">
											<?php echo $GLOBALS['xten-site-logo']; ?>
										</div>
									</a>
								</div>
								<?php
								if (
									is_active_sidebar( 'footer-1' ) ||
									is_active_sidebar( 'footer-2' ) ||
									is_active_sidebar( 'footer-3' ) ||
									is_active_sidebar( 'footer-4' )
								) :
									?>
									<div class="footer-wrapper">
										<?php
										if ( is_active_sidebar( 'footer-1' ) ) :
											?>
											<div class="footer-1-wrapper">
												<?php dynamic_sidebar( 'footer-1' ); ?>
											</div>
											<?php
										endif;
										if ( is_active_sidebar( 'footer-2' ) ) :
											?>
											<div class="footer-2-wrapper">
												<?php dynamic_sidebar( 'footer-2' ); ?>
											</div>
											<?php
										endif;
										if ( is_active_sidebar( 'footer-3' ) ) :
											?>
											<div class="footer-3-wrapper">
												<?php dynamic_sidebar( 'footer-3' ); ?>
											</div>
											<?php
										endif;
										if ( is_active_sidebar( 'footer-4' ) ) :
											?>
											<div class="footer-4-wrapper">
												<?php dynamic_sidebar( 'footer-4' ); ?>
											</div>
											<?php
										endif;
										?>
									</div>
								<?php endif; // endif ( is_active_sidebar( 'footer-1' ) || ) ?>
							</div>
						</div>
						<div class="site-info-footer-wrapper">
							<div class="container">
								<div class="site-info">
									<?php echo $site_info_content; ?>
								</div><!-- .site-info -->
							</div>
						</div>
					</footer><!-- #colophon -->

				<div class="close-layer-search"></div>
			</div><!-- content wrapper -->
		</div><!-- page wrapper -->
		<div class="close-layer"></div>
	</div><!-- #page -->

	<?php wp_footer(); ?>

	</body>
</html>
