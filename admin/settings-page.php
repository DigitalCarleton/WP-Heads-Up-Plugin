<?php // Creates settings page


// exit if file is called directly
if (!defined('ABSPATH')) {
  exit;
}

function headsup_add_settings_page() {
	add_options_page( 'Headsup plugin page', 'Headsup Plugin Menu', 'manage_options', 'headsup_plugin', 'headsup_display_settings_page' );
}    
add_action( 'admin_menu', 'headsup_add_settings_page' );

function headsup_display_settings_page() {
	// check if user is allowed access
	if ( ! current_user_can( 'manage_options' ) ) return;
	?>
	<!-- Settings page display -->
	<h1>Headsup Plugin Settings</h1>
		<form action="options.php" method="post">
			<?php 
			settings_fields( 'headsup_options' );
			do_settings_sections( 'headsup_plugin' ); 
			?>
			<input name="submit" class="button button-primary" type="submit" value="<?php esc_attr_e( 'Save' ); ?>" />
		</form>
		<?php
}

function headsup_plugin_section_text() {
	echo '<p>Choose the font style and display location</p>';
}

// register plugin settings
function headsup_register_settings() {
	register_setting( 'headsup_options', 'headsup_options', 'headsup_callback_validate_options' );

	add_settings_section( 'api_settings', 'Display Options', 'headsup_plugin_section_text', 'headsup_plugin' );

	add_settings_field(
		'headsup_callback_font',
		'Font Style',
		'headsup_callback_font',
		'headsup_plugin',
		'api_settings',
		[ 'id' => 'font_style', 'label' => 'Custom display location' ]
	);

	add_settings_field(
		'headsup_callback_location',
		'Location',
		'headsup_callback_location',
		'headsup_plugin',
		'api_settings',
		[ 'id' => 'location', 'label' => 'Custom display location' ]
	);
}
add_action( 'admin_init', 'headsup_register_settings' );




// callback: location section
function headsup_callback_section_1() {
	echo '<p>This setting allows you to choose the font style of the heads up display.</p>';
}



// default plugin options
function headsup_options_default() {
	return array(
		'font-style' => 'none',
	);
}




// callback: radio field
function headsup_callback_field_radio( $args ) {
  $options = get_option( 'headsup_options', headsup_options_default() );

  $id    = isset( $args['id'] )    ? $args['id']    : '';
  $label = isset( $args['label'] ) ? $args['label'] : '';

  $selected_option = isset( $options[$id] ) ? sanitize_text_field( $options[$id] ) : '';

  $radio_options = array(

    'None'   => 'Display information without styling.',
    'Bold'   => 'Display information in bold.',
    'Italic' => 'Display information in italics'
  );

	foreach ( $radio_options as $value => $label ) {

		$checked = checked( $selected_option === $value, true, false );

		echo '<label><input name="headsup_options['. $id .']" type="radio" value="'. $value .'"'. $checked .'> ';
		echo '<span>'. $label .'</span></label><br />';

	}
}




// validate plugin settings
function headsup_validate_options($input) {
	// todo: add validation functionality..
	return $input;
}
