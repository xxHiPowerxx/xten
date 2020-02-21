<?php

/**
 * Detect plugin. For use on Front End only.
 */
include_once( ABSPATH . 'wp-admin/includes/plugin.php' );

if ( is_plugin_active( 'the-events-calendar/the-events-calendar.php' ) ) {
	function xten_tribe_scripts() {
		$theme_variables = array(
			'themeUrl' => get_template_directory_uri(),
		);

		// Tribe Single Template
		$handle = 'xten-tribe-single-js';
		$xten_tribe_single_js = '/js/single-event.js';
		wp_register_script( $handle, get_template_directory_uri() . $xten_tribe_single_js, array( 'xten-vendor-slick-js', 'xten-vendor-arcgis-js' ), filemtime( get_template_directory() . $xten_tribe_single_js ), true );
		wp_localize_script( $handle, 'themeVariables', $theme_variables );

		// Tribe Venue Template
		$handle = 'xten-tribe-venue-js';
		$xten_tribe_venue_js = '/js/venue-event.js';
		wp_register_script( $handle, get_template_directory_uri() . $xten_tribe_venue_js, array( 'xten-vendor-slick-js', 'xten-vendor-arcgis-js' ), filemtime( get_template_directory() . $xten_tribe_venue_js ), true );
		// Localize the script with new data
		wp_localize_script( $handle, 'themeVariables', $theme_variables );

		// Esri Tribe Dep
		$handle = 'xten-vendor-arcgis-css';
		wp_register_style( $handle, 'https://js.arcgis.com/4.9/esri/css/main.css', array() );

		$handle = 'xten-vendor-arcgis-js';
		wp_register_script( $handle, 'https://js.arcgis.com/4.9/', array(), '4.9', true );

		// Slick
		$handle = 'xten-vendor-slick-css';
		wp_register_style( $handle, get_template_directory_uri() . '/lib/slick/slick.css', array(), '1.9.0', 'all' );

		$handle = 'xten-vendor-slick-theme-css';
		wp_register_style( $handle, get_template_directory_uri() . '/lib/slick/slick-theme.css', array(), '1.9.0', 'all' );

		// wp_register_style('string $handle', mixed $src, array $deps, mixed $ver, bol $in_footer );
		$handle = 'xten-vendor-slick-js';
		wp_register_script( $handle, get_template_directory_uri() . '/lib/slick/slick.min.js', array( 'jquery' ), '1.8.0', true );

	}
	add_action( 'wp_enqueue_scripts', 'xten_tribe_scripts' );

	// Changes the text labels for Google Calendar and iCal buttons on a single event page
	remove_action( 'tribe_events_single_event_after_the_content', array( tribe( 'tec.iCal' ), 'single_event_links' ) );
	add_action( 'tribe_events_single_event_after_the_content', 'customized_tribe_single_event_links' );
	function customized_tribe_single_event_links() {
		if ( is_single() && post_password_required() ) {
			return;
		}
		echo '<div class="tribe-events-cal-links">';
		echo '<a class="tribe-events-gcal tribe-events-button btn btn-lg" href="' . tribe_get_gcal_link() . '" title="' . __( 'Add to Google Calendar', 'tribe-events-calendar-pro' ) . '">+ Export To Google</a>';
		echo '<a class="tribe-events-ical tribe-events-button btn btn-lg" href="' . tribe_get_single_ical_link() . '">+ Export to Calendar </a>';
		echo '</div>';
	}


	// Change excerpt size
	function custom_tribe_excerpt_length( $length ) {
		return 26;
	}
	add_filter( 'excerpt_length', 'custom_tribe_excerpt_length', 999 );

	// Updated View Name
	add_filter( 'tribe-events-bar-views', 'rename_tribe_views_in_selector', 100 );
	
	function rename_tribe_views_in_selector( $views ) {
		// This lists the original view names you wish to change along
		// with the substitutes to wish to use in their place
		$to_change = array(
			'Photo' => 'Grid',
		);
	
		// Look through the list of active views and modify names accordingly
		foreach ( $views as &$view )
			if ( isset( $to_change[ $view['anchor'] ] ) )
				$view['anchor'] = $to_change[ $view['anchor'] ];
	
		// Return our revised list
		return $views;
	}


	// TODO: Require Featured Image
	

}
