<?php
/**
 * Meta Tags for <head></head>.
 *
 * @package xten
 */

?>

<meta charset="<?php bloginfo( 'charset' ); ?>" />
<meta http-equiv="X-UA-Compatible" content="IE=edge" />
<meta name="viewport" content="width=device-width, initial-scale=1, minimum-scale=1" />
<meta name="mobile-web-app-capable" content="yes" />
<meta name="apple-mobile-web-app-capable" content="yes" />
<meta name="apple-mobile-web-app-title" content="<?php bloginfo( 'name' ); ?> - <?php bloginfo( 'description' ); ?>" />

<!-- SEO -->
<?php
setup_postdata( $post );
$metadescription_field = 'metadescription_17587';
if ( is_front_page() ) :
	$site_title       = get_bloginfo( 'name' );
	$site_tagline     = get_bloginfo( 'description' );
	$concat_tagline   = $site_tagline ? ' - ' . $site_tagline : '';
	$page_title       = $site_title ?
											$site_title . $concat_tagline :
											get_the_title();
	$meta_description = get_post_meta( get_the_ID(), $metadescription_field, true ) ? get_post_meta( get_the_ID(), $metadescription_field, true ) : wp_strip_all_tags( get_the_excerpt() );
elseif ( is_page() || is_single() ) :
	$page_title       = get_the_title() . ' - ' . get_bloginfo( 'name' );
	$meta_description = get_post_meta( get_the_ID(), $metadescription_field, true ) ? get_post_meta( get_the_ID(), $metadescription_field, true ) : wp_strip_all_tags( get_the_excerpt() );
elseif ( is_category() ) :
	$page_title       = single_cat_title( '', false ) . ' - ' . get_bloginfo( 'name' );
	$meta_description = 'Post Category: ' . single_cat_title( '', false ) . ' on ' . get_bloginfo( 'name' );
elseif ( is_date() ) :
	$page_title       = get_the_archive_title() . ' - ' . get_bloginfo( 'name' );
	$meta_description = 'Entries Posted on ' . get_the_archive_title() . ' - ' . get_bloginfo( 'name' );
elseif ( is_archive() ) :
	$page_title       = get_the_archive_title() . ' - ' . get_bloginfo( 'name' );
	$meta_description = 'Entries Posted in ' . get_the_archive_title() . ' - ' . get_bloginfo( 'name' );
elseif ( is_search() ) :
	$page_title       = 'Search Results';
	$meta_description = 'Search Results Page for ' . get_search_query() . ' on ' . get_bloginfo( 'name' );
elseif ( is_404() ) :
	$page_title       = 'Sorry, Page Not Found';
	$meta_description = 'Page Not Found on ' . get_bloginfo( 'name' );
elseif ( is_home() ) :
	$page_title       = 'Blog Page - ' . get_bloginfo( 'name' );
	$meta_description = 'Blog Page on ' . get_bloginfo( 'name' );
else :
	$page_title       = get_bloginfo( 'name' );
	$meta_description = get_bloginfo( 'description' );
endif;
$custom_logo_id = get_theme_mod( 'custom_logo' );
$logo           = wp_get_attachment_image( $custom_logo_id, 'full' );
$logo_url       = wp_get_attachment_image_src( $custom_logo_id, 'full' );
$post_ID        = get_the_ID();
$home_page_id   = get_option( 'page_on_front' );
if ( has_post_thumbnail( $post_ID ) || has_post_thumbnail( $home_page_id ) ) :
	$thumbnail_id = has_post_thumbnail() ? get_post_thumbnail_id( $post_ID ) : get_post_thumbnail_id( $home_page_id );
elseif ( $custom_logo_id ) : // if thumbnail is set on current post or home page, fallback to custom logo.
	$thumbnail_id = $custom_logo_id;
else :
	$thumbnail_id = null;
endif;

if ( $thumbnail_id ) :
	// If no Featured Image is set, fallback to the home page Featured Image.
	$thumbnail_details       = wp_get_attachment_image_src( $thumbnail_id, 'full' );
	$og_image_url            = $thumbnail_details[0];
	$og_image_width          = $thumbnail_details[1];
	$og_image_height         = $thumbnail_details[2];
	$thumbnail_post_meta_alt = get_post_meta( $thumbnail_id, '_wp_attachment_image_alt', true );
	$og_image_alt            = $thumbnail_post_meta_alt ? esc_attr( $thumbnail_post_meta_alt ) : '';
else :
	$og_image_url            = '';
endif;
?>
<meta name="description" content="<?php echo esc_attr( $meta_description ); ?>" />
<meta property="og:title" content="<?php echo esc_attr( $page_title ); ?>" />
<meta property="og:description" content="<?php echo esc_attr( $meta_description ); ?>" />
<meta property="og:url" content="<?php echo get_permalink(); ?>" />
<meta property="og:site_name" content="<?php echo esc_attr( bloginfo( 'name' ) ); ?>" />
<?php if ( $og_image_url ) : ?>
	<meta property="og:image" content="<?php echo $og_image_url; ?>" />
	<meta property="og:image:width" content="<?php echo $og_image_width; ?>" />
	<meta property="og:image:height" content="<?php echo $og_image_height; ?>" />
	<?php if ( $og_image_alt ) : ?>
		<meta property="og:image:alt" content="<?php echo $og_image_alt; ?>" />
		<?php
	endif;
endif;
?>
<meta name="twitter:card" content="summary_large_image" />
<meta name="twitter:description" content="<?php echo esc_attr( $meta_description ); ?>" />
<meta name="twitter:title" content="<?php echo esc_attr( $page_title ); ?>" />
<?php if ( $og_image_url ) : ?>
	<meta name="twitter:image" content="<?php echo $og_image_url ?>" />
	<?php if ( $og_image_alt ) : ?>
		<meta property="twitter:image:alt" content="<?php echo $og_image_alt; ?>" />
		<?php
	endif;
endif;
?>
<!-- /SEO -->
