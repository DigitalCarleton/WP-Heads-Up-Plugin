<?php // Main functionality!

// exit if file is called directly
if (!defined('ABSPATH')) {exit;}



function headsup_function($arg) {

  $numPosts = wp_count_posts()->publish;
  $numPages = wp_count_posts('page')->publish;
  $numComments = wp_count_comments()->total_comments;
  $recentPosts = wp_get_recent_posts();

  $styleInfo = get_option('headsup_options')['font_style'];
  $styling = ['None' => ['',''], 'Bold' => ['<b>','</b>'], 'Italic' => ['<i>','</i>']];

  echo "{$styling[$styleInfo][0]}Published Posts: " . $numPosts . "{$styling[$styleInfo][1]}<br>";
  echo "{$styling[$styleInfo][0]}Published Pages: " . $numPages . "{$styling[$styleInfo][1]}<br>";
  echo "{$styling[$styleInfo][0]}Total Comments: " . $numComments . "{$styling[$styleInfo][1]}<br>";
  echo "{$styling[$styleInfo][0]}Most Recent Post: " . date( 'jS F, Y', strtotime( $recentPosts[0]['post_date'] ) ) . "{$styling[$styleInfo][1]}<br>";
}

/**
 * Add a new dashboard widget.
 */
function wpdocs_add_dashboard_widgets() {
  wp_add_dashboard_widget( 'dashboard_widget', 'Heads Up Display Extension', 'headsup_function' );
}

/**
 * Formats display of information on the main page
 */
function main_page_display() {
  ?>
  <div style="margin-left:2.75%; font-size:15px; margin-top:1%; margin-bottom:1%;">
    <?php headsup_function() ?>
  </div>
<?php
}

/**
 * Chooses where to display plugin content
 */
function display_content() {
  $locationInfo = get_option('headsup_options')['location'];
  switch ($locationInfo) {
    case "At a glance":
      add_action( 'rightnow_end', 'headsup_function' );
      break;
    case "Heads Up Widget":
      add_action( 'wp_dashboard_setup', 'wpdocs_add_dashboard_widgets' );
      break;
    case "Main page":
      add_action( 'wp_head', 'main_page_display' );
      break;
    default:
      add_action( 'rightnow_end', 'headsup_function' );
  }
}

display_content();
