<?php
/**
 * Widget areas.
 *
 * @package xten
 */

/**
 * Register widget area.
 *
 * @link https://developer.wordpress.org/themes/functionality/sidebars/#registering-a-sidebar
 */
function xten_widgets_init() {
	register_sidebar( array(
		'name'          => esc_html__( 'Sidebar', 'xten' ),
		'id'            => 'sidebar-1',
		'description'   => esc_html__( 'Add widgets here.', 'xten' ),
		'before_widget' => '<section id="%1$s" class="widget %2$s card-style">',
		'after_widget'  => '</section>',
		'before_title'  => '<h2 class="widget-title xten-theme-color-bg">',
		'after_title'   => '</h2>',
	));

	register_sidebar( array(
		'name'          => esc_html__( 'Footer Column 1', 'xten' ),
		'id'            => 'footer-1',
		'description'   => esc_html__( 'Add Column 1 Footer widgets here.', 'xten' ),
		'before_widget' => '<div id="%1$s" class="widget footer-1 %2$s">',
		'after_widget'  => '</div>',
		'before_title'  => '<h2 class="widget-title xten-theme-color-bg">',
		'after_title'   => '</h2>',
	));

	register_sidebar( array(
		'name'          => esc_html__( 'Footer Column 2', 'xten' ),
		'id'            => 'footer-2',
		'description'   => esc_html__( 'Add Column 2 Footer widgets here.', 'xten' ),
		'before_widget' => '<div id="%1$s" class="widget footer-2 %2$s">',
		'after_widget'  => '</div>',
		'before_title'  => '<h2 class="widget-title xten-theme-color-bg">',
		'after_title'   => '</h2>',
	));

	register_sidebar( array(
		'name'          => esc_html__( 'Footer Column 3', 'xten' ),
		'id'            => 'footer-3',
		'description'   => esc_html__( 'Add Column 3 Footer widgets here.', 'xten' ),
		'before_widget' => '<div id="%1$s" class="widget footer-3 %2$s">',
		'after_widget'  => '</div>',
		'before_title'  => '<h2 class="widget-title xten-theme-color-bg">',
		'after_title'   => '</h2>',
	));

	register_sidebar( array(
		'name'          => esc_html__( 'Footer Column 4', 'xten' ),
		'id'            => 'footer-4',
		'description'   => esc_html__( 'Add Column 4 Footer widgets here.', 'xten' ),
		'before_widget' => '<div id="%1$s" class="widget footer-4 %2$s">',
		'after_widget'  => '</div>',
		'before_title'  => '<h2 class="widget-title xten-theme-color-bg">',
		'after_title'   => '</h2>',
	));

	register_sidebar( array(
		'name'          => esc_html__( '404 Widget Left', 'xten' ),
		'id'            => 'error-404-left',
		'description'   => esc_html__( 'Add widgets on left column.', 'xten' ),
		'before_widget' => '<div id="%1$s" class="widget %2$s">',
		'after_widget'  => '</div>',
	));

	register_sidebar( array(
		'name'          => esc_html__( '404 Widget Right', 'xten' ),
		'id'            => 'error-404-right',
		'description'   => esc_html__( 'Add widgets on right column.', 'xten' ),
		'before_widget' => '<div id="%1$s" class="widget %2$s">',
		'after_widget'  => '</div>',
	));

	register_sidebar( array(
		'name'          => esc_html__( 'Mobile Menu bottom', 'xten' ),
		'id'            => 'mobile-menu-bottom',
		'description'   => esc_html__( 'Add Content to the bottom of the mobile menu.', 'xten' ),
		'before_widget' => '<div id="%1$s" class="widget %2$s">',
		'after_widget'  => '</div>',
	));
}
add_action( 'widgets_init', 'xten_widgets_init' );