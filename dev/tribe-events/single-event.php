<?php

/**
 * Single Event Template
 * A single event. This displays the event title, description, meta, and
 * optionally, the Google map for the event.
 *
 * Override this template in your own theme by creating a file at [your-theme]/tribe-events/single-event.php
 *
 * @version 4.6.3
 */
if ( ! defined( 'ABSPATH' ) ) {
	die( '-1' );
}
wp_enqueue_style( 'xten-vendor-arcgis-css' );
wp_enqueue_script( 'xten-tribe-single-js' );

wp_enqueue_style( 'xten-vendor-slick-css' );
wp_enqueue_style( 'xten-vendor-slick-theme-css' );

$events_label_singular = tribe_get_event_label_singular();
$events_label_plural = tribe_get_event_label_plural();

$event_id = get_the_ID();

// Schedule
$start_date = date_create( get_post_meta( $event_id, '_EventStartDate', true ) );
$end_date = date_create( get_post_meta( $event_id, '_EventEndDate', true ) );

// Venue
$venue = tribe_get_venue_details();

$xten_theme_color = esc_attr( get_theme_mod( 'xten_theme_color', '#003366' ) );


$style    = '';

$style .= ".tribe-events-gcal, .tribe-events-ical, .tribe-events-gcal:hover, .tribe-events-ical:hover  {
		background-color:  {$xten_theme_color};
	}
";

$style_id = 'xten-tribe-single-styles';

wp_register_style( $style_id, false );
wp_enqueue_style( $style_id );
wp_add_inline_style( $style_id, $style );

?>

