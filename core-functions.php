<?php // Main functionality!

// exit if file is called directly
if (!defined('ABSPATH')) {exit;}



function headsup_function($arg) {

  $numPosts = wp_count_posts()->publish;
  $numPages = wp_count_posts('page')->publish;

  echo "Published Posts: " . $numPosts . "<br>";
  echo "Published Pages: " . $numPages . "<br>";

}

add_action('rightnow_end', 'headsup_function');
