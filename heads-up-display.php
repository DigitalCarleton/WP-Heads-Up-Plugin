<?php
/*
Plugin Name: Heads Up Display
Description: This plugin creates a box displaying basic site information in a configurable location
Author: Chris Padilla, Alvin Bierley
Version: 1.1
*/


// exit if file is called directly
if (!defined('ABSPATH')) {exit;}

// if admin area
if (is_admin()) {
	// include dependencies
	require_once plugin_dir_path( __FILE__ ) . 'admin/admin-menu.php';
	require_once plugin_dir_path( __FILE__ ) . 'admin/settings-page.php';
}

//general includes
require_once plugin_dir_path( __FILE__ ) . 'core-functions.php';
