<?php

/**
 * Create Options Page
 */
if ( function_exists( 'acf_add_options_page' ) ) {

	acf_add_options_page(
		array(
			'page_title' => 'Site Settings',
			'menu_title' => 'Site Settings',
			'menu_slug'  => 'site-settings',
			'capability' => 'edit_posts',
			'redirect'   => false,
			'position'   => '30',
		)
	);

	acf_add_options_sub_page(
		array(
			'page_title'  => 'Alerts',
			'menu_title'  => 'Alerts',
			'parent_slug' => 'site-settings',
		)
	);

	acf_add_options_sub_page(
		array(
			'page_title'  => 'Footer',
			'menu_title'  => 'Footer',
			'parent_slug' => 'site-settings',
		)
	);
};
