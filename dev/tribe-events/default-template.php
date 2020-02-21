<?php
/**
 * Default Events Template
 * This file is the basic wrapper template for all the views if 'Default Events Template'
 * is selected in Events -> Settings -> Template -> Events Template.
 *
 * Override this template in your own theme by creating a file at [your-theme]/tribe-events/default-template.php
 *
 * @package TribeEventsCalendar
 */

if ( ! defined( 'ABSPATH' ) ) {
	die( '-1' );
}

$xten_theme_color = esc_attr( get_theme_mod( 'xten_theme_color', '#003366' ) );



$style = '';

// Bar Button
$style .= "#tribe-bar-form .tribe-bar-submit input[type=submit]  {
		background:  {$xten_theme_color} !important;
	}
";

// Active Day

$style .= ".tribe-events-calendar td.tribe-events-present div[id*=tribe-events-daynum-], .tribe-events-calendar td.tribe-events-present div[id*=tribe-events-daynum-]>a {
    background-color: {$xten_theme_color} !important;
}";

$style .= "@media screen and (max-width: 768px) {
	.tribe-events-calendar .tribe-events-present, .tribe-events-calendar .tribe-events-present.mobile-active div[id*=tribe-events-daynum-], .tribe-events-calendar .tribe-events-present.mobile-active div[id*=tribe-events-daynum-] a, .tribe-events-calendar td.tribe-events-present.mobile-active {
		background-color: {$xten_theme_color} !important;
	}
	.tribe-events-sub-nav li a {
		background: {$xten_theme_color} !important;
	}
	#tribe-events-content {
		width: auto !important;
	}
}";

// Buttons

$style .= "#tribe-events .tribe-events-button {
	background-color: {$xten_theme_color} !important;
}";

// Tooltip Heading
$style .= "#tribe-events-content .tribe-events-tooltip h4 {
    background-color: {$xten_theme_color} !important;
}";

$style_id = 'xten-tribe-styles';

wp_register_style( $style_id, false );
wp_enqueue_style( $style_id );
wp_add_inline_style( $style_id, $style );


get_header();
?>

<div class="sizeContent container container-ext main-container">
<div id="primary" class="col-12 tribe-events-pg-template card-style">
	<?php tribe_events_before_html(); ?>
	<?php tribe_get_view(); ?>
	<?php tribe_events_after_html(); ?>
</div> <!-- #tribe-events-pg-template -->
</div>
<?php
wp_enqueue_style( 'xten-event-calendar' );
get_footer();
