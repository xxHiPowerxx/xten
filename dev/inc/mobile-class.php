<?php
function mobile_body_class( $classes ) {
    if ( wp_is_mobile() ) {
        $classes[] = 'is-mobile';
    } else {
        $classes[] = 'desktop';
    }
    return $classes;
}
add_filter( 'body_class', 'mobile_body_class' );