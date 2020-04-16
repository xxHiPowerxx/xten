<?php

/**
 * Process Inline CSS
 */
function process_inline_css() {

	// Get the Stylesheet Directory.
	$root_dir = get_template_directory_uri();
	// Customizer options
	// Header Mobile Nav.
	$GLOBALS['mobile_nav_breakpoint']  = esc_attr( get_theme_mod( 'mobile_nav_breakpoint', '1100' ) );
	$mobile_nav_breakpoint             = $GLOBALS['mobile_nav_breakpoint'];
	$mobile_nav_main_background_color  = esc_attr( get_theme_mod( 'mobile_nav_main_background_color', '#003366' ) );
	$mobile_nav_font_size              = esc_attr( get_theme_mod( 'mobile_nav_font_size', '2em' ) );
	$mobile_nav_color                  = esc_attr( get_theme_mod( 'mobile_nav_color', '#ffffff' ) );
	$mobile_nav_accent_color           = esc_attr( get_theme_mod( 'mobile_nav_accent_color', '#BA8F20' ) );
	$mobile_nav_secondary_accent_color = esc_attr( get_theme_mod( 'mobile_nav_secondary_accent_color', '#00488B' ) );
	$mobile_nav_background_color       = esc_attr( get_theme_mod( 'mobile_nav_background_color', '#003366' ) );
	$mobile_nav_dropdown_color         = esc_attr( get_theme_mod( 'mobile_nav_dropdown_color', '#003366' ) );

	// Theme Options.
	$xten_link_color      = esc_attr( get_theme_mod( 'xten_link_color', '#007db6' ) );
	$xten_theme_color     = esc_attr( get_theme_mod( 'xten_theme_color', '#003366' ) );
	$heading_default_font = json_decode( get_theme_mod( 'font_pairings', '{"heading":"roboto", "heading_fallback":"Arial, sans-serif"}' ) );
	$body_default_font    = json_decode( get_theme_mod( 'font_pairings', '{"body":"opensans", "body_fallback":"Arial, sans-serif"}' ) );

	// /Header Mobile Nav.
	// Begin Style Tag.
	$styles     = '';
	$bodyStyles = '';

	// Load Fonts Used.
	// Theme Heading Default Font.
	$headingPath             = $heading_default_font->heading;
	$heading_font_w_fallback = $heading_default_font->heading . ',' . $heading_default_font->heading_fallback;
	$bodyPath                = $body_default_font->body;
	$body_font_w_fallback    = $body_default_font->body . ',' . $body_default_font->body_fallback;


	if ( 'playfairdisplay' == $headingPath || ( 'merriweather' == $headingPath && 'sourcesanspro' == $bodyPath ) ) {
		$fontWeight = '-black.ttf';
	} else {
		$fontWeight = '-bold.ttf';
	}

	$styles .= '@font-face{' .
		'font-family:' . $heading_default_font->heading . ';' .
		'font-weight:bold;' .
		'src:url(' . $root_dir . '/assets/fonts/' . $headingPath . '/' . $headingPath . $fontWeight . ');' .
	'}';

	$bodyStyles .= '@font-face{' .
		'font-family:' . $body_default_font->body . ';' .
		'font-weight:normal;' .
		'src:url(' . $root_dir . '/assets/fonts/' . $bodyPath . '/' . $bodyPath . '.ttf' . ');' .
	'}';

	$bodyStyles .= '@font-face{' .
		'font-family:' . $body_default_font->body . ';' .
		'font-weight:bold;' .
		'src:url(' . $root_dir . '/assets/fonts/' . $bodyPath . '/' . $bodyPath . $fontWeight . ');' .
	'}';

	// Assign Styles.
	$styles .= 'h1,.section-heading{' .
		'font-family:' . $heading_font_w_fallback . ';' .
	'}' .
	'.xten-theme-color-bg, .pagination .current, .search-form button:hover{' .
		'background-color:' . $xten_theme_color . ';' .
	'}' .
	'body.user-is-tabbing *:focus, input:focus{' .
		'outline:2px solid ' . $xten_theme_color . ';' .
		'z-index:10;' .
	'}' .
	'.xten-theme-color-text{' .
		'color:' . $xten_theme_color . ';' .
	'}' .
	'@media (min-width:' . $mobile_nav_breakpoint . 'px ){' .
		'.desktop-navigation{' .
			'display:block;' .
		'}' .
		'.header-search-toggle{' .
			'margin-left:0;' .
			'margin-right:0;' .
			'display:block;' .
		'}' .
		'html.nav-open body{' .
			'overflow:auto;' .
		'}' .
		'html.nav-open body #page-wrapper,' .
		'html.nav-open body .site-header,' .
		'html.nav-open body .xten-menu{' .
			'-webkit-transform:translate3d(0, 0, 0);' .
			'transform:translate3d(0, 0, 0);' .
		'}' .
		'html.nav-open body .mobile-sidebar,' .
		'html.nav-open body .close-layer,' .
		'.site-header .mobile-toggler{' .
			'display:none;' .
		'}' .
		'.nav-shrink .site-branding a{' .
			'-webkit-transform-origin:50%;' .
			'transform-origin:50%;' .
		'}' .
	'}';

	$bodyStyles .= 'body,button,input,optgroup,select,textarea{' .
		'font-family:' . $body_font_w_fallback . ';' .
		'}' .
		'h2,h3,h4,h5,h6,.xten-highlight-font{' .
			'font-family:' . $body_font_w_fallback . ';' .
		'}';

	$load_splash_style = '#load-splash{' .
		'position:fixed;height:100%;' .
		'width:100%;' .
		'top:0;' .
		'left:0;' .
		'z-index:9999;' .
		' opacity:1;' .
		'-webkit-transition:all .7s cubic-bezier(.22,.61,.36,1);' .
		'transition:all .7s cubic-bezier(.22,.61,.36,1);' .
		'-webkit-transform:scale(1) translateZ(0);' .
		'transform:scale(1) translateZ(0);' .
		'-webkit-backface-visibility:hidden;' .
		'backface-visibility:hidden;' .
		'-webkit-transform-origin:50%,50%;' .
		'transform-origin:50%,50%;' .
		'cursor:pointer;' .
	'}' .
	'html.no-js #load-splash,' .
	'#load-splash:not(.loading){' .
		'display:none;' .
	'}' .
	'#load-splash.hiding{' .
		'opacity:0;' .
		'background-color:rgb(255,255,255);' .
		'-webkit-transform:scale(0) translateZ(0);' .
		'transform:scale(0) translateZ(0);' .
	'}' .
	'.load-splash-inner{' .
		'height:100%;' .
		'width:100%;' .
		'display:-webkit-box;' .
		'display:-ms-flexbox;' .
		'display:flex;' .
		'-webkit-box-pack:center;' .
		'-ms-flex-pack:center;' .
		'justify-content:center;' .
		'-webkit-box-align:center;' .
		'-ms-flex-align:center;' .
		'align-items:center;' .
	'}';

	// This function checks to make sure that JS is enabled
	// and removes the "no-js" class from the HTML element.
	ob_start();
	?>
	(function checkForJS(){
		document.documentElement.classList.remove('no-js');
	})();
	<?php
	$check_for_js = ob_get_clean();

	wp_register_style( 'xten-inline-style', false );
	wp_enqueue_style( 'xten-inline-style', '', 'xten-content-css' );
	wp_add_inline_style( 'xten-inline-style', $styles );
	wp_add_inline_style( 'xten-inline-style', $bodyStyles );
	wp_add_inline_style( 'xten-inline-style', $load_splash_style );
	wp_register_script( 'xten-inline-script', false );
	wp_enqueue_script( 'xten-inline-script' );
	wp_add_inline_script( 'xten-inline-script', $check_for_js );
}

add_action( 'wp_enqueue_scripts', 'process_inline_css' );
