<?php
/**
 * Template part for displaying attachment posts
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package xten
 */

?>

<article id="post-<?php the_ID(); ?>" <?php post_class( 'card-style page' ); ?>>

	<header class="entry-header">
		<?php
		the_title( '<h1 class="entry-title">', '</h1>' );
		?>
	</header><!-- .entry-header -->

	<div class="entry-content">

		<figure class="attachment-image">
			<?php echo wp_get_attachment_image( get_the_ID(), 'original' ); ?>
			<figcaption>
				<?php the_excerpt(); ?>
			</figcaption>
		</figure><!-- .attachment-image -->

		<?php
			remove_filter( 'the_content', 'prepend_attachment' );
			the_content();
		?>

	</div><!-- .entry-content -->

	<footer class="entry-footer xten-highlight-font">
		<?php
			xten_edit_post_link();
		?>
	</footer><!-- .entry-footer -->
</article><!-- #post-<?php the_ID(); ?> -->

<?php


// If the attachment is attached to a post, try linking to other attachments on the same post.
if ( ! empty( $post->post_parent ) ) :
	the_post_navigation(
		array(
			'prev_text'          => __( '<i class="fas fa-arrow-left"></i> %title' ),
			'next_text'          => __( '%title <i class="fas fa-arrow-right"></i>' ),
			'screen_reader_text' => __( 'Posts navigation' ),
		)
	);
endif;

// If comments are open or we have at least one comment, load up the comment template.
if ( comments_open() || get_comments_number() ) :
	comments_template();
endif;
