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
		add_image_size( 'archive-thumbnail', 426, 240, array( 'center', 'center' ) );

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
$GLOBALS['internet_or_xtenline'] = get_theme_mod( 'standard_header_selection', 'standard_internet_header' );
$GLOBALS['mobile_menu_breakpoint'] = get_theme_mod( 'mobile_nav_breakpoint', 1050 );
$GLOBALS['department_name']        = esc_attr( get_theme_mod( 'standard_header_logo_department_name' ) );

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
		wp_enqueue_style( 'xten-standard-header-css', get_theme_file_uri( '/css/standard-header.css' ), array( 'xten-header-css' ), filemtime( get_template_directory() . '/css/standard-header.css' ) );
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
require get_template_directory() . '/inc/activate-plugins.php';

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
/* calls Social Medial Widget for Widget Area */
require get_template_directory() . '/inc/social-media-widget.php';

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
 * Utility Functions.
 */
require get_template_directory() . '/inc/utility-functions.php';

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

// Check to see if xten Save feilds file exsists and adds save point if it does.
$save_acf_fields = get_template_directory() . '/save-acf-fields.php';
if ( file_exists( $save_acf_fields ) ) {
	require $save_acf_fields;
}

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
