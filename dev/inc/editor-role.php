<?php
// Gives editors the abililty to modify menus, widgets and see users.
if ( current_user_can( 'editor' ) && ! is_super_admin() ) :
	$role_object = get_role( 'editor' );
	$role_object->add_cap( 'edit_theme_options' );
	$role_object->add_cap( 'list_users' );

	function hide_menu() {

		// Hide theme selection page
		remove_submenu_page( 'themes.php', 'themes.php' );

		// Hide customize page
		global $submenu;
		unset($submenu['themes.php'][6]);
		unset($submenu['themes.php'][15]);
		unset($submenu['themes.php'][20]);
		unset($submenu['themes.php'][21]);
		unset($submenu['themes.php'][22]);

	}

	add_action( 'admin_head', 'hide_menu' );

endif;
