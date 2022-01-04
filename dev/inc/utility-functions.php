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
		 * Safely Get FileMTime
		 */
		if ( ! function_exists( 'xten_filemtime' ) ) :
			function xten_filemtime($file) {
				if ( file_exists( $file ) ):
					return filemtime( $file );
				endif;
			}
		endif;

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

		if ( ! function_exists( 'xten_wide_tall_image' ) ) :
			/**
			 * Determine if image is wider than tall or vice-versa.
			 * @param int|array $arg - Can be image ID or Size array(width,height).
			 * @return string 'object-fit-cover ' . 'wide' || 'tall' || 'square'.
			 */
			function xten_wide_tall_image( $arg ) {
				if ( ! $arg ) :
					return;
				endif;
				$return_result = 'object-fit-cover ';
				$image_id      = null;
				$size          = null;
				$image_width   = null;
				$image_height  = null;
				if ( is_int( $arg ) ) :
					$image_id = $arg;
				endif;
				if ( is_array( $arg ) ) :
					$size = $arg;
				endif;
				if ( $image_id ) :
					$image_details = wp_get_attachment_image_src( $image_id, 'full' );
					$image_width   = $image_details[1];
					$image_height  = $image_details[2];
				endif;
				if ( $size ) :
					$image_width  = $size[0];
					$image_height = $size[1];
				endif;
				if ( $image_width > $image_height ) :
					$return_result .= 'wide';
				elseif ( $image_width < $image_height ) :
					$return_result .= 'tall';
				else:
					$return_result .= 'square';
				endif;
				return $return_result;
			}
		endif; // if ( ! function_exists( 'xten_wide_tall_image' ) ) :

		if ( ! function_exists( 'xten_get_optimal_image_size' ) ) :
			/**
			 * Get Optimal image size when only one dimension is provided
			 * 
			 * @param int $image_id - Post ID for image.
			 * @param array $size - $size[0] = width and $size[1] = height.
			 * @param array $aspect_ratio - $aspect_ratio[0] = Aspect Ratio Width
			 * $aspect_ratio[1] = Aspect Ratio Height
			 * Desired aspect ratio is used to calculate
			 * the null dimension in $size array. Default is 16/9.
			 * @return array $size_array returns provided $size and calculated $size.
			 */
			function xten_get_optimal_image_size(
				$image_id     = null,
				$size         = array( null, null ),
				$aspect_ratio = array( 16, 9 )
			) {
				if ( ! $image_id || $size === 'full' ) :
					return;
				endif;
				$size_array = array();
				// Get Image dimensions.
				$image_details       = wp_get_attachment_image_src( $image_id, 'full' );
				$image_width         = $image_details[1];
				$image_height        = $image_details[2];
		
				// Determine whether min_height is at least 56.25% of min_width
				$min_width           = $size[0];
				$min_height          = $size[1];
				$aspect_ratio_width  = $aspect_ratio[0];
				$aspect_ratio_height = $aspect_ratio[1];
		
				// If $min_width was provided we need to calculate Height.
				if ( $min_width ) :
					$provided_min_dimension    = $min_width;
					$actual_provided_dimension = $image_width;
					$actual_missing_dimension  = $image_height;
					$aspect_ratio_dividend     = $aspect_ratio_height;
					$aspect_ratio_divisor      = $aspect_ratio_width;
					$provided_dimension_index  = 0;
					$missing_dimension_index   = 1;
				else:
					$provided_min_dimension    = $min_height;
					$actual_provided_dimension = $image_height;
					$actual_missing_dimension  = $image_width;
					$aspect_ratio_dividend     = $aspect_ratio_width;
					$aspect_ratio_divisor      = $aspect_ratio_height;
					$provided_dimension_index  = 1;
					$missing_dimension_index   = 0;
				endif;
				$optimal_provided_dimension  = $actual_provided_dimension;
		
				$aspect_ratio_multiplicand   = $aspect_ratio_dividend / $aspect_ratio_divisor;

				// Whichever value was not provided (height or width) needs to be calculated.
				$calc_missing_dimension      = $provided_min_dimension *
					$aspect_ratio_multiplicand;
		
				$calc_min_missing_dimension  = $calc_missing_dimension /
					$provided_min_dimension *
					$actual_missing_dimension;
		
				$calc_min_provided_dimension = $actual_provided_dimension /
					$actual_missing_dimension *
					$calc_missing_dimension;
		
				if ( $calc_min_provided_dimension <= $provided_min_dimension ) :
					$optimal_missing_dimension = $calc_missing_dimension /
						$calc_min_provided_dimension *
						$provided_min_dimension;
				endif;
		
				$size_array[$provided_dimension_index] = $optimal_provided_dimension;
				$size_array[$missing_dimension_index]  = $optimal_missing_dimension;
		
				return $size_array;
			}
		endif; // endif ( ! function_exists( 'xten_get_optimal_image_size' ) ) :

		if ( ! function_exists( 'xten_add_inline_style' ) ) :
			/**
			 * Add Inline Style
			 *
			 * @param string $selector - Selector for Style Rule
			 * @param array $rule_array - opacity value from customizer.
			 * @param string $validator - optional value for validation checking.
			 * @param string|array $media_query - optional value for Media Query Breakpoint.
			 * @return string $rule - The completed Style Rule.
			 * 
			 */
			function xten_add_inline_style(
				$selector,
				$rule_array,
				$validator = true,
				$media_query = null
			) {
				if ( $validator ) :
					$rule = $selector . '{';
					foreach ( $rule_array as $property => $value ) :
						$rule .=	$property . ':' . $value . ';';
					endforeach;
					$rule .= '}';
					if ( $media_query ) :
						// Check if $media_query is string or array.
						if ( is_array( $media_query ) ) :
							$media_string = '@media ';
							foreach ( $media_query as $single_media_query ) :
								// Check if first $single_media_query.
								if ( $single_media_query === reset( $media_query ) ) :
									$media_string .= '(' . $single_media_query . ')';
								else :
									$media_string .= ' and (' . $single_media_query . ')';
								endif;
							endforeach;
							$media_string .= ') {' .
								$rule .
							'}';
							$rule = $media_string;
						endif;
						if ( is_string( $media_query ) ) :
						$rule = '@media (' . $media_query . ') {' .
											$rule .
										'}';
						endif;
					endif;
					return $rule;
				endif;
			}
		endif; // endif ( ! function_exists( 'xten_add_inline_style' ) ) :

		if ( ! function_exists( 'xten_minify_css' ) ) :
			require_once get_template_directory() . '/inc/minify-css.php';
			$singleQuoteSequenceFinder = new QuoteSequenceFinder('\'');
			$doubleQuoteSequenceFinder = new QuoteSequenceFinder('"');
			$blockCommentFinder = new StringSequenceFinder('/*', '*/');
			/**
			 * Minify CSS
			 *
			 * @param string $css - CSS Rules to be minified
			 * @return string $css - Minified Style.
			 */
			function xten_minify_css( $css ) {
				global $minificationStore, $singleQuoteSequenceFinder, $doubleQuoteSequenceFinder, $blockCommentFinder;
				$css_special_chars = array(
					$blockCommentFinder, // CSS Comment
					$singleQuoteSequenceFinder, // single quote escape, e.g. :before{ content: '-';}
					$doubleQuoteSequenceFinder // double quote
				);
				// pull out everything that needs to be pulled out and saved
				while ( $sequence = getNextSpecialSequence( $css, $css_special_chars ) ) {
					switch ( $sequence->type ) {
						case '/*': // remove comments
							$css = substr( $css, 0, $sequence->start_idx ) . substr( $css, $sequence->end_idx );
							break;
						default: // strings that need to be preservered
						$placeholder = getNextMinificationPlaceholder();
						$minificationStore[$placeholder] = substr( $css, $sequence->start_idx, $sequence->end_idx - $sequence->start_idx );
						$css = substr( $css, 0, $sequence->start_idx ) . $placeholder . substr( $css, $sequence->end_idx );
					}
				}
					// minimize the string
					$css = preg_replace('/\s{2,}/s', ' ', $css);
					$css = preg_replace('/\s*([:;{}])\s*/', '$1', $css);
					$css = preg_replace('/;}/', '}', $css);
					// put back the preserved strings
					if ( $minificationStore !== null ) {
						foreach ( $minificationStore as $placeholder => $original ) {
							$css = str_replace($placeholder, $original, $css);
						}
					}
				return trim($css);
			}
		endif; // endif ( ! function_exists( 'xten_minify_css' ) ) :

		if ( ! function_exists( 'xten_add_inline_style' ) ) :
			/**
			 * Add Inline Style
			 *
			 * @param string $selector - Selector for Style Rule
			 * @param array $rule_array - opacity value from customizer.
			 * @param string $validator - optional value for validation checking.
			 * @param string|array $media_query - optional value for Media Query Breakpoint.
			 * @return string $rule - The completed Style Rule.
			 * 
			 */
			function xten_add_inline_style(
				$selector,
				$rule_array,
				$validator = true,
				$media_query = null
			) {
				if ( $validator ) :
					$rule = $selector . '{';
					foreach ( $rule_array as $property => $value ) :
						$rule .=	$property . ':' . $value . ';';
					endforeach;
					$rule .= '}';
					if ( $media_query ) :
						// Check if $media_query is string or array.
						if ( is_array( $media_query ) ) :
							$media_string = '@media ';
							foreach ( $media_query as $single_media_query ) :
								// Check if first $single_media_query.
								if ( $single_media_query === reset( $media_query ) ) :
									$media_string .= '(' . $single_media_query . ')';
								else :
									$media_string .= ' and (' . $single_media_query . ')';
								endif;
							endforeach;
							$media_string .= ') {' .
								$rule .
							'}';
							$rule = $media_string;
						endif;
						if ( is_string( $media_query ) ) :
						$rule = '@media (' . $media_query . ') {' .
											$rule .
										'}';
						endif;
					endif;
					return $rule;
				endif;
			}
		endif; // endif ( ! function_exists( 'xten_add_inline_style' ) ) :

		if ( ! function_exists( 'xten_color_opacity' ) ) :
			/**
			 * Handle Color Opacity
			 *
			 * @param string $hex - Hex Color
			 * @param string $opacity - Color Opaicty
			 * @return string $color - hex/rgba depending on opacity provided.
			 */
			function xten_color_opacity( $hex, $opacity ) {
				$color = $hex;
				if (
					$hex !== null ||
					$hex !== 'transparent'
				) :
					$color = $opacity < 100 ?
						convert_hex_to_rgb(
							$hex,
							$opacity
						) :
						$hex;
				endif;
				return $color;
			}
		endif; // endif ( ! function_exists( 'xten_color_opacity' ) ) :

		if ( ! function_exists( 'xten_kses_post' ) ) :
			/**
			 * Sanitizes string but leaves support for SVGs.
			 * @param string $string to be sanitized.
			 * @return string Sanitized string with SVG support.
			 */
			function xten_kses_post( $string ) {
				$kses_defaults = wp_kses_allowed_html( 'post' );
				$svg_args = array(
					'svg' => array(
						'class' => true,
						'aria-hidden' => true,
						'aria-labelledby' => true,
						'role' => true,
						'xmlns' => true,
						'width' => true,
						'height' => true,
						'viewbox' => true, // <= Must be lower case!
					),
					'g'     => array( 'fill' => true ),
					'title' => array( 'title' => true ),
					'path'  => array( 'd' => true, 'fill' => true, ),
				);
				$allowed_tags = array_merge( $kses_defaults, $svg_args );
		
				foreach ( $allowed_tags as $key=>$allowed_tag ) :
					$tabindex = array(
						'tabindex' => true,
					);
					$allowed_tags[$key] = array_merge( $allowed_tag, $tabindex );
				endforeach;
		
				return wp_kses( $string, $allowed_tags );
			}
		endif; // endif ( ! function_exists( 'xten_kses_post' ) ) :
		if ( ! function_exists( 'xten_get_reuseable_block' ) ) :
			/**
			 * Gets Reusable Block by String, Post Object, or ID.
			 * @param string|object|int $block - Block Title, Block Post Object, or Block Post ID.
			 * @return string Reusable Block Content.
			 */
			function xten_get_reuseable_block( $block ) {
				if ( is_string( $block ) ) :
					$reuseable_block = get_page_by_title( $block, OBJECT, 'wp_block' );
				elseif ( is_object( $block ) || is_numeric( $block ) ) :
					$reuseable_block = get_post( $block );
				else:
					return false;
				endif;
				$reuseable_block_content = apply_filters( 'the_content', $reuseable_block->post_content );
				return $reuseable_block_content;
			}
		endif; // endif ( ! function_exists( 'xten_get_reuseable_block' ) ) :

		if ( ! function_exists( 'xten_post_custom_css' ) ) :
			function xten_post_custom_css( $css = null ) {
				global $post;
				if ( ! $post ) :
					return;
				endif;
				if ( $css === null ) :
					$css = get_field( 'post_custom_css', false, false );
				endif;

				$min_css = xten_minify_css( $css );

				$inline_style = 'post-' . $post->ID . '-css';
				wp_register_style( $inline_style, false );
				wp_enqueue_style( $inline_style );
				wp_add_inline_style( $inline_style, $min_css );
			}
		endif; // endif ( ! function_exists( 'xten_post_custom_css' ) ) :

		if ( ! function_exists( 'xten_stringify_attrs' ) ) :
			/**
			 * Convert Attributes array into String
			 * 
			 * @param array $attr_array - The Attributes 
			 * @param bool (optional) $sanitize - default = true - Optionally Sanitize Output. 
			 * @return string - The Attributes as name-value pairs for HTML.
			 */
			function xten_stringify_attrs( $attr_array, $sanitize = true ) {
				$attr_string = '';
				foreach ($attr_array as $key => $value) :
					if ( $value !== null ) :
						if ( $sanitize ) :
							$value = esc_attr( $value );
						endif;
						$space = $key !== reset($attr_array) ?
							' ' :
							null;
						$attr_string.= "$space$key='$value'";
					endif;
				endforeach;
				return $attr_string;
			}
		endif; // /endif ( ! function_exists( 'xten_stringify_attrs' ) ) :

		if ( ! function_exists( 'xten_render_component' ) ) :
			/**
			 * Render Markup for Component.
			 * Function will attempt to get required file to render Component
			 * 
			 * @param string $handle name of handle will be used to find correct file.
			 * @param mixed array|string $post_id optional post or array of posts of data being passed.
			 * @return string rendered markup as string.
			 */
			function xten_render_component( $handle, $post_id = null ) {
				$comp_dir  = '/template-parts/components/';
				$file_name = 'component-' . $handle . '.php';
				$comp_dir_file_name = $comp_dir . $file_name;
				$full_file_path = file_exists( get_stylesheet_directory() . $comp_dir_file_name ) ?
					get_stylesheet_directory() . $comp_dir_file_name :
					get_template_directory() . $comp_dir_file_name;
				if ( file_exists( $full_file_path ) ) :
					require_once( $full_file_path );
					$handle_snake_case = str_replace('-', '_', $handle );
					$component_func = 'component_' . $handle_snake_case;
					if ( function_exists( $component_func ) ) :
						return $component_func( $post_id );
					endif;
				endif;
			}
		endif; // endif ( ! function_exists( 'xten_render_component' ) ) :

		if ( ! function_exists( 'xten_register_component_id' ) ) :
			/**
			 * Create Component ID
			 * Function Increments Id based on handle
			 * @param string $handle name of handle.
			 * @return int component id.
			 */
			function xten_register_component_id( $handle ) {
				$GLOBALS['component_ids'] = isset( $GLOBALS['component_ids'] ) ?
					$GLOBALS['component_ids'] :
					array();
				$GLOBALS['component_ids'][$handle] = ! empty( $GLOBALS['component_ids'][$handle] ) ?
					$GLOBALS['component_ids'][$handle] :
					0;
				$GLOBALS['component_ids'][$handle] ++;
				$component_id = $handle . '-' . $GLOBALS['component_ids'][$handle];

				return  $component_id;
			}
		endif; // endif ( ! function_exists( 'xten_register_component_id' ) ) :

		if ( ! function_exists( 'xten_get_color' ) ) :
			/**
			 * Get theme_mod color with global default
			 * 
			 * @param string - $handle - name of theme_mod and associated $GLOBALS['xten_default_colors'].
			 * @return mixed - Value of theme_mod.
			 */
			function xten_get_color( $handle ) {
				return get_theme_mod( $handle, $GLOBALS['xten_default_colors'][$handle] );
			}
		endif; // /endif ( ! function_exists( 'xten_get_color' ) ) :

		if ( ! function_exists( 'xten_snake_to_camel' ) ) :
			function xten_snake_to_camel( $string ) {
				return lcfirst( str_replace( ' ', '', ucwords( str_replace( '_', ' ', $string ) ) ) );
			}
		endif; // endif ( ! function_exists( 'xten_snake_to_camel' ) ) :
		
		if ( ! function_exists( 'xten_camel_to_snake' ) ) :
			function xten_camel_to_snake( $string ) {
				return strtolower( preg_replace( '/(?<!^)[A-Z]/', '_$0', $string) );
			}
		endif; // endif ( ! function_exists( 'xten_camel_to_snake' ) ) :
		
		if ( ! function_exists( 'xten_snake_to_dash' ) ) :
			function xten_snake_to_dash( $string ) {
				return str_replace( '_', '-', $string );
			}
		endif; // endif ( ! function_exists( 'xten_snake_to_dash' ) ) :
		
		if ( ! function_exists( 'xten_dash_to_snake' ) ) :
			function xten_dash_to_snake( $string ) {
				return str_replace( '-', '_', $string );
			}
		endif; // endif ( ! function_exists( 'xten_dash_to_snake' ) ) :

		if ( ! function_exists( 'merge_inner_blocks_with_parent' ) ) :
			/**
			 * Recursively Merge Inner Blocks Array with Parent Array.
			 * 
			 * @param array $blocks - Parent Blocks.
			 * @return array $blocks - Returns Blocks merged with found $block['innerBlocks'].
			 */
			function merge_inner_blocks_with_parent( $blocks ) {
				foreach ( $blocks as $block ) {
					if ( ! empty( $block['innerBlocks'] ) ) {
						// or call the function recursively, to find heading blocks in inner blocks
						$blocks = array_merge( $blocks, merge_inner_blocks_with_parent( $block['innerBlocks'] ) );
					}
				}
				return $blocks;
			}
		endif; // endif ( ! function_exists( 'merge_inner_blocks_with_parent' ) ) :

		if ( ! function_exists( 'check_the_content_for_fancybox' ) ) :
			/**
			 * Check the_content for .fancybox and Load up Fancybox Assets.
			 */
			function check_the_content_for_fancybox( $content ) {
				$blocks_contain_fancybox = false;
				// Find blocks if they exist (particularly re-usable blocks).
				if ( has_blocks( $content ) ) :
					$blocks = parse_blocks( $content );
					$blocks = merge_inner_blocks_with_parent( $blocks );
					foreach ( $blocks as $block ) :
						$block_content = $block['innerHTML'];
						// Reusable blocks have an ['attrs'] called ['ref']
						// Check to see if is Reusable Block.
						if ( $block['attrs']['ref'] ) :
							// If so, get the block content.
							$block_post_object = get_post( $block['attrs']['ref'] );
							$block_content .= $block_post_object->post_content;
						endif;
						if ( strpos( $block_content, 'fancybox' ) ) :
							$blocks_contain_fancybox = true;
							break; // stop looking.
						endif;
					endforeach;
				endif;
		
				// Check if either the Content or the Blocks contain 'fancybox'.
				if (
					strpos( $content, 'fancybox' ) ||
					$blocks_contain_fancybox
				) :
					$handle = 'xten-fancybox-js';
					if ( ! wp_style_is( $handle, 'enqueued' ) ) :
						wp_enqueue_script( $handle );
					endif;
					$handle = 'xten-vendor-fancybox-css';
					if ( ! wp_style_is( $handle, 'enqueued' ) ) :
						wp_enqueue_style( $handle );
					endif;
				endif;
		
				return $content;
			}
			add_filter( 'the_content', 'check_the_content_for_fancybox', 1 );
		endif; // endif ( ! function_exists( 'check_the_content_for_fancybox' ) ) :

		/**
		 * Trim String and use Excerpt apply ellipsis on end.
		 *
		 * @param string $string - String to be trimmed.
		 * @param int $max_words - Number of words before string is trimmed.
		 */
		if ( ! function_exists( 'xten_trim_string' ) ) :
			function xten_trim_string($string, $max_words) {
				$stripped_content = strip_tags( $string );
				$excerpt_length   = apply_filters( 'excerpt_length', $max_words );
				$excerpt_more     = apply_filters( 'excerpt_more', ' [...]' );
				return wp_trim_words( $stripped_content, $excerpt_length, $excerpt_more );
			}
		endif; // endif ( ! function_exists( 'xten_trim_string' ) ) :

		if ( ! function_exists( 'xten_get_post_meta_description' ) ) :
			/**
			 * Get Meta Description, Excerpt, or create an excerpt.
			 * @param obj - $post Post Object
			 * @return string - post Meta Description, Excerpt, or create an excerpt.
			 */
			function xten_get_post_meta_description( $post ) {
				if ( ! $post ) :
					global $post;
				endif;

				$post_id = $post->ID;
				$description = get_post_meta($post_id, '_yoast_wpseo_metadesc', true);

				if ( empty( $description ) ) :
					setup_postdata( $post );
					$meta_id = 'metadescription_17587';
					$xten_seo_description = get_post_meta( $post_id, $meta_id, true );
					$description = ! empty( $xten_seo_description ) ?
						$xten_seo_description :
						null;
				endif;

				if ( empty( $description ) ) :
					$description = $post->post_excerpt;
				endif;

				if ( empty( $description ) ) :
					$description = xten_trim_string(
						$post->post_content,
						30
					);
				endif;

				return $description;
			}
		endif; // endif ( ! function_exists( 'xten_get_post_meta_description' ) ) :

	}
	
}

$ob = new XTenUtilities();
$ob->global_utilities();
