<?php
/**
 * Custom template tags for this theme
 *
 * Eventually, some of the functionality here could be replaced by core features.
 *
 * @package xten
 */

/**
 * Determine whether this is an AMP response.
 *
 * Note that this must only be called after the parse_query action.
 *
 * @link https://github.com/Automattic/amp-wp
 * @return bool Is AMP endpoint (and AMP plugin is active).
 */
function xten_is_amp() {
	return function_exists( 'is_amp_endpoint' ) && is_amp_endpoint();
}

/**
 * Determine whether amp-live-list should be used for the comment list.
 *
 * @return bool Whether to use amp-live-list.
 */
function xten_using_amp_live_list_comments() {
	if ( ! xten_is_amp() ) :
		return false;
	endif;
	$amp_theme_support = get_theme_support( 'amp' );
	return ! empty( $amp_theme_support[0]['comments_live_list'] );
}

/**
 * Add pagination reference point attribute for amp-live-list when theme supports AMP.
 *
 * This is used by the navigation_markup_template filter in the comments template.
 *
 * @link https://www.ampproject.org/docs/reference/components/amp-live-list#pagination
 *
 * @param string $markup Navigation markup.
 * @return string Markup.
 */
function xten_add_amp_live_list_pagination_attribute( $markup ) {
	return preg_replace( '/(\s*<[a-z0-9_-]+)/i', '$1 pagination ', $markup, 1 );
}

/**
 * Prints the header of the current displayed page based on its contents.
 */
function xten_index_header() {
	if ( is_home() && ! is_front_page() ) :
		?>
		<header>
			<h1 class="page-title screen-reader-text"><?php single_post_title(); ?></h1>
		</header>
		<?php
	elseif ( is_search() ) :
		?>
		<header class="page-header">
			<h1 class="page-title">
			<?php
				/* translators: %s: search query. */
				printf( esc_html__( 'Search Results for: %s', 'xten' ), '<span>' . get_search_query() . '</span>' );
			?>
			</h1>
		</header><!-- .page-header -->
		<?php
	elseif ( is_archive() ) :
		?>
		<header class="page-header content-area card-style">
			<?php
			the_archive_title( '<h1 class="page-title">', '</h1>' );
			the_archive_description( '<div class="archive-description">', '</div>' );
			?>
		</header><!-- .page-header -->
		<?php
	endif;
}

/**
 * Prints HTML with meta information for the current post-date/time.
 */
if ( ! function_exists( 'xten_posted_on' ) ) :
	function xten_posted_on( $post = null ) {
		$post = get_post( $post );
		if ( ! $post ) {
			return false;
		}
		$time_string = '<time class="entry-date published updated" datetime="%1$s">%2$s</time>';
		if ( get_the_time( 'U', $post ) !== get_the_modified_time( 'U', $post ) ) :
			$time_string = '<time class="entry-date published" datetime="%1$s">%2$s</time><time class="updated" datetime="%3$s">%4$s</time>';
		endif;

		$time_string = sprintf(
			$time_string,
			esc_attr( get_the_date( 'c', $post ) ),
			esc_html( get_the_date( '', $post) ),
			esc_attr( get_the_modified_date( 'c', $post ) ),
			esc_html( get_the_modified_date('', $post) )
		);

		$href_attr = '#';
		if ( $post !== get_queried_object() ) :
			$href_attr = 'href="' . esc_url( get_permalink($post) ) . '"';
		endif;

		$posted_on = sprintf(
			/* translators: %s: post date. */
			esc_html( '%1$s', 'post date', 'xten' ),
			'<a ' . $href_attr . ' rel="bookmark">' . $time_string . '</a>'
		);

		return '<span class="posted-on">' . $posted_on . ' </span>'; // WPCS: XSS OK.

	}
endif; // endif ( ! function_exists( 'xten_posted_on' ) ) :

/**
 * Prints HTML with meta information for the current author.
 */
function xten_posted_by() {
	$byline = sprintf(
		/* translators: %s: post author. */
		esc_html_x( 'by %s', 'post author', 'xten' ),
		'<span class="author vcard"><a class="url fn n" href="' . esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ) . '">' . esc_html( get_the_author() ) . '</a></span>'
	);

	echo '<span class="byline"> ' . $byline . ' </span>'; // WPCS: XSS OK.
}

/**
 * Prints a link list of the current categories for the post.
 *
 * If additional post types should display categories, add them to the conditional statement at the top.
 */
function xten_post_categories() {
	// Only show categories on post types that have categories, not pages.
	if ( 'page' !== get_post_type() ) :
		/* translators: used between list items, there is a space after the comma */
		$categories_list = get_the_category_list( esc_html__( ',&nbsp;', 'xten' ) );
		if ( $categories_list ) :
			/* translators: 1: list of categories. */
			printf( '<span class="cat-links d-flex flex-row flex-wrap">' . esc_html__( '%1$s', 'xten' ) . ' </span>', $categories_list ); // WPCS: XSS OK.
		endif;
	endif;
}

/**
 * Prints a link list of the current tags for the post.
 *
 * If additional post types should display tags, add them to the conditional statement at the top.
 */
