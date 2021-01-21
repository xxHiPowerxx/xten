<?php
/**
 * Template Name: Fixed Hero with Title
 *
 * @package xten
 */

get_header();

wp_print_styles( array( 'xten-content-css' ) ); // Note: If this was already done it will be skipped.
	?>

<?php
$page_id             = get_the_ID();
$page_title          = get_the_title();
$page_featured_image = get_the_post_thumbnail_url();
$id                  = 'page-hero-' . $page_id;

// check if the block has content.
$validation_content        = array();
$page_hero_section_overlay = esc_attr( get_field( 'page_hero_section_overlay' ) ); //dv
$page_hero_section_content = wp_kses_post( get_field( 'page_hero_section_content', false, false ) );

array_push(
	$validation_content,
	$page_hero_section_overlay
);
$validation_content = array_filter( $validation_content );

if ( ! empty( $validation_content ) ) :
	// Start Block Attributes.
	$block_attrs = '';

	// Begin Style Tag.
	$style = '';
	$id_selector = '[data-page-hero-section-id="' . $id . '"]';

	// Hero featured image.
	if ( has_post_thumbnail() ) :
		$style .=
			$id_selector . '.page-hero{' .
			'background-image:url(' . $page_featured_image . ');' .
			'}'
		;
	endif;

	// Hero Overlay selection.
	$page_hero_overlay_color = ' data-page-hero-overlay-color="' . $page_hero_section_overlay . '"';

endif; // endif
	?>

<!--  Page Template  -->
<div class="sizeContent container container-ext main-container">
	<!--  Hero Section  -->
	<div data-page-hero-section-id="<?php echo $id ?>" class="page-hero page-hero-overlay" <?php echo $page_hero_overlay_color; ?>>
		<section class="page-hero-section">
			<div class="container-page-hero-section-content">
				<div class="page-hero-section-content" <?php echo $page_hero_overlay_color; ?>>
					<h1 class="page-hero-title"><?php echo $page_title; ?></h1>
						<?php
					if ( $page_hero_section_content ) :
						echo '<p>' . $page_hero_section_content .'</p>';
					endif;
						?>
				</div>
			</div>
		</section>
	</div>
	<!--  /Hero Section  -->
	<!--  #primary  -->
	<div class="content-area card-style" id="primary">
		<?php
		// Gets Page Content
		while ( have_posts() ) :
			the_post();
			get_template_part( 'template-parts/content-blank', get_post_type() );
		endwhile; // End of the loop.
		?>
	</div><!--  /#primary  -->
</div>
<!--  /Page Template  -->

<?php
	if ( $style ) :
		wp_register_style( $id, false );
		wp_enqueue_style( $id );
		wp_add_inline_style( $id, $style );
	endif;
?>

<?php
wp_enqueue_style('xten-page-hero-css');
get_footer();
