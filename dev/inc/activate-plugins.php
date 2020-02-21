<?php
// Include the plugin.php file so you have access to the activate_plugin() function
require_once ABSPATH . '/wp-admin/includes/plugin.php';

$plugin_paths = array('/advanced-custom-fields/acf.php', '/xten-blocks/xten-blocks.php');

foreach( $plugin_paths as &$path ) {
	// Get already-active plugins
	$active_plugins = get_option( 'active_plugins' );

	// Make sure your plugin isn't active
	if ( isset( $active_plugins[ $path ] ) ) {
		return;
	}

	// Activate your plugin
	activate_plugin( $path );
}
