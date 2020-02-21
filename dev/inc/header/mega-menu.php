<?php
add_filter( 'wp_nav_menu_objects', 'mega_menu_objects', 10, 2 );

function mega_menu_objects( $items, $args ) {

	// modify primary only.
	if ( $args->theme_location == 'primary' ) :

		// loop through menu items.
		foreach ( $items as &$item ) {

			if ( '0' == $item->menu_item_parent ) :
				$menu_type     = get_field( 'menu_type', $item ) ? get_field( 'menu_type', $item ) : 'flyout';
				$item->classes = array_merge( $item->classes, array( 'menu-type-' . $menu_type ) );

				foreach ( $items as $key => $inner_item ) {
					if ( $item->ID == $inner_item->menu_item_parent && 'mega-menu' == $menu_type ) :
						unset( $items[ $key ] );
					endif;
				}

				$visible_on_desktop = get_field( 'visible_on_desktop', $item );
				$visible_on_mobile  = get_field( 'visible_on_mobile', $item );

				if ( false === $visible_on_desktop ) :
					$item->classes = array_merge( $item->classes, array( 'hidden-desktop' ) );
				endif;

				if ( false === $visible_on_mobile ) :
					$item->classes = array_merge( $item->classes, array( 'hidden-mobile' ) );
				endif;

				if ( 'mega-menu' == $menu_type ) :
					$grid               = get_field( 'grid', $item );

					$unique_id = uniqid();

					if ( 'mobile-menu' === $args->menu_id ) :
						$item->mega_menu_content = "<button class='sub-menu-toggler collapsed' type='button' data-toggle='collapse' data-target='#nav-group-" . $unique_id . "'
						aria-label='Mobile Navigation Submenu nav-group" . $unique_id . "' aria-expanded='false' aria-controls='nav-group-" . $unique_id . "'><span class='fa fa-chevron-down'></span></button><div class='sub-menu mega-sub-menu collapse' id='nav-group-" . $unique_id . "'>";
					else :
						$item->mega_menu_content = '<span class="dropdown fa fa-chevron-down"></span><div class="sub-nav"><div class="inner-sub-nav-wrapper d-flex">';
					endif;

					if ( have_rows( 'grid', $item ) ) :

						// Loop Mega Menu Rows.
						while ( have_rows( 'grid', $item ) ) :
							the_row();
							// vars.
							$visible_on_desktop = get_sub_field( 'visible_on_desktop' );
							$visible_on_mobile  = get_sub_field( 'visible_on_mobile' );
							$column_type        = get_sub_field( 'column_type' );

							$visibility = '';

							if ( false === $visible_on_desktop ) :
								$visibility .= ' hidden-desktop';
								endif;

							if ( false === $visible_on_mobile ) :
								$visibility .= ' hidden-mobile';
								endif;

							$item->mega_menu_content .= '<div class="sub-nav-group ' . $visibility . '">';

							// Mega Menu Column.
							if ( $column_type ) :

								$heading = $column_type[0]['heading'];

								$item->mega_menu_content .= '<div class="column-wrapper ' . ( $heading ? 'has-heading' : '') . '">';

									// Heading.
									if( $heading ) :
										$item->mega_menu_content .= '<span class="mega-menu-heading">' . $heading . '</span>';
									endif;

									// Links.
									if ( $column_type[0]['acf_fc_layout'] == 'links' ) :
										$item->mega_menu_content .= '<ul class="links">';

											foreach($column_type[0]['links'] as $link ) {

												$item->mega_menu_content .= '<li><a href="' . $link['link']['url'] . '" target="' . $link['link']['target'] . '">' . $link['link']['title'] . '</a></li>';
											}
										$item->mega_menu_content .= '</ul>';

									// Wysiwyg.
									elseif ( $column_type[0]['acf_fc_layout'] == 'wysiwyg' ) :
										$item->mega_menu_content .= '<div class="wysiwyg">';
											$item->mega_menu_content .= do_shortcode( wp_kses_post( $column_type[0]['wysiwyg'] ) );
										$item->mega_menu_content .= '</div>';
									endif;

								$item->mega_menu_content .= '</div>'; // close column-wrapper.
							endif;


							$item->mega_menu_content .= '</div>';
							// End loop.
						endwhile;

						// No value.
					else :
						// Do something.
					endif;

					if ( 'mobile-menu' === $args->menu_id ) :
						$item->mega_menu_content .= '</div>'; // close mobile sub-nav and inner wrapper.
					else :
						$item->mega_menu_content .= '</div></div>'; // close desktop sub-nav and inner wrapper.
					endif;
				endif;
			endif;
		}
	endif;

	// return.
	return $items;
}
