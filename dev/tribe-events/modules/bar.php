<?php
/**
 * Events Navigation Bar Module Template
 * Renders our events navigation bar used across our views
 *
 * $filters and $views variables are loaded in and coming from
 * the show funcion in: lib/Bar.php
 *
 * Override this template in your own theme by creating a file at:
 *
 *     [your-theme]/tribe-events/modules/bar.php
 *
 * @package  TribeEventsCalendar
 * @version  4.3.5
 */
?>

<?php

$filters = tribe_events_get_filters();
$views   = tribe_events_get_views();

$current_url = tribe_events_get_current_filter_url();

$xten_theme_color = esc_attr( get_theme_mod( 'xten_theme_color', '#003366' ) );

$style    = '';
$style .= ".navbar-events .dropdown-item.active, .navbar-events .dropdown-item:active {
	background-color: {$xten_theme_color};
  }
";

$style_id = 'xten-tribe-bar-styles';

wp_register_style( $style_id, false );
wp_enqueue_style( $style_id );
wp_add_inline_style( $style_id, $style );

?>

<?php do_action( 'tribe_events_bar_before_template' ); ?>
<div id="tribe-events-bar">

	<form id="tribe-bar-form" class="tribe-clearfix" name="tribe-bar-form" method="post" action="<?php echo esc_attr( $current_url ); ?>">

		<!-- Mobile Filters Toggle -->

		<div id="tribe-bar-collapse-toggle"
		<?php
		if ( count( $views ) == 1 ) {
			?>
			 class="tribe-bar-collapse-toggle-full-width"<?php } ?>>
			<?php printf( esc_html__( 'Find %s', 'the-events-calendar' ), tribe_get_event_label_plural() ); ?><span class="tribe-bar-toggle-arrow"></span>
		</div>

		<!-- Views -->
		<?php if ( count( $views ) > 1 ) { ?>
			<div id="tribe-bar-views">
				<div class="tribe-bar-views-inner tribe-clearfix">
					<h3 class="tribe-events-visuallyhidden"><?php esc_html_e( 'Event Views Navigation', 'the-events-calendar' ); ?></h3>
					<label><?php esc_html_e( 'View As', 'the-events-calendar' ); ?></label>
					<select class="tribe-bar-views-select tribe-no-param" name="tribe-bar-view">
						<?php foreach ( $views as $view ) : ?>
							<option <?php echo tribe_is_view( $view['displaying'] ) ? 'selected' : 'tribe-inactive'; ?> value="<?php echo esc_attr( $view['url'] ); ?>" data-view="<?php echo esc_attr( $view['displaying'] ); ?>">
								<?php echo $view['anchor']; ?>
							</option>
						<?php endforeach; ?>
					</select>
				</div>
				<!-- .tribe-bar-views-inner -->
			</div><!-- .tribe-bar-views -->
		<?php } // if ( count( $views ) > 1 ) ?>

		<?php if ( ! empty( $filters ) ) { ?>
			<div class="tribe-bar-filters">
				<div class="tribe-bar-filters-inner tribe-clearfix">
					<?php foreach ( $filters as $filter ) : ?>
						<div class="<?php echo esc_attr( $filter['name'] ); ?>-filter">
							<label class="label-<?php echo esc_attr( $filter['name'] ); ?>" for="<?php echo esc_attr( $filter['name'] ); ?>"><?php echo $filter['caption']; ?></label>
							<?php echo $filter['html']; ?>
						</div>
					<?php endforeach; ?>
					<div class="tribe-bar-submit">
						<input class="tribe-events-button tribe-no-param" type="submit" name="submit-bar" value="<?php printf( esc_attr__( 'Find %s', 'the-events-calendar' ), tribe_get_event_label_plural() ); ?>" />
					</div>
					<!-- .tribe-bar-submit -->
				</div>
				<!-- .tribe-bar-filters-inner -->
			</div><!-- .tribe-bar-filters -->
		<?php } // if ( !empty( $filters ) ) ?>

	</form>
	<!-- #tribe-bar-form -->



	<?php
	// Custom Navbar for Categories and Venues
	$categories = get_terms(
		array(
			'taxonomy' => 'tribe_events_cat',
			'hide_empty' => false,
		)
	);
	$queried_object = get_queried_object();

	$slug = isset( $queried_object->slug ) ? $queried_object->slug : null;

	$category_links = '';

	if ( count( $categories ) >= 1 ) :
		foreach ( $categories as $category ) {
			$selected = $slug == $category->slug ? 'active' : '';
			$category_links .= '<a class="dropdown-item ' . $selected . '" href="' . get_site_url(). '/events/category/' . $category->slug . '">' . $category->name . '</a>';
		}
	endif;


	$venues = tribe_get_venues();

	$venue_links = '';

	if ( count( $venues ) >= 1 ) :
		foreach ( $venues as $venue ) {
			$venue_links .= '<a class="dropdown-item" href="' . get_permalink( $venue->ID ) . '">' . $venue->post_title . '</a>';
		}
	endif;
	
	?>

	<?php 
	if ( $category_links || $venue_links ) :
	?>

		<!-- Venue & Category Nav -->
		<nav class="navbar navbar-events navbar-expand navbar-light">
			<div class="navbar-collapse collapse show" id="navbarNavDropdown">
				<ul class="navbar-nav">
					<?php 
						if ( $category_links ) :
					?>
					<li class="nav-item dropdown <?php echo $slug !== null ? 'active' : ''; ?>">
						<a class="nav-link dropdown-toggle" href="#" id="categoriesMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
							Categories
						</a>
						<div class="dropdown-menu" aria-labelledby="categoriesMenuLink">
						<?php
							echo $category_links;
						?>
						</div>
					</li>
					<?php 
						endif;
					?>
					<?php 
						if ( $venue_links ) :
					?>
					<li class="nav-item dropdown">
						<a class="nav-link dropdown-toggle" href="#" id="venueMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
							Venues
						</a>
						<div class="dropdown-menu" aria-labelledby="venueMenuLink">
						<?php
							echo $venue_links;
						?>
						</div>
					</li>
					<?php 
						endif;
					?>
				</ul>
			</div>
		</nav>
	<?php
	endif;
	?>

</div><!-- #tribe-events-bar -->
<?php
do_action( 'tribe_events_bar_after_template' );
