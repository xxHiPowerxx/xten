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
		/**
		 * Utility function that gets custom image without link.
		 * @see https://developer.wordpress.org/reference/functions/get_custom_logo/
		 * @param int $custom_logo_id - Custom Logo ID for wp_get_attachment_image()
		 * @return string
		 */
		if ( ! function_exists( 'xten_get_custom_logo' ) ) :
			function xten_get_custom_logo( $custom_logo_id ) {
				if ( $custom_logo_id ) :
					$custom_logo_attr = array(
						'class' => 'custom-logo',
					);
					$image_alt = get_post_meta( $custom_logo_id, '_wp_attachment_image_alt', true );
					if ( empty( $image_alt ) ) :
						$custom_logo_attr['alt'] = get_bloginfo( 'name', 'display' );
					endif;
					return wp_get_attachment_image( $custom_logo_id, 'full', false, $custom_logo_attr );
				endif; // endif ( $custom_logo_id ) :
			}
		endif; // endif ( ! function_exists( 'xten_get_custom_logo' ) ) :

		
		if ( ! function_exists( 'xten_word_wrap' ) ) :
			/**
			 * Utility that simplifies preg_replace.
			 * @see https://www.php.net/manual/en/function.preg-replace.php
			 * @param string $string - The String in which to Search
			 * @param string $word_to_find - the String to find inside the $string.
			 * @param string $wrap_before - The String to place before the $word_to_find.
			 * @param string $wrap_after - The String to place after the $word_to_find.
			 * @return string
			 */
			function xten_word_wrap( $string, $word_to_find, $wrap_before, $wrap_after ) {
				return preg_replace("/($word_to_find)/", "$wrap_before$1$wrap_after", $string);
			}
		endif; // endif ( ! function_exists( 'xten_word_wrap' ) ) :
	}
}

$ob = new XTenUtilities();
$ob->global_utilities();
