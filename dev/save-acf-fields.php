<?php
// Save fields. REMOVE THIS FOR PRODUCTION!
add_filter( 'acf/settings/save_json', 'xten_primary_json_save_point' );

function xten_primary_json_save_point( $path ) {

    // update path
    $path = get_template_directory() . '/acf-json';

    // return
    return $path;
}
