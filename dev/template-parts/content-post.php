<?php
/**
 * Template part for displaying posts
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package xten
 */

?>

<article id="post-<?php the_ID(); ?>" <?php post_class( 'content-area card-style' ); ?>>
	<header class="entry-header">
		<?php

		if ( 'post' === get_post_type() ) :
			?>
			<div class="entry-meta xten-highlight-font">
				<?php
				if ( is_singular() ) :
					the_title( '<h1 class="entry-title">', '</h1>' );
				else :
					the_title( '<h2 class="entry-title"><a href="' . esc_url( get_permalink() ) . '" rel="bookmark">', '</a></h2>' );
				endif;
				?>
				<div class="post-date">
					<?php echo xten_posted_on(); ?>
				</div><!-- .post-date -->
			</div><!-- .entry-meta -->
			<?php
		endif;
		?>
	</header><!-- .entry-header -->
	<?php
	$hide_post_image = get_post_meta( $post->ID, 'hide_featured_image', true );
	if ( has_post_thumbnail() && ! $hide_post_image ) :
		$post_thumb_width = 1106;
		$sidebar_location = get_theme_mod( 'sidebar_location', 'sidebar_right' );
		if ( $sidebar_location === 'sidebar_none' ) :
			$post_thumb_width = 1688;
		endif;
		?>
		<div class="featured-image">
			<?php xten_post_thumbnail( array( $post_thumb_width, null ) ); ?>
		</div><!-- featured-image -->
	<?php endif; // endif( has_post_thumbnail() && ! $hide_post_image ) : ?>

	<div class="entry-content">
		<?php

		the_content(
			sprintf(
				wp_kses(
					/* translators: %s: Name of current post. Only visible to screen readers */
					__( 'Continue reading<span class="screen-reader-text"> "%s"</span>', 'xten' ),
					array(
						'span' => array(
							'class' => array(),
						),
					)
				),
				get_the_title()
			)
		);

		wp_link_pages(
			array(
				'before' => '<div class="page-links">' . esc_html__( 'Pages:', 'xten' ),
				'after'  => '</div>',
			)
		);
		?>
	</div><!-- .entry-content -->

	<footer class="entry-footer xten-highlight-font">
		<div class="post-category">
			<h5 class="post-category-title">Category:</h5>
			<?php xten_post_categories(); ?>
		</div><!-- .post-category -->
		<?php
		xten_edit_post_link();
		?>
	</footer><!-- .entry-footer -->
</article><!-- #post-<?php the_ID(); ?> -->

<?php
if ( is_singular() ) :
	$post_type_name = esc_attr( get_post_type_object( get_post_type() )->labels->singular_name );
	the_post_navigation(
		array(
			'prev_text'          => __( '<div class="nav-link-label"><i class="nav-link-label-icon fas fa-arrow-left"></i> <span class="nav-link-label-text">Previous ' . $post_type_name . '</span></div><div class="ctnr-nav-title"><span class="nav-title">%title</span></div>' ),
			'next_text'          => __( '<div class="nav-link-label"><span class="nav-link-label-text">Next ' . $post_type_name . '</span> <i class="nav-link-label-icon fas fa-arrow-right"></i></div><div class="ctnr-nav-title"><span class="nav-title">%title</span></div>' ),
			'screen_reader_text' => __( 'Posts navigation' ),
		)
	);

	// If comments are open or we have at least one comment, load up the comment template.
	if ( comments_open() || get_comments_number() ) :
		comments_template();
	endif;
endif;