<div id="tribe-events-content" class="tribe-events-single">

	<!-- Notices -->
	<?php tribe_the_notices(); ?>
	<section class="single-event-wrapper">
		<?php
		while ( have_posts() ) :
			the_post();
			?>
			<div id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
				<!-- Event featured image, but exclude link -->
				<figure class="xten-tribe-single-event-image-wrapper" id="xten-tribe-single-event-image-wrapper">
					<?php echo get_the_post_thumbnail( $event_id, array( 1080, 9999 ), array( 'class' => 'rounded' ) ); ?>
				</figure>

				<?php the_title( '<h1 class="tribe-events-single-event-title">', '</h1>' ); ?>

				<div class="row">
					<div class="col-xs-12 col-md-7">
						<!-- Schedule -->
						<div class="xten-tribe-events-schedule xten-tribe-events-meta row">
							<div class="col-auto single-icon">
								<i class="far fa-calendar-alt"></i>
							</div>
							<div class="col schedule">
								<div class="date">
									<?php
									if ( date_format( $start_date, 'Y/m' ) == date_format( $end_date, 'Y/m' ) ) {
										// Same Day
										echo date_format( $start_date, 'D, M d' );
									} else {
										// Multiday
										echo date_format( $start_date, 'D, M d' ) . ' - ' . date_format( $end_date, 'D, F d' );
									}
									?>
								</div>
								<div class="time">
									<?php
										echo date_format( $start_date, 'g:i a' ) . ' - ' . date_format( $end_date, 'g:i a' );
									?>
								</div>
							</div>
						</div>
						<?php
							// Venue
						if ( tribe_address_exists() ) {
							?>
							<div class="xten-tribe-events-venue xten-tribe-events-meta row">
								<div class="col-auto single-icon">
									<i class="fas fa-map-marker-alt"></i>
								</div>
								<div class="meta-content col">
									<div class="name">
									<?php echo $venue['linked_name']; ?>
									</div>
									<div class="address">
									<?php echo $venue['address']; ?>
									</div>
								</div>
							</div>
							<?php
						}
						?>

						<?php
						$cost = tribe_get_cost();
						// Cost
						if ( $cost ) {
							?>
							<div class="xten-tribe-events-meta row">
								<div class="col-auto single-icon">
									<i class="fas fa-dollar-sign"></i>
								</div>
								<div class="meta-content col">
									<div class="cost">
										<p>Cost: $<?php echo esc_attr( $cost ) ?></p>
									</div>
								</div>
							</div>
							<?php
						}
						?>

						<?php
						// Website
						$website = tribe_get_event_website_url();
						if ( $website ) {
							?>
							<div class="xten-tribe-events-meta row">
								<div class="col-auto single-icon">
								<i class="fas fa-globe"></i>
								</div>
								<div class="meta-content col">
									<div class="website">
										<a href="<?php echo esc_url( $website ) ?>" target="_blank"><?php echo esc_url( $website ) ?></a>
									</div>
								</div>
							</div>
							<?php
						}
						?>



						<!-- Event content -->
						<?php do_action( 'tribe_events_single_event_before_the_content' ); ?>
						<div class="tribe-events-single-event-description tribe-events-content">
							<?php the_content(); ?>
						</div>

						<?php
						// Organizers
						$organizers = tribe_get_organizers();
						if ( $organizers ) {
							?>
							<div class="xten-tribe-events-category-organizers row">
								<div class="meta-content col">
									<div class="organizer">
										Organizers:
										<?php
											foreach( $organizers as $organizer) {
												$link = get_permalink( $organizer->ID );
												echo '<a href="' . $link . '">' . $organizer->post_title . '</a>';
												if ($organizer === end($organizers)) {
													echo '';
												} else {
													echo ', ';
												}
											}
										?>
									</div>
								</div>
							</div>
							<?php
						}
						?>

						<?php
						// Categories

						$categories = wp_get_post_terms( $event_id, 'tribe_events_cat' );

						if ( $categories ) {
							?>
							<div class="xten-tribe-events-category-organizers row">
								<div class="meta-content col">
									<div class="categories">
										Categories:
										<?php
											foreach( $categories as $category) {
												echo '<a href="' . get_site_url() . '/events/category/' . $category->slug . '">' . $category->name . '</a>';
												if ($category === end($categories)) {
													echo '';
												} else {
													echo ', ';
												}
											}
										?>
									</div>
								</div>
							</div>
							<?php
						}
						?>

					</div>
					<div class="col-xs-12 col-md-5">
						<?php
							// Venue
						if ( tribe_address_exists() ) {
							$address = tribe_get_address() . ' ' . tribe_get_city() . ' ' . tribe_get_region() . ' ' . tribe_get_zip() . ' ' . tribe_get_country();
							$display_address = tribe_get_address() . ' ' . tribe_get_city() . ' ' . tribe_get_region() . ' ' . tribe_get_zip();
							?>
							<div id="single-event-map" data-address="<?php echo $address; ?>"></div>
							<div><a class="directions-link" target="_blank" href="https://www.google.com/maps/dir//<?php echo str_replace( ' ', '+', $address ); ?>">Directions: <?php echo $display_address; ?></a></div>
							<?php
						}
						?>
					</div>
				</div>
				<!-- .tribe-events-single-event-description -->
				<h2 class="add-event">Add This Event to:</h2>
				<?php do_action( 'tribe_events_single_event_after_the_content' ); ?>

				<?php

				// Get current page URL
				$eventURL = urlencode(get_permalink());

				// Get current page title
				$eventTitle = htmlspecialchars(urlencode(html_entity_decode(get_the_title(), ENT_COMPAT, 'UTF-8')), ENT_COMPAT, 'UTF-8');

				// Get Post Thumbnail for pinterest
				$eventThumbnail = wp_get_attachment_image_src( get_post_thumbnail_id( $event_id ), 'full' );

				// Sharing URL
				$mailURL = 'mailto:?subject='. get_the_title() .'&body='.$eventURL;
				$twitterURL = 'https://twitter.com/intent/tweet?text='.$eventTitle.'&amp;url='.$eventURL;
				$facebookURL = 'https://www.facebook.com/sharer/sharer.php?u='.$eventURL;
				$linkedInURL = 'https://www.linkedin.com/shareArticle?mini=true&url='.$eventURL.'&amp;title='.$eventTitle;
				$pinterestURL = 'https://pinterest.com/pin/create/button/?url='.$eventURL.'&amp;media='.$eventThumbnail[0].'&amp;description='.$eventTitle;

				// Add sharing button at the end of page/page content
				$content = '';
				$content .= '<div class="xten-event-social">';
				$content .= '<h3>Share On:</h3>';
				$content .= '<a class="xten-event-link-social xten-event-mail" href="'. $mailURL .'" target="_blank"><i class="fas fa-envelope xten-share-logo"></i>  Email</a>';
				$content .= '<a class="xten-event-link-social xten-event-twitter" href="'. $twitterURL .'" target="_blank"><i class="fab fa-twitter xten-share-logo"></i>  Twitter</a>';
				$content .= '<a class="xten-event-link-social xten-event-facebook" href="'.$facebookURL.'" target="_blank"><i class="fab fa-facebook xten-share-logo"></i>  Facebook</a>';
				$content .= '<a class="xten-event-link-social xten-event-linkedin" href="'.$linkedInURL.'" target="_blank"><i class="fab fa-linkedin xten-share-logo"></i>  LinkedIn</a>';
				$content .= '<a class="xten-event-link-social xten-event-pinterest" href="'.$pinterestURL.'" data-pin-custom="true" target="_blank"><i class="fab fa-pinterest xten-share-logo"></i>  Pinterest</a>';
				$content .= '</div>';

				echo $content;

				?>

			</div> <!-- #post-x -->
		<?php endwhile; ?>
	</section>
	<section class="other-event-wrapper">


		<?php
			$events = tribe_get_events(
				[
					'posts_per_page' => 9,
					'start_date'     => 'now',
				]
			);

			$events_array = array();
			foreach ( $events as $event ) {
				if ( $event->ID != $event_id ) {
					array_push( $events_array, $event );
				}
			}

			if ( count( $events_array ) > 0 ) :
				?>
				<!-- upcoming Events Slider -->
				<div class="single-event-upcoming-wrapper">
					<h2>Upcoming Events</h2>

					<div class="single-event-upcoming-slider mb-5">
							<!-- upcoming Events -->
							<?php

							// Loop through the events, displaying the title and content for each
							foreach ( $events_array as $event ) {
								// Event
								$link = get_permalink( $event->ID );
								$start_date = date_create( $event->EventStartDate );
								$end_date = date_create( $event->EventEndDate );

								// Venue
								$venue = tribe_get_venue( $event->ID );

								?>
									<div class="upcoming-events-slide">
										<div class="tribe-events-event-image">
											<a href="<?php echo $link; ?>" aria-label="See more of <?php echo $event->post_title; ?>">
												<?php echo get_the_post_thumbnail( $event->ID, array( 300, 169 ), array( 'class' => 'upcoming-event-image' ) ); ?>
											</a>
										</div>
										<a href="<?php echo $link; ?>" aria-label="See more of <?php echo $event->post_title; ?>">
											<h3><?php echo esc_attr( $event->post_title ); ?></h3>
										</a>
										<div class="date-time-venue row">
											<div class="col-auto d-flex flex-column date">
												<span class="day pb-2"><?php echo date_format( $start_date, 'd' ); ?></span>
												<span class="month" style="color:<?php echo $xten_theme_color; ?>"><?php echo date_format( $start_date, 'M' ); ?></span>
											</div>
											<div class="col time-venue">
												<p>
													<?php echo date_format( $start_date, 'g:ia' ) . ' - ' . date_format( $end_date, 'g:ia' ); ?><br />
													<?php echo $venue; ?>
												</p>
											</div>
										</div>
									</div>
								<?php
							}
							?>
					</div>
				</div>
				<?php
			endif;
			?>

		<!-- All Events Links -->
		<p class="xten-tribe-events-back mb-5">
			<a href="<?php echo esc_url( tribe_get_events_link() ); ?>"> <?php printf( esc_html_x( 'View All %s', '%s Events plural label', 'the-events-calendar' ) . ' <i class="fas fa-angle-right"></i>', $events_label_plural ); ?></a>
		</p>
	</section>


</div><!-- #tribe-events-content -->
