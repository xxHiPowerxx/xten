<?php
/**
 * WP Rig functions and definitions
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @package xten
 */

/**
 * Utility Functions.
 */
require get_template_directory() . '/inc/utility-functions.php';

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
	// Vendor

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
		wp_register_style( $handle, get_theme_file_uri( '/assets/vendor/fontawesome/css/all.min.css' ), array(), '6.1.1', 'all' );
	}

	// Slick Slider Vendor
	// Slick JS
	$slick_version = '1.8.0';
	$handle = 'xten-vendor-slick-js';
	if ( ! wp_script_is( $handle, 'registered' ) ) {
		wp_register_script( $handle, get_theme_file_uri( '/assets/vendor/slick/slick.min.js' ), array( 'jquery' ), $slick_version, true );
	}
	// Slick CSS
	$handle = 'xten-vendor-slick-css';
	if ( ! wp_style_is( $handle, 'registered' ) ) {
		wp_register_style( $handle, $get_theme_file_uri( '/assets/vendor/slick/slick.min.css' ), array(), $slick_version, 'all' );
	}

	// Fancybox Vendor
	// Fancybox JS
	$fancybox_version = '3.5.7';
	$handle = 'xten-vendor-fancybox-js';
	if ( ! wp_script_is( $handle, 'registered' ) ) {
		wp_register_script( $handle, get_theme_file_uri( '/assets/vendor/fancybox/jquery.fancybox.min.js' ), array( 'jquery' ), $fancybox_version, true );
	}
	// Fancybox CSS
	$handle = 'xten-vendor-fancybox-css';
	if ( ! wp_style_is( $handle, 'registered' ) ) {
		wp_register_style( $handle, get_theme_file_uri( '/assets/vendor/fancybox/jquery.fancybox.min.css' ), array(), $fancybox_version, 'all' );
	}

	// AOS Vendor
	// AOS JS
	$aos_version = '2.3.4';
	$handle = 'xten-vendor-aos-js';
	if ( ! wp_script_is( $handle, 'registered' ) ) {
		wp_register_script( $handle, get_theme_file_uri( '/assets/vendor/aos/aos.js' ), array(), $aos_version, true );
	}
	// AOS CSS
	$handle = 'xten-vendor-aos-css';
	if ( ! wp_style_is( $handle, 'registered' ) ) {
		wp_register_style( $handle, get_theme_file_uri( '/assets/vendor/aos/aos.css' ), array(), $aos_version, 'all' );
	}

	// /Vendor

	// Shared

	$handle = 'xten-fancybox-js';
	$file_path = '/js/shared/xten-fancybox.js';
	wp_register_script(
		$handle,
		get_theme_file_uri( $file_path ),
		array( 'jquery', 'xten-vendor-fancybox-js' ),
		xten_filemtime( get_template_directory() . $file_path ),
		true
	);

	// /Shared

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
add_action( 'wp_enqueue_scripts', 'xten_styles', 1 );

/**
 * Admin Styles.
 */
function admin_style() {
	wp_enqueue_style( 'xten-admin-styles', get_template_directory_uri().'/css/admin.css', array(), filemtime( get_template_directory() . '/css/admin.css' ) );
}
add_action( 'admin_enqueue_scripts', 'admin_style' );

/**
 * Add class to body if front page.
 */
function xten_add_classes_to_body( $classes ) {
	// Add class to body if device is mobile.
	if ( wp_is_mobile() ) :
		$classes[] = 'xten-is-mobile';
	endif;

	return $classes;
}
add_filter( 'body_class', 'xten_add_classes_to_body' );

/**
 * Enqueue scripts.
 */
