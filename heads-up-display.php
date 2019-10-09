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

//general includes
require_once plugin_dir_path( __FILE__ ) . 'core-functions.php';



// register plugin settings
function headsup_register_settings() {


	register_setting(
		'headsup_options',
		'headsup_options',
		'headsup_callback_validate_options'
	);

  add_settings_section(
    'headsup_section_1',
    'Choose where Heads Up is displayed',
    'headsup_callback_section_1',
    'headsup'
  );



  add_settings_field(
    'display_location',
    'Display Location',
    'headsup_callback_field_radio',
    'headsup',
    'headsup_section_1',
    [ 'id' => 'display_location', 'label' => 'Custom display location' ]
  );

}

add_action( 'admin_init', 'headsup_register_settings' );




// callback: login section
function headsup_callback_section_1() {
	echo '<p>This setting allows you to choose where the heads up display is located.</p>';
}



// default plugin options
function headsup_options_default() {
	return array(
		'display_location' => 'Custom display location',
	);
}




// callback: radio field
function headsup_callback_field_radio( $args ) {
  $options = get_option( 'headsup_options', headsup_options_default() );

  $id    = isset( $args['id'] )    ? $args['id']    : '';
  $label = isset( $args['label'] ) ? $args['label'] : '';

  $selected_option = isset( $options[$id] ) ? sanitize_text_field( $options[$id] ) : '';

  $radio_options = array(

    'option 1'  => 'Locate display in option 1',
    'option 2' => 'Locate display in option 2'
  );

	foreach ( $radio_options as $value => $label ) {

		$checked = checked( $selected_option === $value, true, false );

		echo '<label><input name="myplugin_options['. $id .']" type="radio" value="'. $value .'"'. $checked .'> ';
		echo '<span>'. $label .'</span></label><br />';

	}
}




// validate plugin settings
function headsup_validate_options($input) {
	// todo: add validation functionality..
	return $input;
}