function xten_post_tags() {
	// Only show tags on post types that have categories.
	if ( 'post' === get_post_type() ) :
		/* translators: used between list items, there is a space after the comma */
		$tags_list = get_the_tag_list( '', esc_html_x( ', ', 'list item separator', 'xten' ) );
		if ( $tags_list ) :
			/* translators: 1: list of tags. */
			printf( '<span class="tags-links">' . esc_html__( 'Tagged %1$s', 'xten' ) . ' </span>', $tags_list ); // WPCS: XSS OK.
		endif;
	endif;
}

/**
 * Prints comments link when comments are enabled.
 */
function xten_comments_link() {
	if (
		! is_single() &&
		! post_password_required() &&
		(
			comments_open() ||
			get_comments_number()
		)
	) :
		echo '<span class="comments-link">';
		comments_popup_link(
			sprintf(
				wp_kses(
					/* translators: %s: post title */
					__( 'Leave a Comment<span class="screen-reader-text"> on %s</span>', 'xten' ),
					array(
						'span' => array(
							'class' => array(),
						),
					)
				),
				get_the_title()
			)
		);
		echo ' </span>';
	endif;
}

/**
 * Prints edit post/page link when a user with sufficient priveleges is logged in.
 */
function xten_edit_post_link() {
	edit_post_link(
		sprintf(
			wp_kses(
				/* translators: %s: Name of current post. Only visible to screen readers */
				__( 'Edit <span class="screen-reader-text">%s</span>', 'xten' ),
				array(
					'span' => array(
						'class' => array(),
					),
				)
			),
			get_the_title()
		),
		'<span class="edit-link">',
		' </span>'
	);
}

/**
 * Displays an optional post thumbnail.
 *
 * Wraps the post thumbnail in an anchor element on index views, or a div
 * element when on single views.
 * 
 * @param string|array $size = 'full' - Optional Argument, Accepts same arguements as wp_get_attachment_image()
 * @see https://developer.wordpress.org/reference/functions/wp_get_attachment_image/
 * 
 */
function xten_post_thumbnail( $size = 'full' ) {
	if ( post_password_required() || is_attachment() || ! has_post_thumbnail() ) :
		return;
	endif;
	$image_id = get_post_thumbnail_id();
	$wide_tall;
	if ( $image_id ) :
		$size = xten_get_optimal_image_size( $image_id, $size, array( 16, 9 ) );
		if ( is_array( $size ) ) :
			$wide_tall = xten_wide_tall_image( $size );
		else :
			$wide_tall = xten_wide_tall_image( get_post_thumbnail_id() );
		endif;
	endif;

	if ( is_singular() ) :
		?>

		<div class="post-thumbnail">
			<?php the_post_thumbnail( $size, array( 'class' => 'skip-lazy ' . $wide_tall ) ); ?>
		</div><!-- .post-thumbnail -->

	<?php else : ?>

		<a class="post-thumbnail" href="<?php the_permalink(); ?>" aria-hidden="true">
			<?php
			global $wp_query;
			if ( 0 === $wp_query->current_post ) :
				the_post_thumbnail(
					'full',
					array(
						'class' => 'skip-lazy',
						'alt'   => the_title_attribute(
							array(
								'echo' => false,
							)
						),
					)
				);
			else :
				the_post_thumbnail(
					'post-thumbnail', array(
						'alt' => the_title_attribute(
							array(
								'echo' => false,
							)
						),
					)
				);
			endif;
			?>
		</a>

		<?php
	endif; // End is_singular().
}

/**
 * Prints HTML with title and link to original post where attachment was added.
 *
 * @param object $post object.
 */
function xten_attachment_in( $post ) {
	if ( ! empty( $post->post_parent ) ) :
		$postlink = sprintf(
			/* translators: %s: original post where attachment was added. */
			esc_html_x( 'in %s', 'original post', 'xten' ),
			'<a href="' . esc_url( get_permalink( $post->post_parent ) ) . '">' . esc_html( get_the_title( $post->post_parent ) ) . '</a>'
		);

		echo '<span class="attachment-in"> ' . $postlink . ' </span>'; // WPCS: XSS OK.

	endif;

}

/**
 * Prints HTML with for navigation to previous and next attachment if available.
 */
function xten_the_attachment_navigation() {
	?>
	<nav class="navigation post-navigation" role="navigation">
		<h2 class="screen-reader-text"><?php echo esc_html__( 'Post navigation', 'xten' ); ?></h2>
		<div class="nav-links">
			<div class="nav-previous">
				<div class="post-navigation-sub">
					<?php echo esc_html__( 'Previous attachment:', 'xten' ); ?>
				</div>
				<?php previous_image_link( false ); ?>
			</div><!-- .nav-previous -->
			<div class="nav-next">
				<div class="post-navigation-sub">
					<?php echo esc_html__( 'Next attachment:', 'xten' ); ?>
				</div>
				<?php next_image_link( false ); ?>
			</div><!-- .nav-next -->
		</div><!-- .nav-links -->
	</nav><!-- .navigation .attachment-navigation -->
	<?php
}
