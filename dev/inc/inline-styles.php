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

	// Header
	$xten_header = array();
	// Header Background Color w/ Opacity.
	$xten_header['bg_color']['value'] = esc_attr( get_theme_mod( 'xten_header_bg_color', '#2e528a' ) ) ? : 'transparent';
	$xten_header['bg_color']['opacity'] = esc_attr( get_theme_mod( 'xten_header_bg_color_opacity', '100' ) );
	$xten_header['bg_color']['value'] = xten_color_opacity(
		$xten_header['bg_color']['value'],
		$xten_header['bg_color']['opacity']
	);
	$xten_header['bg_color']['selector'] = '.site-header, .mobile-sidebar-top';
	$header_styles .= xten_add_inline_style(
		$xten_header['bg_color']['selector'],
		array(
			'background-color' => $xten_header['bg_color']['value'],
		)
	);
	// /Header Background Color w/ Opacity.

	// Header Menu Item Color.
	$xten_header['menu_item_color']['value'] = esc_attr( get_theme_mod( 'xten_header_menu_item_color', '#fff' ) ) ? : 'transparent';
	$xten_header['menu_item_color']['selector'] = '.header-search-toggle i, .main-navigation>ul>li>a, .main-navigation>ul>li>span.dropdown,.mobile-toggler';
	$header_styles .= xten_add_inline_style(
		$xten_header['menu_item_color']['selector'],
		array(
			'color' => $xten_header['menu_item_color']['value'],
		)
	);
	// /Header Menu Item Color.

	// Header Sub-Menu Background Color w/ Opacity.
	$xten_header['sub_menu_bg_color']['value'] = esc_attr( get_theme_mod( 'xten_header_sub_menu_bg_color', '#fff' ) ) ? : 'transparent';
	$xten_header['sub_menu_bg_color']['opacity'] = esc_attr( get_theme_mod( 'xten_header_sub_menu_bg_color_opacity', '100' ) );
	$xten_header['sub_menu_bg_color']['value'] = xten_color_opacity(
		$xten_header['sub_menu_bg_color']['value'],
		$xten_header['sub_menu_bg_color']['opacity']
	);
	$xten_header['sub_menu_bg_color']['selector'] = '.main-navigation .sub-menu a';
	$header_styles .= xten_add_inline_style(
		$xten_header['sub_menu_bg_color']['selector'],
		array(
			'background-color' => $xten_header['sub_menu_bg_color']['value'],
		)
	);
	// /Header Sub-Menu Background Color w/ Opacity.

	// Header Sub-Menu Item Color.
	$xten_header['sub_menu_item_color']['value'] = esc_attr( get_theme_mod( 'xten_header_sub_menu_item_color', '#2e528a' ) ) ? : 'transparent';
	$xten_header['sub_menu_item_color']['selector'] = '.main-navigation .sub-menu a';
	$header_styles .= xten_add_inline_style(
		$xten_header['sub_menu_item_color']['selector'],
		array(
			'color' => $xten_header['sub_menu_item_color']['value'],
		)
	);
	// /Header Sub-Menu Item Color.

	// /Header
	
	$xten_link_color      = esc_attr( get_theme_mod( 'xten_link_color', '#007db6' ) );
	$xten_theme_color     = esc_attr( get_theme_mod( 'xten_theme_color', '#003366' ) );
	$primary_font_family  = json_decode( get_theme_mod( 'primary_font_family', '{"type":"google", "value":"opensans", "serif":"sans-serif"}' ) );
	$secondary_font_family = json_decode( get_theme_mod( 'secondary_font_family', '{"heading":"roboto", "heading_fallback":"Arial, sans-serif"}' ) );


	// /Header Mobile Nav.
	// Begin Style Tag.
	$styles     = '';
	$body_styles = '';

	// Load Fonts Used.
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


	if (
		'playfairdisplay' == $secondary_font_path ||
		(
			'merriweather' == $secondary_font_path &&
			'sourcesanspro' == $primary_font_path
		)
	) :
		$font_weight = '-black.ttf';
	else :
		$font_weight = '-bold.ttf';
	endif;

	$styles .= '@font-face{' .
		'font-family:' . $secondary_font_family->value . ';' .
		'font-weight:700;' .
		'src:url(' . $root_dir . '/assets/fonts/' . $secondary_font_path . '/' . $secondary_font_path . $font_weight . ');' .
	'}';

	$body_styles .= '@font-face{' .
		'font-family:' . $primary_font_family->value . ';' .
		'font-weight:400;' .
		'src:url(' . $root_dir . '/assets/fonts/' . $primary_font_path . '/' . $primary_font_path . '.ttf' . ');' .
	'}';

	$body_styles .= '@font-face{' .
		'font-family:' . $primary_font_family->value . ';' .
		'font-weight:700;' .
		'src:url(' . $root_dir . '/assets/fonts/' . $primary_font_path . '/' . $primary_font_path . $font_weight . ');' .
	'}';

	// Assign Styles.
	$styles .= 'h1,.section-heading{' .
		'font-family:' . $secondary_font_w_fallback . ';' .
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

	$styles      .= $header_styles;

	$body_styles .= 'body,button,input,optgroup,select,textarea{' .
		'font-family:' . $primary_font_w_fallback . ';' .
		'}' .
		'h2,h3,h4,h5,h6,.xten-highlight-font{' .
			'font-family:' . $primary_font_w_fallback . ';' .
		'}';

	$load_splash_style = '#load-splash{' .
		'position:fixed;' .
		'height:100%;' .
		'width:100%;' .
		'top:0;' .
		'left:0;' .
		'z-index:99999;' .
		' opacity:1;' .
		'-webkit-transition:all .5s cubic-bezier(.22,.61,.36,1);' .
		'transition:all .5s cubic-bezier(.22,.61,.36,1);' .
		'-webkit-transform:scale(1) translateZ(0);' .
		'transform:scale(1) translateZ(0);' .
		'-webkit-backface-visibility:hidden;' .
		'backface-visibility:hidden;' .
		'-webkit-transform-origin:50%,50%;' .
		'transform-origin:50%,50%;' .
		'cursor:pointer;' .
	'}' .
	'html.no-js #load-splash{' .
		'display:none !important;' .
	'}' .
	'#load-splash{' .
		'display:none;' .
	'}' .
	'#load-splash.unloading,'.
	'#load-splash.loading{' .
		'display:block;' .
	'}' .
	'#load-splash.unloading{' .
		'-webkit-transition-duration: .25s' .
		'transition-duration: .25s' .
	'}'.
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
	'}' .
	'.load-splash-inner > *{' .
		'max-height:50%;' .
		'max-width:50%;' .
	'}' .
	'#load-splash .site-name{' .
		'font-size:8.683vmin;' .
		'color:white;' .
		'text-align:center;' .
		'max-width:100%;' .
		'padding:.5em;' .
		'max-height:none;' .
	'}' .
	'@media (min-width: 576px) {' .
		'#load-splash .site-name{' .
			'font-size:50px;' .
		'}' .
	'}';

	// This function checks to make sure that JS is enabled
	// and removes the "no-js" class from the HTML element.
	ob_start();
	?>
	document.documentElement.classList.remove("no-js");
	<?php
	$styles       = xten_minify_css( $styles );
	$check_for_js = ob_get_clean();

	wp_register_style( 'xten-inline-style', false );
	wp_enqueue_style( 'xten-inline-style', '', 'xten-content-css' );
	wp_add_inline_style( 'xten-inline-style', $styles );
	wp_add_inline_style( 'xten-inline-style', $body_styles );
	wp_add_inline_style( 'xten-inline-style', $load_splash_style );
	wp_register_script( 'xten-inline-script', false );
	wp_enqueue_script( 'xten-inline-script' );
	wp_add_inline_script( 'xten-inline-script', $check_for_js );
}

add_action( 'wp_enqueue_scripts', 'process_inline_css' );