function xten_scripts() {
	// Bootstrap
	wp_enqueue_script( 'xten-vendor-bootstrap-js' );

	// Main
	wp_register_script( 'xten-js-cookie', get_theme_file_uri( '/lib/js-cookie/js.cookie.min.js' ), array( ), filemtime( get_template_directory() . '/lib/js-cookie/js.cookie.min.js' ), true );
	wp_enqueue_script( 'xten-main', get_theme_file_uri( '/js/main.js' ), array( 'jquery', 'xten-js-cookie' ), filemtime( get_template_directory() . '/js/main.js' ), false );


	wp_enqueue_script( 'xten-quick-search', get_theme_file_uri( '/js/quick-search.js' ), array( 'xten-main' ), filemtime( get_template_directory() . '/js/quick-search.js' ), false );

	wp_localize_script(
		'xten-quick-search',
		'xtenMagic',
		array(
			'ajaxurl'        => esc_url( admin_url( 'admin-ajax.php' ) ),
			'postID'         => isset($post->ID) ? $post->ID : '',
			'rooturl'        => esc_url( home_url() ),
			'magicNonce'     => wp_create_nonce( 'xten-magic-nonce' ),
			// 'mapApiKey'      => ( ! empty( $xten_options['google-maps-api-key'] ) ) ? $xten_options['google-maps-api-key'] : '',
		)
	);

	// Enqueue the header script.
	wp_register_script( 'xten-accessible-mega-menu', get_theme_file_uri( '/lib/accessible-mega-menu/jquery-accessibleMegaMenu.js' ), array( 'jquery' ), filemtime( get_template_directory() . '/lib/accessible-mega-menu/jquery-accessibleMegaMenu.js' ), true );
	wp_enqueue_script( 'xten-header-padding', get_theme_file_uri( '/js/header-padding.js' ), array('jquery' ), filemtime( get_template_directory() . '/js/header-padding.js' ), true );
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
add_filter('acf/settings/url', 'my_acf_settings_url' );
function my_acf_settings_url( $url ) {
	return MY_ACF_URL;
}

// (Optional) Hide the ACF admin menu item.
// add_filter( 'acf/settings/show_admin', 'my_acf_settings_show_admin' );
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
 * Quick Search
 */
require get_template_directory(). '/inc/classes/class-xten-quick-search.php';

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
$select_where_to_save_acf_field_groups = get_field( 'select_where_to_save_acf_field_groups', 'options' );
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
	remove_filter( 'acf_the_content', 'wpautop' );
	$field = get_field( $field_name, $option );
	add_filter( 'acf_the_content', 'wpautop' );
	return $field;
}

/**
 * Figure Out Site Logo.
 */
$custom_logo_svg                   = get_theme_mod( 'custom_logo_svg' );
$custom_logo_id                    = get_theme_mod( 'custom_logo' );
$GLOBALS['xten-child-logo-path']   = get_stylesheet_directory() . '/header-logo.svg';
$GLOBALS['xten-child-logo-exists'] = file_exists( $GLOBALS['xten-child-logo-path'] );
if ( $custom_logo_svg ) :
	$GLOBALS['xten-logo-type'] = 'custom_svg';
	$GLOBALS['xten-site-logo'] = "<div class=\"custom-logo\">$custom_logo_svg</div>";
elseif ( $custom_logo_id ) :
	$GLOBALS['xten-logo-type'] = 'custom';
	$GLOBALS['xten-site-logo'] = xten_get_custom_logo( $custom_logo_id );
elseif ( $GLOBALS['xten-child-logo-exists'] ) :
	$GLOBALS['xten-logo-type'] = 'child';
	$GLOBALS['xten-site-logo'] = file_get_contents( $GLOBALS['xten-child-logo-path'] );
elseif ( $site_name = get_bloginfo() ) :
	$GLOBALS['xten-logo-type'] = 'site_name';
	$GLOBALS['xten-site-logo'] = "<div class=\"site-name\">$site_name</div>";
else :
	$GLOBALS['xten-logo-type'] = 'default';
	require get_template_directory() . '/inc/header/xten-site-logo-svg.php';
	$GLOBALS['xten-site-logo'] = '<div class=\"custom-logo\">' . $GLOBALS['xten-header-logo'] . '</div>';
endif;
$home_url = esc_url( home_url( '/' ) );
$GLOBALS['xten-site-logo-link'] = '<a href="' . $home_url . '" class="custom-logo-link" rel="home">' . $GLOBALS['xten-site-logo'] . '</a>';

