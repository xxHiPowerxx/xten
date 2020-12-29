<?php
/**
 * WP Rig functions and definitions
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @package xten
 */

/**
 * Sets up theme defaults and registers support for various WordPress features.
 *
 * Note that this function is hooked into the after_setup_theme hook, which
 * runs before the init hook. The init hook is too late for some features, such
 * as indicating support for post thumbnails.
 */
function xten_setup() {
		 /*
		* Make theme available for translation.
		* Translations can be filed in the /languages/ directory.
		* If you're building a theme based on xten, use a find and replace
		* to change 'xten' to the name of your theme in all the template files.
		*/
		load_theme_textdomain( 'xten', get_template_directory() . '/languages' );

		// Add default posts and comments RSS feed links to head.
		add_theme_support( 'automatic-feed-links' );

		/*
		* Let WordPress manage the document title.
		* By adding theme support, we declare that this theme does not use a
		* hard-coded <title> tag in the document head, and expect WordPress to
		* provide it for us.
		*/
		add_theme_support( 'title-tag' );

		/*
		* Enable support for Post Thumbnails on posts and pages.
		*
		* @link https://developer.wordpress.org/themes/functionality/featured-images-post-thumbnails/
		*/
		add_theme_support( 'post-thumbnails' );
		// TODO: Deprecate archive-thumbnail image size.
		add_image_size( 'archive-thumbnail', 450, 253.52, array( 'center', 'center' ) );

		// Hide featured image in post.
		include get_template_directory() . '/inc/hide-featued-image.php';

		// This theme uses wp_nav_menu() in one location.
		register_nav_menus(
			array(
				'primary' => esc_html__( 'Primary', 'xten' ),
			)
		);

		/*
		* Switch default core markup for search form, comment form, and comments
		* to output valid HTML5.
		*/
		add_theme_support(
			'html5',
			array(
				'search-form',
				'comment-form',
				'comment-list',
				'gallery',
				'caption',
			)
		);

		// Set up the WordPress core custom background feature.
		add_theme_support(
			'custom-background',
			apply_filters(
				'xten_custom_background_args',
				array(
					'default-color' => 'ffffff',
					'default-image' => '',
				)
			)
		);

		// Add theme support for selective refresh for widgets.
		add_theme_support( 'customize-selective-refresh-widgets' );

		/**
		 * Add support for core custom logo.
		 *
		 * @link https://codex.wordpress.org/Theme_Logo
		 */
		add_theme_support(
			'custom-logo',
			array(
				'height'      => 100,
				'width'       => 400,
				'flex-width'  => true,
				'flex-height' => false,
			)
		);

		/**
		 * Optional: Add AMP support.
		 *
		 * Add built-in support for the AMP plugin and specific AMP features.
		 * Control how the plugin, when activated, impacts the theme.
		 *
		 * @link https://wordpress.org/plugins/amp/
		 */
		add_theme_support(
			'amp',
			array(
				'comments_live_list' => true,
			)
		);
}
add_action( 'after_setup_theme', 'xten_setup' );

/**
 * Retrieve Standard Header Selection and start GLOBAL variable.
 */
$GLOBALS['mobile_nav_breakpoint'] = get_theme_mod( 'mobile_nav_breakpoint', 1050 );

/**
 * Set the embed width in pixels, based on the theme's design and stylesheet.
 *
 * @param  array $dimensions An array of embed width and height values in pixels ( in that order).
 * @return array
 */
function xten_embed_dimensions( array $dimensions ) {
	$dimensions['width'] = 720;
	return $dimensions;
}
add_filter( 'embed_defaults', 'xten_embed_dimensions' );

/**
 * Enqueue WordPress theme styles within Gutenberg.
 */
function xten_gutenberg_styles() {
	// Enqueue main stylesheet.
	wp_enqueue_style( 'xten-base-style', get_theme_file_uri( '/css/editor-styles.css' ), array(), filemtime( get_template_directory() . '/css/editor-styles.css' ) );
}
add_action( 'enqueue_block_editor_assets', 'xten_gutenberg_styles' );

/**
 * Enqueue styles.
 */
