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

add_action('rightnow_end', 'headsup_function');
