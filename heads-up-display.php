<?php
/*
Plugin Name: Heads Up Display
Description: This plugin creates a box dislaying the number of posts on the site, in a configurable location
Author: Chris Padilla
Version: 1.0
*/


// exit if file is called directly
if (!defined('ABSPATH')) {exit;}

// if admin area
if (is_admin()) {
	// include dependencies
	require_once plugin_dir_path( __FILE__ ) . 'admin/admin-menu.php';
	require_once plugin_dir_path( __FILE__ ) . 'admin/settings-page.php';
}
