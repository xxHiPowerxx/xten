<?php
/**
 * Single Event Meta (Map) Template
 *
 * Override this template in your own theme by creating a file at:
 * [your-theme]/tribe-events/modules/meta/map.php
 *
 * @package TribeEventsCalendar
 * @version 4.4
 */

wp_enqueue_style( 'xten-vendor-arcgis-css' );
wp_enqueue_script( 'xten-tribe-venue-js' );

$address = '';

if ( tribe_address_exists() ) {
	$address = tribe_get_address() . ' ' . tribe_get_city() . ' ' . tribe_get_region() . ' ' . tribe_get_zip() . ' ' . tribe_get_country();
}
?>

<div class="tribe-events-venue-map">
	<div id="venue-map" data-address="<?php echo $address; ?>"></div>
</div>