function xten_styles() {
	// Bootstrap.
	$handle = 'xten-vendor-bootstrap-css';
	if ( ! wp_style_is( $handle, 'registered' ) ) {
		wp_register_style( $handle, get_theme_file_uri( '/assets/vendor/bootstrap/css/bootstrap.min.css' ), array(), '4.0.0' );
	}
	$handle = 'xten-vendor-bootstrap-js';
	if ( ! wp_script_is( $handle, 'registered' ) ) {
		wp_register_script( $handle, get_theme_file_uri( '/assets/vendor/bootstrap/js/bootstrap.bundle.min.js' ), array( 'jquery' ), '4.0.0', true );
	}

	// Fontawesome.
	$handle = 'xten-vendor-fontawesome-css';
	if ( ! wp_style_is( $handle, 'registered' ) ) {
		wp_register_style( $handle, get_theme_file_uri( '/assets/vendor/fontawesome/css/all.min.css' ), array(), ' 5.7.1', 'all' );
	}

	// Enqueue main stylesheet.
	wp_enqueue_style( 'xten-base-style', get_theme_file_uri( '/css/common.css' ), array( 'xten-vendor-bootstrap-css', 'xten-vendor-fontawesome-css' ), filemtime( get_template_directory() . '/css/common.css' ) );

	// Register component styles that are printed as needed.
	wp_register_style( 'xten-comments-css', get_theme_file_uri( '/css/comments.css' ), array(), filemtime( get_template_directory() . '/css/comments.css' ) );
	wp_register_style( 'xten-content-css', get_theme_file_uri( '/css/content.css' ), array(), filemtime( get_template_directory() . '/css/content.css' ) );
	wp_register_style( 'xten-search-css', get_theme_file_uri( '/css/search.css' ), array(), filemtime( get_template_directory() . '/css/search.css' ) );
	wp_register_style( 'xten-sidebar-css', get_theme_file_uri( '/css/sidebar.css' ), array(), filemtime( get_template_directory() . '/css/sidebar.css' ) );
	wp_register_style( 'xten-widgets-css', get_theme_file_uri( '/css/widgets.css' ), array(), filemtime( get_template_directory() . '/css/widgets.css' ) );
	wp_register_style( 'xten-front-page-css', get_theme_file_uri( '/css/front-page.css' ), array(), filemtime( get_template_directory() . '/css/front-page.css' ) );
	wp_register_style( 'xten-404-css', get_theme_file_uri( '/css/404.css' ), array(), filemtime( get_template_directory() . '/css/404.css' ) );
	wp_register_style( 'xten-archive-css', get_theme_file_uri( '/css/archive.css' ), array(), filemtime( get_template_directory() . '/css/archive.css' ) );

	wp_register_style( 'xten-event-calendar', get_theme_file_uri( '/css/event-calendar-pro.css' ), array(), filemtime( get_template_directory() . '/css/event-calendar-pro.css' ) );
	wp_register_style( 'xten-page-hero-css', get_theme_file_uri( '/css/page-hero.css' ), array(), filemtime( get_template_directory() . '/css/page-hero.css' ) );

	wp_register_style( 'xten-header-css', get_theme_file_uri( '/css/xten-header.css' ), array(), filemtime( get_template_directory() . '/css/xten-header.css' ) );
	wp_enqueue_style( 'xten-site-header-css', get_theme_file_uri( '/css/site-header.css' ), array( 'xten-base-style','xten-header-css' ), filemtime( get_template_directory() . '/css/site-header.css' ) );
}
add_action( 'wp_enqueue_scripts', 'xten_styles' );

/**
 * Admin Styles.
 */
function admin_style() {
	wp_enqueue_style( 'xten-admin-styles', get_template_directory_uri().'/css/admin.css', array(), filemtime( get_template_directory() . '/css/admin.css' ) );
}
add_action( 'admin_enqueue_scripts', 'admin_style' );

/**
 * Add class to body if device is mobile.
 */
function xten_is_mobile( $classes ) {
	if ( wp_is_mobile() ) :
		$classes[] = 'xten-is-mobile';
	endif;
	return $classes;
}
add_filter( 'body_class', 'xten_is_mobile' );

/**
 * Enqueue scripts.
 */
