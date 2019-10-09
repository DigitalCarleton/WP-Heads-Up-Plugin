<?php //Adds sublevel menu page


// exit if file is called directly
if (!defined('ABSPATH')) {
  exit;
}

// add sub-level administrative menu
function headsup_add_sublevel_menu() {

	/*

	add_submenu_page(
		string   $parent_slug,
		string   $page_title,
		string   $menu_title,
		string   $capability,
		string   $menu_slug,
		callable $function = ''
	);

	*/

	add_submenu_page(
		'plugins.php',
		'Heads Up Display Settings',
		'Heads Up Display',
		'manage_options',
		'heads-up-display',
		'headsup_display_settings_page'
	);

}
add_action( 'admin_menu', 'headsup_add_sublevel_menu' );
