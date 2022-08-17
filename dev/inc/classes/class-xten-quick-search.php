<?php
/**
 * XTen Quick Search
 *
 *
 * @package xten
 * @version 1.0
 */

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * XTen Quick Search.
 */
if( ! class_exists('XTenQuickSearch') ) :

	class XTenQuickSearch {

		private static $instance;
		public static $version    = '1.0';
		public static $post_type  = 'any';
		public static $style      = 'classic';
		public static $ajax_style = 'default';

		private function __construct() {
			$this->setup_style();
			$this->hooks();
		}

		/**
		 * Initiator.
		 */
		public static function get_instance() {
			if ( !self::$instance ) :
				self::$instance = new self;
			endif;
			return self::$instance;
		}


		/**
		 * Item Style.
		 */
		public function setup_style() {

			global $xten_options;

			$post_types_list = array( 'post', 'product', 'portfolio' );

			if(
				isset( $xten_options['header-search-limit'] ) &&
				in_array( $xten_options['header-search-limit'], $post_types_list )
			) {
				self::$post_type = esc_attr( $xten_options['header-search-limit'] );
			}

			// Store actual item style.
			// So far, only the product will use the actual style.
			if( 'product' === self::$post_type ) :
				$product_styles = array(
					'classic',
					'text_on_hover',
					'material','minimal'
				);
				$product_style = ( isset( $xten_options['product_style'] ) ) ?
					$xten_options['product_style'] :
					'classic';

				if( in_array( $product_style, $product_styles ) ) :
					self::$style = esc_html($product_style);
				endif;
			endif;

			// AJAX style.
			if( isset( $xten_options['header-ajax-search-style'] ) ) :
				$ajax_styles = array( 'default','extended' );
				if( in_array( $xten_options['header-ajax-search-style'], $ajax_styles ) ) :
					self::$ajax_style = $xten_options['header-ajax-search-style'];
				endif;
			endif;
		}


		/**
		 * Action hooks.
		 */
		public function hooks() {
			add_action( 'wp_ajax_xten_ajax_ext_search_results', array($this, 'get_results' ) );
			add_action( 'wp_ajax_nopriv_xten_ajax_ext_search_results', array($this, 'get_results' ) );
		}

		/**
		 * AJAX callback to load results.
		 */
		public function get_results() {
			if( ! isset( $_POST['search'] ) ) :
				wp_die();
			endif;
			$search_term = sanitize_text_field( $_POST['search'] );
			$search_term = apply_filters( 'get_search_query', $search_term );

			$content = '';

			// Set up query 
			$max_quick_search_results = get_field( 'max_quick_search_results', 'options' ) ? : 6;
			$xten_search_query_args = array(
				'posts_per_page' => $max_quick_search_results,
				'post_status'    => 'publish',
				'ignore_sticky_posts' => true,
				'no_found_rows'  => true,
				'has_password'   => false,
				's'              => $search_term,
				'post_type'      => self::$post_type
			);

			$xten_search_query_args = apply_filters( 'xten_quick_search_query', $xten_search_query_args );

			$search_query = new WP_Query( $xten_search_query_args );

			if( $search_query->have_posts() ) :
				while( $search_query->have_posts() ) :
					$search_query->the_post();

					global $post;

					if( is_callable( array($this, self::$post_type . '_markup') ) ) :
						$content .= call_user_func( array($this, self::$post_type . '_markup'), self::$style, $post );
					endif;
				endwhile;
			endif;

			// Finalize Markup.
			if( !empty($content) ) :
				$content_start = '<div class="xten-search-results-list">';
				$content_end   = '</div>';

				wp_send_json( array(
					'content' => $content_start . $content . $content_end
				) );
			endif;

			wp_die();

		}

		/**
		 * Product Markup when using extended display.
		 */
		public function extended_product_markup( $style, $post ) {

			global $product;

			ob_start();
			?>

			<li <?php wc_product_class( $style, $product ); ?> >

			<?php
			do_action( 'woocommerce_before_shop_loop_item' );
			do_action( 'woocommerce_before_shop_loop_item_title' );

			if( 'classic' === $style ) :
				do_action( 'woocommerce_shop_loop_item_title' );
	 			do_action( 'woocommerce_after_shop_loop_item_title' );
			endif;

			do_action( 'woocommerce_after_shop_loop_item' );

			$content = ob_get_clean();

			$content .= '</li>';

			return $content;

		}

		/**
		 * Simple Markup.
		 */
		public function simple_markup( $post, $post_type = 'post' ) {

			// Skip posts with no name.
			$post_title = get_the_title();
			if( empty( $post_title ) ) :
				return;
			endif;

			ob_start();
			?>
			<div class="listed-search-result">
				<?php

				$cat_markup  = '';
				$categories  = '';
				$permalink   = esc_url( get_permalink() );
				$description = xten_get_post_meta_description();
				$title_attr  = "title=\"View $post_type, $post_title\"";

				// Link start.
				?>
				<a class="anchor-listed-search-result" href="<?php echo $permalink; ?>" <?php echo $title_attr; ?>>
					<?php
					// Categories.
					if( 'any' !== $post_type ) :
						$categories = xten_post_categories();
						// TODO eliminate $cat_markup;
						$cat_markup = $categories;
						// if ( ! empty( $categories ) ) {
						// 	foreach ( $categories as $category ) {
						// 		$cat_markup .= esc_html( $category->name );
						// 		break;
						// 	}
						// 	$cat_markup = trim( $cat_markup );
						// }
					endif; // endif( 'any' !== $post_type ) :

					// Featured Image.
					$featured_image_size = 'medium';
					if( has_post_thumbnail($post) ) :
						$featured_image = get_the_post_thumbnail(
							$post->ID,
							$featured_image_size,
							array(
								'class'=>'search-result-featured-image',
							)
						);
						echo "<div class=\"search-result-featured-image-wrapper\">$featured_image</div>";
					endif; // endif( has_post_thumbnail() ) :
					?>
					<div class="entry-wrapper">
						<div class="entry-header">
							<?php
							if( ! empty( $cat_markup ) ) :
								?>
								<span class="meta meta-category"><?php echo $cat_markup ?></span>;
								<?php
							endif;
							?>
							<h5 class="entry-title"><?php echo $post_title; ?></h5>
							<?php
							// Post type label.
							if( 'any' === $post_type && isset( $post->post_type ) ) :
								$pt_obj = get_post_type_object( $post->post_type );
								if( $pt_obj && isset( $pt_obj->labels->singular_name ) ) :
									?>
									<span class="meta meta-type"><?php echo esc_html( $pt_obj->labels->singular_name ); ?></span>
									<?php
								endif;
							endif;
							?>
						</div>
						<?php if ( $description ) : ?>
							<div class="entry-content">
								<p class="entry-description"><?php echo $description; ?></p>
							</div>
						<?php endif; ?>
					</div>
				</a>
			</div>
			<?php
			$content = ob_get_clean();
			return $content;

		}


		/**
		 * Limited to post types.
		 */
		public function portfolio_markup( $style, $post ) {
			return $this->simple_markup( $post, 'portfolio' );
		}

		public function post_markup( $style, $post ) {
			return $this->simple_markup( $post, 'post' );
		}

		public function any_markup( $style, $post ) {
			return $this->simple_markup( $post, 'any' );
		}

		public function product_markup( $style, $post ) {

			if( 'extended' === self::$ajax_style  ) :
				return $this->extended_product_markup( $style, $post );
			endif;

			return $this->simple_markup( $post, 'product' );

		}

	}

	/**
	 * Initialize the XTenElAssets class
	 */
	XTenQuickSearch::get_instance();

endif; // endif( ! class_exists('XTenQuickSearch') ) :