function xten_scripts() {
	// Bootstrap
	wp_enqueue_script( 'xten-vendor-bootstrap-js' );

	// Main
	wp_register_script( 'xten-js-cookie', get_theme_file_uri( '/lib/js-cookie/js.cookie.min.js' ), array( ), filemtime( get_template_directory() . '/lib/js-cookie/js.cookie.min.js' ), true );
	wp_enqueue_script( 'xten-main', get_theme_file_uri( '/js/main.js' ), array( 'jquery', 'xten-js-cookie' ), filemtime( get_template_directory() . '/js/main.js' ), false );

	// Enqueue the header script.
	wp_register_script( 'xten-accessible-mega-menu', get_theme_file_uri( '/lib/accessible-mega-menu/jquery-accessibleMegaMenu.js' ), array( 'jquery' ), filemtime( get_template_directory() . '/lib/accessible-mega-menu/jquery-accessibleMegaMenu.js' ), true );
	wp_enqueue_script( 'xten-header-padding', get_theme_file_uri( '/js/header-padding.js' ), array('jquery'), filemtime( get_template_directory() . '/js/header-padding.js' ), true );
	wp_enqueue_script( 'xten-header', get_theme_file_uri( '/js/header.js' ), array( 'jquery', 'xten-vendor-bootstrap-js', 'xten-accessible-mega-menu' ), filemtime( get_template_directory() . '/js/header.js' ), true );
	wp_localize_script(
		'xten-header',
		'wprigScreenReaderText',
		array(
			'expand'   => __( 'Expand child menu', 'xten' ),
			'collapse' => __( 'Collapse child menu', 'xten' ),
		)
	);

	// Enqueue skip-link-focus script.
	wp_enqueue_script( 'xten-skip-link-focus-fix', get_theme_file_uri( '/js/skip-link-focus-fix.js' ), array(), filemtime( get_template_directory() . '/js/skip-link-focus-fix.js' ), false );
	wp_script_add_data( 'xten-skip-link-focus-fix', 'defer', true );

	// Enqueue comment script on singular post/page views only.
	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}
}
add_action( 'wp_enqueue_scripts', 'xten_scripts' );

/**
 * Activate Plugins
 */
// TODO: Remove this from project and test.
// No Longer Need to keep the plugin active.
// require get_template_directory() . '/inc/activate-plugins.php';

/**
 * Include ACF Dependancy
 */
// Define path and URL to the ACF plugin.
define( 'MY_ACF_PATH', get_template_directory() . '/lib/advanced-custom-fields/' );
define( 'MY_ACF_URL', get_template_directory_uri() . '/lib/advanced-custom-fields/' );

// Include the ACF plugin.
include_once( MY_ACF_PATH . 'acf.php' );

// Customize the url setting to fix incorrect asset URLs.
add_filter('acf/settings/url', 'my_acf_settings_url');
function my_acf_settings_url( $url ) {
	return MY_ACF_URL;
}

// (Optional) Hide the ACF admin menu item.
// add_filter('acf/settings/show_admin', 'my_acf_settings_show_admin');
// function my_acf_settings_show_admin( $show_admin ) {
//     return false;
// }

/**
 * Tribe Overrides
 */
require get_template_directory() . '/inc/tribe-override.php';

/**
 * Documentation.
 */
function xten_documentation_add_menu_item() {
	global $submenu;
	array_push( $submenu['index.php'], array( 'Web System', 'read', '//xxhipowerxx.github.io/xten/websystem/' ) );
}
add_action( 'admin_menu', 'xten_documentation_add_menu_item' );

/**
 * Guttenberg Settings.
 */
require get_template_directory() . '/inc/gutenberg-settings.php';

/**
 * Widget areas.
 */
require get_template_directory() . '/inc/widget-area.php';

/**
 * Implement the Custom Header feature.
 */
require get_template_directory() . '/pluggable/custom-header.php';

/**
 * Utility Functions.
 */
require get_template_directory() . '/inc/utility-functions.php';

/**
 * Custom template tags for this theme.
 */
require get_template_directory() . '/inc/template-tags.php';

/**
 * Functions which enhance the theme by hooking into WordPress.
 */
require get_template_directory() . '/inc/template-functions.php';

/**
 * Customizer additions.
 */
