<?php // Main functionality!

// exit if file is called directly
if (!defined('ABSPATH')) {exit;}



function headsup_function($arg) {

  $numPosts = wp_count_posts()->publish;
  $numPages = wp_count_posts('page')->publish;

  $styleInfo = get_option('headsup_options')['font_style'];
  $styling = ['None' => ['',''], 'Bold' => ['<b>','</b>'], 'Italic' => ['<i>','</i>']];

  echo "{$styling[$styleInfo][0]}Published Posts: " . $numPosts . "{$styling[$styleInfo][1]}<br>";
  echo "{$styling[$styleInfo][0]}Published Pages: " . $numPages . "{$styling[$styleInfo][1]}<br>";

}

add_action('rightnow_end', 'headsup_function');
