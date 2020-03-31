<?php
/*
	Plugin Name: SB Social Profile Widget
	Plugin URI: http://designmodo
	Description: Links to Site social media profile
	Author: Agbonghama Collins
	Author URI: http://designmodo.com
 */

/**
 * Adds SB_Social_Profile widget.
 */
class SB_Social_Profile extends WP_Widget {

		/**
		 * Register widget with WordPress.
		 */
		function __construct() {
				parent::__construct(
					'SB_Social_Profile',
					__('Social Network Profiles', 'xten'), // Name
					array('description' => __('Links to Site social media profile', 'xten'),)
				);
		}

		/**
		 * Front-end display of widget.
		 *
		 * @see WP_Widget::widget()
		 *
		 * @param array $args     Widget arguments.
		 * @param array $instance Saved values from database.
		 */
		public function widget($args, $instance) {

			$facebook  = $instance['facebook'];
			$twitter   = $instance['twitter'];
			$youtube   = $instance['youtube'];
			$instagram = $instance['instagram'];
			$linkedin  = $instance['linkedin'];

			// social profile link
			$facebook_profile  = '<a class="facebook" target="_blank" aria-label="Visit Our Facebook Page" href="' . $facebook . '"><i aria-hidden="true" class="fab fa-facebook-square" title="Visit Our Facebook Page"></i><span class="sr-only">Visit Our Facebook Page</span></a>';
			$twitter_profile   = '<a class="twitter" target="_blank" aria-label="Visit Our Twitter Profile" href="' . $twitter . '"><i aria-hidden="true" class="fab fa-twitter-square" title="Visit Our Twitter Profile"></i><span class="sr-only">Visit Our Twitter Profile</span></a>';
			$youtube_profile   = '<a class="youtube" target="_blank" aria-label="Visit Our Youtube Channel" href="' . $youtube . '"><i aria-hidden="true" class="fab fa-youtube" title="Visit Our Youtube Channel"></i><span class="sr-only">Visit Our Youtube Channel</span></a>';
			$instagram_profile = '<a class="instagram" target="_blank" aria-label="Visit Our Instagram Account" href="' . $instagram . '"><i aria-hidden="true" class="fab fa-instagram" title="Visit Our Instagram Account"></i><span class="sr-only">Visit Our Instagram Account</span></a>';
			$linkedin_profile  = '<a class="linkedin" target="_blank" aria-label="Visit Our Linkedin Profile" href="' . $linkedin . '"><i aria-hidden="true" class="fab fa-linkedin" title="Visit Our Linkedin Profile"></i><span class="sr-only">Visit Our Linkedin Profile</span></a>';

			echo $args['before_widget'];

			echo '<div class="social-icons">';
			echo (!empty($facebook) ) ? $facebook_profile : null;
			echo (!empty($twitter) ) ? $twitter_profile : null;
			echo (!empty($youtube) ) ? $youtube_profile : null;
			echo (!empty($instagram) ) ? $instagram_profile : null;
			echo (!empty($linkedin) ) ? $linkedin_profile : null;
			echo '</div>';

			echo $args['after_widget'];
		}

		/**
		 * Back-end widget form.
		 *
		 * @see WP_Widget::form()
		 *
		 * @param array $instance Previously saved values from database.
		 */
		public function form($instance) {
			$facebook  = isset($instance['facebook']) ? $instance['facebook'] : 'https://www.facebook.com/SanBernardinoXTen/';
			$twitter   = isset($instance['twitter']) ? $instance['twitter'] : 'https://twitter.com/xten';
			$youtube   = isset($instance['youtube']) ? $instance['youtube'] : 'https://www.youtube.com/user/xtenPIO';
			$instagram = isset($instance['instagram']) ? $instance['instagram'] : 'https://www.instagram.com/xten/';
			$linkedin  = isset($instance['linkedin']) ? $instance['linkedin'] : 'https://www.linkedin.com/company/xten';
		?>
			<p>
				<label for="<?php echo $this->get_field_id('facebook'); ?>"><?php _e('Facebook:'); ?></label> 
				<input class="widefat" id="<?php echo $this->get_field_id('facebook'); ?>" name="<?php echo $this->get_field_name('facebook'); ?>" type="text" value="<?php echo esc_attr($facebook); ?>">
			</p>

			<p>
				<label for="<?php echo $this->get_field_id('twitter'); ?>"><?php _e('Twitter:'); ?></label> 
				<input class="widefat" id="<?php echo $this->get_field_id('twitter'); ?>" name="<?php echo $this->get_field_name('twitter'); ?>" type="text" value="<?php echo esc_attr($twitter); ?>">
			</p>

			<p>
				<label for="<?php echo $this->get_field_id('youtube'); ?>"><?php _e('Youtube:'); ?></label> 
				<input class="widefat foobar" id="<?php echo $this->get_field_id('youtube'); ?>" name="<?php echo $this->get_field_name('youtube'); ?>" type="text" value="<?php echo esc_attr($youtube); ?>">
			</p>

			<p>
				<label for="<?php echo $this->get_field_id('instagram'); ?>"><?php _e('Instagram:'); ?></label> 
				<input class="widefat" id="<?php echo $this->get_field_id('instagram'); ?>" name="<?php echo $this->get_field_name('instagram'); ?>" type="text" value="<?php echo esc_attr($instagram); ?>">
			</p>

			<p>
				<label for="<?php echo $this->get_field_id('linkedin'); ?>"><?php _e('Linkedin:'); ?></label> 
				<input class="widefat" id="<?php echo $this->get_field_id('linkedin'); ?>" name="<?php echo $this->get_field_name('linkedin'); ?>" type="text" value="<?php echo esc_attr($linkedin); ?>">
			</p>

			<?php
		}

		/**
		 * Sanitize widget form values as they are saved.
		 *
		 * @see WP_Widget::update()
		 *
		 * @param array $new_instance Values just sent to be saved.
		 * @param array $old_instance Previously saved values from database.
		 *
		 * @return array Updated safe values to be saved.
		 */
		public function update($new_instance, $old_instance) {
				$instance = array();
				$instance['title']     = (!empty($new_instance['title']) ) ? strip_tags($new_instance['title']) : '';
				$instance['facebook']  = (!empty($new_instance['facebook']) ) ? strip_tags($new_instance['facebook']) : '';
				$instance['twitter']   = (!empty($new_instance['twitter']) ) ? strip_tags($new_instance['twitter']) : '';
				$instance['youtube']   = (!empty($new_instance['youtube']) ) ? strip_tags($new_instance['youtube']) : '';
				$instance['instagram'] = (!empty($new_instance['instagram']) ) ? strip_tags($new_instance['instagram']) : '';
				$instance['linkedin']  = (!empty($new_instance['linkedin']) ) ? strip_tags($new_instance['linkedin']) : '';

				return $instance;
		}
	}

// register SB_Social_Profile widget
function register_designmodo_social_profile() {
		register_widget('SB_Social_Profile');
}

add_action('widgets_init', 'register_designmodo_social_profile');