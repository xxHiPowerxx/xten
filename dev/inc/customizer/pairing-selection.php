<?php
/**
 * XTen Font Selection
 *
 * @package xten
 */

$pairing_selection = array(
	json_encode(
		array(
			'heading'          => 'playfairdisplay',
			'heading_fallback' => 'Arial, sans-serif',
			'body'             => 'sourcesanspro',
			'body_fallback'    => 'Arial, sans-serif',
		)
	) => __( 'Playfair Display, Source Sans Pro', 'xten' ),

	json_encode(
		array(
			'heading'           => 'merriweather',
			'heading_fallback'  => 'Arial, sans-serif',
			'body'              => 'sourcesanspro',
			'body_fallback'     => 'Arial, sans-serif',
		)
	) => __( 'Merriweather Black, Source Sans Pro', 'xten' ),

	json_encode(
		array(
			'heading'           => 'merriweather',
			'heading_fallback'  => 'Arial, sans-serif',
			'body'              => 'muli',
			'body_fallback'     => 'Arial, sans-serif',
		)
	) => __( 'Merriweather Bold, Muli', 'xten' ),
	json_encode(
		array(
			'heading'           => 'abrilfatface',
			'heading_fallback'  => 'Arial, sans-serif',
			'body'              => 'poppins',
			'body_fallback'     => 'Arial, sans-serif',
		)
	) => __( 'Abril Fatface, Poppins', 'xten' ),
	json_encode(
		array(
			'heading'           => 'oswald',
			'heading_fallback'  => 'Arial, sans-serif',
			'body'              => 'lato',
			'body_fallback'     => 'Arial, sans-serif',
		)
	) => __( 'Oswald, Lato', 'xten' ),
	json_encode(
		array(
			'heading'           => 'roboto',
			'heading_fallback'  => 'Arial, sans-serif',
			'body'              => 'opensans',
			'body_fallback'     => 'Arial, sans-serif',
		)
	) => __( 'Roboto, Open Sans', 'xten' ),
);

return $pairing_selection;
