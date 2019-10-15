<?php // Creates settings page


// exit if file is called directly
if (!defined('ABSPATH')) {
  exit;
}

// display the plugin settings page
function headsup_display_settings_page() {

	// check if user is allowed access
	if ( ! current_user_can( 'manage_options' ) ) return;

	?>

	<div class="wrap">
		<h1><?php echo esc_html( get_admin_page_title() ); ?></h1>
		<form action="options.php" method="post">

			<?php

			// output security fields
			settings_fields( 'headsup_options' );

			// output setting sections
			do_settings_sections( 'headsup' );

			// submit button
			submit_button();

			?>

		</form>
	</div>

	<?php

}




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




// callback: location section
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

		echo '<label><input name="headsup_options['. $id .']" type="radio" value="'. $value .'"'. $checked .'> ';
		echo '<span>'. $label .'</span></label><br />';

	}
}




// validate plugin settings
function headsup_validate_options($input) {
	// todo: add validation functionality..
	return $input;
}