require get_template_directory() . '/inc/customizer.php';

/**
 * Customizer additions.
 */
require get_template_directory() . '/inc/custom-nav-walker.php';

/**
 * Disable comments.
 */
require get_template_directory() . '/inc/disable-comments.php';

/**
 * Bootstrap pagination.
 */
require get_template_directory() . '/inc/bootstrap-pagination.php';

/**
 * Archive Excerpt.
 */
require get_template_directory() . '/inc/archive-excerpt.php';

/**
 * Inline Styles.
 */
require get_template_directory() . '/inc/inline-styles.php';

/**
 * Shotcodes.
 */
require get_template_directory() . '/inc/shortcodes.php';

/**
 * Add fields to posts and pages.
 */
require get_template_directory() . '/inc/custom-fields.php';

/**
 * Mobile class.
 */
require get_template_directory() . '/inc/mobile-class.php';

/**
 * Implement the Custom Header feature.
 */
require get_template_directory() . '/inc/header/mega-menu.php';

/**
 * Site Settings
 */
require get_template_directory() . '/inc/site-settings.php';

/**
 * Editor Role Modifications
 */
require get_template_directory() . '/inc/editor-role.php';

/**
 * Load ACF Fields
 */
add_filter( 'acf/settings/load_json', 'xten_json_load_point' );

function xten_json_load_point( $paths ) {

	// remove original path (optional).
	unset( $paths[0] );

	// append path.
	$paths[] = get_template_directory() . '/acf-json';

	// return.
	return $paths;
}

// Check to see if xten Save fields file exsists and adds save point if it does.
$save_acf_fields = get_template_directory() . '/save-acf-fields.php';
$select_where_to_save_acf_field_groups = get_field('select_where_to_save_acf_field_groups', 'options');
$select_where_to_save_acf_field_groups = $select_where_to_save_acf_field_groups !== null ? $select_where_to_save_acf_field_groups : 'parent';
if ( $select_where_to_save_acf_field_groups === 'parent' ) :
	if ( file_exists( $save_acf_fields ) ) :
		require $save_acf_fields;
	endif;
endif;

/**
 * Remove Dev Templates From Backend Selection
 */
function xten_remove_dev_template( $page_templates ) {

	foreach ( $page_templates as $key => $template ) {

		if ( strpos( $key, 'dev/' ) === 0 || strpos( $key, 'dist/' ) === 0 ) {
			unset( $page_templates[ $key ] );
		}
	}

	return $page_templates;
}
add_filter( 'theme_page_templates', 'xten_remove_dev_template', 20, 3 );

/**
 * Remove <p> Tags from ACF wysiwyg Fields.
 */
function get_field_without_wpautop( $field_name, $option ) {
	remove_filter('acf_the_content', 'wpautop');
	$field = get_field( $field_name, $option );
	add_filter('acf_the_content', 'wpautop');
	return $field;
}

/**
 * Figure Out Site Logo.
 */
// If PNG has been chosen use that.
$custom_logo_id                    = get_theme_mod( 'custom_logo' );
$GLOBALS['xten-child-logo-path']   = get_stylesheet_directory() . '/header-logo.svg';
$GLOBALS['xten-child-logo-exists'] = file_exists( $GLOBALS['xten-child-logo-path'] );
if ( $custom_logo_id ) :
	$GLOBALS['xten-site-logo'] = xten_get_custom_logo( $custom_logo_id );
elseif ( $GLOBALS['xten-child-logo-exists'] ) :
	$GLOBALS['xten-using-child-logo'] = true;
	$GLOBALS['xten-site-logo'] = file_get_contents( $GLOBALS['xten-child-logo-path'] );
else :
	require get_template_directory() . '/inc/header/xten-site-logo-svg.php';
	$GLOBALS['xten-site-logo'] = $GLOBALS['xten-header-logo'];
endif;
$home_url = esc_url( home_url( '/' ) );
$GLOBALS['xten-site-logo-link'] = '<a href="' . $home_url . '" class="custom-logo-link" rel="home">' . $GLOBALS['xten-site-logo'] . '</a>';

