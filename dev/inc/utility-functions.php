<?php
/**
 * Utility Functions
 *
 * @package xten
 */

/**
 * XTen Utilities
 * Makes Utility functions available throughout theme.
 */
class XTenUtilities {
	/**
	 * Global Utilites
	 * Calls functions to be used globally throughout theme.
	 */
	public function global_utilities() {
		/**
		 * Convert Hex to RGB
		 *
		 * @param string $hex_string hex value from customizer.
		 * @param string $opacity opacity value from customizer.
		 */
		if ( ! function_exists( 'convert_hex_to_rgb' ) ) :
			function convert_hex_to_rgb( $hex_string, $opacity = null ) {
				if ( null !== $opacity ) :
						$opacity = $opacity / 100;
				endif;

				list($r, $g, $b) = sscanf( $hex_string, '#%02x%02x%02x' );
				if ( 0 === $opacity || $opacity ) :
					return "rgba({$r}, {$g}, {$b}, {$opacity})";
				else :
						return "rgb({$r}, {$g}, {$b})";
				endif;
			}
		endif;

		/**
		 * Remove http/https from theme_mod
		 *
		 * @param string $mod_name customizer handle.
		 */
		function get_theme_mod_img($mod_name){
			return str_replace(array('http:', 'https:'), '', get_theme_mod($mod_name));
		}
	}
}

$ob = new XTenUtilities();
$ob->global_utilities();
