<?php
/**
 * XTen New Fields in Customizer
 *
 * @package xten
 */

/**
 * Add support for New Fields in Customizer.
 *
 * @param WP_Customize_Manager $wp_customize New Fields Customizer object.
 */
function xten_customize_new_fields_register( $wp_customize ) {

	if ( class_exists( 'WP_Customize_Control' ) && ! class_exists( 'Prefix_Custom_Content' ) ) :
		/**
		 * Allow Custom HTML in customizer
		 */
		class Prefix_Custom_Content extends WP_Customize_Control {
			/**
			 * Whitelist content parameter.
			 *
			 *  @var content
			 */
			public $content = '';

			/**
			 * Render the control's content.
			 *
			 * Allows the content to be overriden without having to rewrite the wrapper.
			 *
			 * @since   1.0.0
			 * @return  void
			 */
			public function render_content() {
				if ( isset( $this->label ) ) {
						echo '<span class="customize-control-title">' . $this->label . '</span>';
				}
				if ( isset( $this->content ) ) {
						echo $this->content;
				}
				if ( isset( $this->description ) ) {
						echo '<span class="description customize-control-description">' . $this->description . '</span>';
				}
			}
		}
	endif;

	/**
	 * Range Customizer Control.
	 */
	if ( class_exists( 'WP_Customize_Control' ) ) :
		class WP_Customize_Range_Control extends WP_Customize_Control {
			public $type = 'range';
			public function render_content() {

				// Set Default 'min' 'max' and 'units'.
				$min         = '0';
				$max         = '100';
				$unit        = '%';
				$input_attrs = $this->input_attrs;
				if ( $input_attrs ) :
					$min  = $input_attrs['min'];
					$max  = $input_attrs['max'];
					$unit = $input_attrs['unit'];
				endif;
				$min_max = 'min="' . $min . '" max="' . $max . '"';
				?>
				<label>
					<script>
					$(document).on('ready', function(){
						if(window.updateTextInputFunctions === undefined) {
							/**
								* Update Range Text Input's siblings.
								*/

							// Will use changeFromTextInput to prevent recursion in the text input triggering the range input.
							var changeFromTextInput;
							function updateTextInput(tar) {
								if (changeFromTextInput !== true) {
									var updateTextTar = tar.closest('.updateTextInputParent' ).find('.updateTextInputTar');
									updateTextTar.val(tar.val());
								}
								changeFromTextInput = false;
							}
							function updateRangeInput(tar) {
								// return;
								var updateRangeTar = tar.closest('.updateRangeInputParent' ).find('.updateRangeInputTar');
								var min = parseFloat( updateRangeTar.attr('min') );
								parseFloat( $('thing').css('padding-top') );
								var max = parseFloat( updateRangeTar.attr('max') );
								if ( tar.val() >= min && tar.val() <= max ) {
									updateRangeTar.val(tar.val());
								} else if ( tar.val() < min ) {
									updateRangeTar.val(min);
								} else if ( tar.val() > max ) {
									updateRangeTar.val(max);
								}
								changeFromTextInput = true;
								updateRangeTar.trigger('change');
							}
							$('.updateTextInput').on('input change', function(){// trigger on input (change for old browsers)
								updateTextInput($(this));
							}).each(function(){// trigger on ready.
								updateTextInput($(this));
							});
							$('.updateRangeInput').on('blur input', function(){// trigger on blur
								updateRangeInput($(this));
							}).on('keydown', function(e){
								if (e.keyCode === 38) {
									this.value++;
									$(this).trigger('input');
								}
								if (e.keyCode === 40) {
									this.value--;
									$(this).trigger('input');
								}
							});
							window.updateTextInputFunctions = true;
						}
					});
					</script>
					<span class="customize-control-title"><?php echo esc_html( $this->label ); ?></span>
					<div class="updateTextInputParent updateRangeInputParent" style="display: flex; flex-flow: row nowrap; align-items: justify-between; font-weight: bold;">
						<input type="range" class="updateTextInput updateRangeInputTar" style="-webkit-flex:1;flex:1;min-width: 70%;"  name="points" <?php echo $min_max; ?> <?php $this->link(); ?>>
						<div id="range-<?php echo esc_attr( $this->id ); ?>" style="text-align: right;"><input type="text" class="updateRangeInput updateTextInputTar"  style="font-size: 13px;max-width: 70%;display: inline-block;" <?php echo esc_attr( $min_max ); ?> > <span><?php echo esc_attr( $unit ); ?></span></div>
					</div>
				</label>
				<?php
			}
		}
	endif;

}
add_action( 'customize_register', 'xten_customize_new_fields_register' );

if ( class_exists( 'WP_Customize_Control' ) ) :
	class WP_Customize_Teeny_Control extends WP_Customize_Control {
		function __construct( $manager, $id, $options ) {
			parent::__construct( $manager, $id, $options );

			global $num_customizer_teenies_initiated;
			$num_customizer_teenies_initiated = empty( $num_customizer_teenies_initiated )
				? 1
				: $num_customizer_teenies_initiated + 1;
		}
		function render_content() {
			global $num_customizer_teenies_initiated, $num_customizer_teenies_rendered;
			$num_customizer_teenies_rendered = empty( $num_customizer_teenies_rendered )
				? 1
				: $num_customizer_teenies_rendered + 1;

			$value = $this->value();
			?>
			<label>
				<span class="customize-text_editor"><?php echo esc_html( $this->label ); ?></span>
				<input id="<?php echo esc_attr( $this->id ); ?>-link" class="wp-editor-area" type="hidden" <?php $this->link(); ?> value="<?php echo esc_textarea( $value ); ?>">
				<?php
				wp_editor( $value, $this->id, array(
					'textarea_name'    => $this->id,
					'media_buttons'    => false,
					'drag_drop_upload' => false,
					'teeny'            => true,
					'quicktags'        => true,
					'textarea_rows'    => 5,
					'wpautop'          => false,
					// MAKE SURE TINYMCE CHANGES ARE LINKED TO CUSTOMIZER.
					'tinymce'          => array(
						'setup' => "function ( editor ) {
							var cb = function () {
								var linkInput = document.getElementById('$this->id-link')
								linkInput.value = editor.getContent()
								linkInput.dispatchEvent( new Event( 'change' ) )
							}
							editor.on( 'Change', cb )
							editor.on( 'Undo', cb )
							editor.on( 'Redo', cb )
							editor.on( 'KeyUp', cb ) // Remove this if it seems like an overkill
						}",
					),
				));
				?>
				</label>
			<?php
			// PRINT THEM ADMIN SCRIPTS AFTER LAST EDITOR.
			if ( $num_customizer_teenies_rendered === $num_customizer_teenies_initiated ) :
				do_action( 'admin_print_footer_scripts' );
			endif;
		}
	}
endif;
