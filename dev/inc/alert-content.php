<?php

$sitewide_alert_start_date            = get_field( 'sitewide_alert_start_date', 'option' );
$sitewide_alert_end_date              = get_field( 'sitewide_alert_end_date', 'option' );
$sitewide_alert_show_alert_on_session = get_field( 'sitewide_alert_show_alert_on_session', 'option' );
$page_alert_list                      = get_field( 'page_alert_list', 'option' );
$page_id                              = get_the_ID();

// Check if Sitewide Alert Exsists.
if ( have_rows( 'sitewide_alert_message', 'option' ) && $sitewide_alert_start_date && check_in_range( $sitewide_alert_start_date, $sitewide_alert_end_date ) ) :

	// Loop through rows.
	while ( have_rows( 'sitewide_alert_message', 'option' ) ) :
		the_row();
		$bold_entry_text = '';
		$message         = '';
		$content         = '';
		$alert_color     = '';

		// Case: Warming.
		if ( 'warning' === get_row_layout() ) :
			$bold_entry_text = esc_attr( get_sub_field( 'bold_entry_text' ) );
			$message         = wp_kses_post( get_sub_field( 'message' ) );
			$alert_color     = 'alert-warning';
			$content         = '<i class="fas fa-exclamation-circle"></i>';

		// Case: Info.
		elseif ( 'info' === get_row_layout() ) :
			$bold_entry_text = esc_attr( get_sub_field( 'bold_entry_text' ) );
			$message         = wp_kses_post( get_sub_field( 'message' ) );
			$alert_color     = 'alert-info';
			$content         = '<i class="fas fa-info-circle"></i>';

		// Case: Error.
		elseif ( 'error' === get_row_layout() ) :
			$bold_entry_text = esc_attr( get_sub_field( 'bold_entry_text' ) );
			$message         = wp_kses_post( get_sub_field( 'message' ) );
			$alert_color     = 'alert-danger';
			$content         = '<i class="fas fa-exclamation-triangle"></i>';

		endif;

		$sitewide_id = md5( $sitewide_alert_start_date . $message );

		if ( $bold_entry_text ) :
			$content .= " <b>$bold_entry_text</b>";
		endif;

		if ( $message ) :
			$content .= " $message";
		endif;

		// Print Sitewide Alert.
		if ( $sitewide_alert_start_date && $message ) :
			?>
				<div class="xten-alert sitewide-alert alert <?php echo $alert_color; ?> alert-dismissible fade show" role="alert" data-alert-id="<?php echo $sitewide_id ?>" data-alert-persist-sessions="<?php echo $sitewide_alert_show_alert_on_session; ?>">
					<div class="container container-ext"><div class="alert-content"><?php echo $content; ?></div></div>
					<button type="button" class="close" data-dismiss="alert" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>
				</div>
			<?php
		endif;
		// End loop.
	endwhile;

endif;


// Page Alert.
if ( have_rows( 'page_alert_list', 'option' ) ) :

	// Loop through rows.
	while ( have_rows( 'page_alert_list', 'option' ) ) :
		the_row();
		$start_date            = get_sub_field( 'start_date' );
		$end_date              = get_sub_field( 'end_date' );
		$show_alert_on_session = get_sub_field( 'show_alert_on_session' );
		$page_ids              = get_sub_field( 'page_ids' );

		if ( have_rows( 'message' ) && in_array( $page_id, $page_ids ) && $start_date && check_in_range( $start_date, $end_date ) ) :

			// Loop through rows.
			while ( have_rows( 'message' ) ) :
				the_row();
				$bold_entry_text = '';
				$message         = '';
				$content         = '';
				$alert_color     = '';

				// Case: Warming.
				if ( 'warning' === get_row_layout() ) :
					$bold_entry_text = esc_attr( get_sub_field( 'bold_entry_text' ) );
					$message         = wp_kses_post( get_sub_field( 'message' ) );
					$alert_color     = 'alert-warning';
					$content         = '<i class="fas fa-exclamation-circle"></i>';

				// Case: Info.
				elseif ( 'info' === get_row_layout() ) :
					$bold_entry_text = esc_attr( get_sub_field( 'bold_entry_text' ) );
					$message         = wp_kses_post( get_sub_field( 'message' ) );
					$alert_color     = 'alert-info';
					$content         = '<i class="fas fa-info-circle"></i>';

				// Case: Error.
				elseif ( 'error' === get_row_layout() ) :
					$bold_entry_text = esc_attr( get_sub_field( 'bold_entry_text' ) );
					$message         = wp_kses_post( get_sub_field( 'message' ) );
					$alert_color     = 'alert-danger';
					$content         = '<i class="fas fa-exclamation-triangle"></i>';

				endif;

				$alert_id = md5( $start_date . $message );

				if ( $bold_entry_text ) :
					$content .= " <b>$bold_entry_text</b>";
				endif;

				if ( $message ) :
					$content .= " $message";
				endif;

				// Print Page Specific Alert.
				if ( $start_date && $message ) :
					?>
						<div class="xten-alert sitewide-alert alert <?php echo $alert_color; ?> alert-dismissible fade show" role="alert" data-alert-id="<?php echo $alert_id ?>" data-alert-persist-sessions="<?php echo $show_alert_on_session; ?>">
							<div class="container container-ext"><div class="alert-content"><?php echo $content; ?></div></div>
							<button type="button" class="close" data-dismiss="alert" aria-label="Close">
								<span aria-hidden="true">&times;</span>
							</button>
						</div>
					<?php
				endif;

				// End loop.
			endwhile;

		endif;

		// End loop.
	endwhile;
endif;

// Check in date range.
function check_in_range( $start_date, $end_date ) {
	// Convert to timestamp.
	$date     = strtotime( date( 'm/d/Y' ) );
	$start_ts = strtotime( $start_date );
	$end_ts   = strtotime( $end_date ? $end_date : date( 'm/d/Y' ) );

	// Check that user date is between start & end.
	return ( ( $date >= $start_ts ) && ( $date <= $end_ts ) );
}