// Remove Archive Name From Archive Title if ACF Option is set to Yes In Category or Site Settings Page.
function xten_remove_archive_name_from_title( $title ) {
	$local_use_archive_title = get_field('local_use_archive_title', get_queried_object());
	$use_archive_title       = $local_use_archive_title !== null ?
															$local_use_archive_title :
															get_field('global_use_archive_title', 'option');
	if ( $use_archive_title === false ) :
			if ( is_category() ) {
					$title = single_cat_title( '', false );
			} elseif ( is_tag() ) {
					$title = single_tag_title( '', false );
			} elseif ( is_author() ) {
					$title = '<span class="vcard">' . get_the_author() . '</span>';
			} elseif ( is_post_type_archive() ) {
					$title = post_type_archive_title( '', false );
			} elseif ( is_tax() ) {
					$title = single_term_title( '', false );
			}
	endif;
	return $title;
}
add_filter( 'get_the_archive_title', 'xten_remove_archive_name_from_title' );

/**
 * Add Post Meta to Category Thumbnail when created.
 * @see https://www.advancedcustomfields.com/resources/acf-update_value/
 */
function xten_set_category_featured_image( $value, $post_id, $field ){
    if($value != ''){
			//Add the value which is the image ID to the _thumbnail_id meta data for the current post
			$term_id = str_replace( 'term_', '', $post_id );
	    add_term_meta($term_id, '_thumbnail_id', $value);
    }
    return $value;
}

// acf/update_value/name={$field_name} - filter for a specific field based on it's name
add_filter('acf/update_value/name=category_thumbnail', 'xten_set_category_featured_image', 10, 3);

/**
 * Set Open Graph Image for Archive Pages.
 */
function xten_wpseo_opengraph_image() {
	// Check to see if Yoast SEO Plugin is not Activated.
	$yoast_seo_plugin_file = 'wordpress-seo/wp-seo.php';
	if ( ! is_plugin_active($yoast_seo_plugin_file) ) :
		return;
	else :
		global $wp_query;
		if ( $wp_query->is_archive ) :
			$is_category         = $wp_query->is_category;
			$is_custom_post_type = $wp_query->is_post_type_archive;
			$post_ID             = get_the_ID();
			$meta_tags           = '';
			$og_image_url;
			$og_image_alt;

			// If page is a Category Archive OR is Investigation Archive, get the thumbnail.
			if ( $is_category || $is_custom_post_type ) :
				if ( $is_category ) :
					$term_ID      = get_queried_object()->term_id;
					$thumbnail_id = get_term_meta( $term_ID )['_thumbnail_id'][0];
					// var_dump($term_ID, ' foobar');
				else :
					$thumbnail_id = has_post_thumbnail( $post_ID ) ?
						get_post_thumbnail_id( $post_ID ) :
						get_post_thumbnail_id( $home_page_id );
				endif;
				$thumbnail_details       = wp_get_attachment_image_src( $thumbnail_id, 'full' );
				$og_image_url            = $thumbnail_details[0];
				$og_image_width          = $thumbnail_details[1];
				$og_image_height         = $thumbnail_details[2];
				$thumbnail_post_meta_alt = get_post_meta( $thumbnail_id, '_wp_attachment_image_alt', true );
				$og_image_alt            = $thumbnail_post_meta_alt ?
				esc_attr( $thumbnail_post_meta_alt ) :
				'';
			endif;

			if ( $og_image_url ) :
				$meta_tags .= '<meta property="og:image" content="' . $og_image_url . '" />' .
				'<meta property="og:image:width" content="' . $og_image_width . '" />' .
				'<meta property="og:image:height" content="' . $og_image_height . '" />' .
				'<meta property="twitter:image" content="' . $og_image_url . '" />';
				if ( $og_image_alt ) :
					$meta_tags .= '<meta property="og:image:alt" content="' . $og_image_alt . '" />' .
					'<meta property="twitter:image:alt" content="' . $og_image_alt . '" />';
				endif;
			endif;
		endif; // endif ( $wp_query->is_archive ) :

		if ( $meta_tags !== '' ) :
			echo $meta_tags;
		else :
			return;
		endif;
	endif; // if ( ! is_plugin_active($yoast_seo_plugin_file) ) :
}
add_action('wp_head', 'xten_wpseo_opengraph_image', 5);