// Remove Archive Name From Archive Title if ACF Option is set to Yes In Category or Site Settings Page.
function xten_remove_archive_name_from_title( $title ) {
	$local_use_archive_title = get_field( 'local_use_archive_title', get_queried_object() );
	$use_archive_title       = $local_use_archive_title !== null ?
															$local_use_archive_title :
															get_field( 'global_use_archive_title', 'option' );
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
    if( $value != '' ){
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

function xten_define_default_colors() {
	$GLOBALS['xten_default_colors'] = array(
		'xten_theme_color_black'           => '#333333',
		'xten_theme_color_white'           => '#ffffff',
		'xten_theme_color'                 => '#003366',
		'xten_theme_color_light'           => '#4e9ff1',
		'xten_theme_color_dark'            => '#002347',
		'xten_secondary_theme_color'       => null,
		'xten_secondary_theme_color_light' => null,
		'xten_secondary_theme_color_dark'  => null,
	);
}
add_action( 'after_setup_theme', 'xten_define_default_colors' );

function xten_define_global_theme_variables() {
	$GLOBALS['xten_theme_colors'] = array(
		'xten_theme_color_black'           => xten_get_color( 'xten_theme_color_black' ),
		'xten_theme_color_white'           => xten_get_color( 'xten_theme_color_white' ),
		'xten_theme_color'                 => xten_get_color( 'xten_theme_color' ),
		'xten_theme_color_light'           => xten_get_color( 'xten_theme_color_light' ),
		'xten_theme_color_dark'            => xten_get_color( 'xten_theme_color_dark' ),
		'xten_secondary_theme_color'       => xten_get_color( 'xten_secondary_theme_color' ),
		'xten_secondary_theme_color_light' => xten_get_color( 'xten_secondary_theme_color_light' ),
		'xten_secondary_theme_color_dark'  => xten_get_color( 'xten_secondary_theme_color_dark' ),
	);

	// Fonts
	$primary_font_family   = json_decode( get_theme_mod( 'primary_font_family', '{"type":"google", "value":"opensans", "serif":"sans-serif"}' ) );
	$secondary_font_family = json_decode( get_theme_mod( 'secondary_font_family', '{"type":"google", "value":"roboto", "serif":"sans-serif"}' ) );

	// Primary Font.
	$primary_font_fallback   = $primary_font_family->serif === 'sans-serif' ?
		'Helvetica, Arial, sans-serif' :
		'Times New Roman, serif';
	$primary_font_path       = $primary_font_family->value;
	$primary_font_w_fallback = $primary_font_family->value . ',' . $primary_font_fallback;

	// Secondary Font
	$secondary_font_fallback   = $secondary_font_family->serif === 'sans-serif' ?
		'Helvetica, Arial, sans-serif' :
		'Times New Roman, serif';
	$secondary_font_path       = $secondary_font_family->value;
	$secondary_font_w_fallback = $secondary_font_family->value . ',' . $secondary_font_fallback;

	$GLOBALS['xten_theme_fonts'] = array(
		'font_objects'   => array(
			'primary_font_object'   => $primary_font_family,
			'secondary_font_object' => $secondary_font_family,
		),
		'font_families'  => array(
			'primary_font_family'   => $primary_font_w_fallback,
			'secondary_font_family' => $secondary_font_w_fallback,
		),
	);
}
add_action( 'after_setup_theme', 'xten_define_global_theme_variables' );

function xten_define_theme_css() {
	$css           = '';
	$css_variables = '';
	// Colors
	foreach( $GLOBALS['xten_theme_colors'] as $name => $value ) :
		if ( $value === null ) :
			continue;
		endif;
		$name_c        = xten_snake_to_dash( $name );
		$name_bg       = str_replace( 'color', 'bg-color', $name_c );
		$css           .= ".$name_c{color:$value;}";
		$css           .= ".$name_bg{background-color:$value;}";
		$css_variables .= "--$name_c:$value;";
		// Add !important Variant of each.
		$name_c_i      = "$name_c-i";
		$name_bg_i     = "$name_bg-i";
		$css           .= ".$name_c_i{color:$value !important;}";
		$css           .= ".$name_bg_i{background-color:$value !important;}";
	endforeach;
	// /Colors
	// Fonts
	foreach( $GLOBALS['xten_theme_fonts']['font_families'] as $name => $value ) :
		$name_f         = xten_snake_to_dash( $name );
		$css           .= '.' . $name_f . '{font-family:' . $value . ';}';
		$css_variables .= '--' . $name_f . ':' . $value . ';';
	endforeach;
	// /Fonts

	$css .= ':root{' . $css_variables . '}';
	return $GLOBALS['xten_theme_css'] = $css;
}
add_action( 'after_setup_theme', 'xten_define_theme_css' );

function xten_customize_universal_colors() {
	$defaults = array(
		'#000000',
		'#ffffff',
		'#dd3333',
		'#dd9933',
		'#eeee22',
		'#1e73be',
		'#8224e3',
	);
	$theme_colors          = $GLOBALS['xten_theme_colors'];
	$filtered_theme_colors = array_filter( $theme_colors );
	$colors                = $defaults;
	foreach ( $filtered_theme_colors as $key=>$value ) :
		$index = array_search( $key, array_keys( $filtered_theme_colors ) );
		$colors[$index] = $value;
	endforeach;
	$colors_s = json_encode( $colors );
	?>
	<script>
		jQuery(document).ready(function($){
			var colors = <?php echo $colors_s; ?>;
			$.wp.wpColorPicker.prototype.options = {
				palettes: colors
			};
		});
	</script>
	<?php
}
add_action('admin_print_footer_scripts', 'xten_customize_universal_colors', 0);
add_action('customize_controls_print_footer_scripts', 'xten_customize_universal_colors', 0);

// Function requires Contact Form 7 to run.
// Used to Add Server-Side Referrer Page in Hidden CF7 Tag
(function() {
	// Bail if Contact Form 7 Plugin is not Activated.
	$cf7_plugin_file = 'contact-form-7/wp-contact-form-7.php';
	if ( ! is_plugin_active($cf7_plugin_file) ) :
		return;
	endif;
	/**
	 * Referer code for contact form 7
	 * @link https://www.fldtrace.com/referral-conversion-tracking-with-wordpress-contact-form-7
	 */
	function getIP() {
		$sProxy = '';
		if ( getenv( 'HTTP_CLIENT_IP' ) ) {
				$sProxy = $_SERVER['REMOTE_ADDR'];
				$sIP    = getenv( 'HTTP_CLIENT_IP' ) ;
		} elseif( $_SERVER['HTTP_X_FORWARDED_FOR'] ) {
				$sProxy = $_SERVER['REMOTE_ADDR'];
				$sIP    = $_SERVER['HTTP_X_FORWARDED_FOR'];
		} else {
				$sIP    = $_SERVER['REMOTE_ADDR'];
		}
		if ( ! empty( $sProxy ) ) {
				$sIP = $sIP . 'via-proxy:' . $sProxy;
		}
		return $sIP;
	}
	function setRefererTransient( $uniqueID ) {
		if ( false === ( $void = get_transient( $uniqueID ) ) ) {
				// set a transient for 2 hours
				set_transient( $uniqueID, $_SERVER['HTTP_REFERER'], 60*60*2 );
		}
	}
	function getReferrerPage( $form_tag ) {
		if ( $form_tag['name'] == 'server_referrer' ) {
				$uniqueID = getIP();
				setRefererTransient( $uniqueID );
				$form_tag['values'][] =  get_transient( $uniqueID );
		}
		return $form_tag;
	}
	if ( !is_admin() ) {
		add_filter( 'wpcf7_form_tag', 'getReferrerPage' );
	}
})();

if ( ! function_exists( 'xten_exclude_hidden_results_from_search_meta_query' ) ) :
	function xten_exclude_hidden_results_from_search_meta_query() {
		/**
		 * Exlcude Hidden Results from Search Meta Query Arguments
		 * 
		 * @return array - The array needed to exlude posts hidden with the option 'Hide From Search Results' on
		 */
		$arr = array(
			'relation' => 'OR',
			// ONLY show Items WHEN
			// hide_from_search_results DOES NOT EXIST
			array(
				'key' => 'hide_from_search_results',
				'compare' => 'NOT EXISTS',
			),
			// OR hide_from_search_results is set to FALSE
			array(
				'key' => 'hide_from_search_results',
				'value' => 0,
			),
		);
		return $arr;
	}
endif; // endif ( ! function_exists( 'xten_exclude_hidden_results_from_search_meta_query' ) ) :

if ( ! function_exists( 'exclude_pages_from_search' ) ) :
	function exclude_pages_from_search($query) {
		if ( !is_admin() && $query->is_main_query() && $query->is_search ) :
			$query->set('meta_query', xten_exclude_hidden_results_from_search_meta_query());
		endif;
	}
	add_action('pre_get_posts','exclude_pages_from_search');
endif; // endif ( ! function_exists( 'exclude_pages_from_search' ) ) :