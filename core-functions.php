<?php // Main functionality!

// exit if file is called directly
if (!defined('ABSPATH')) {exit;}

/**
 * Displays number of posts, pages, comments, and date of most recent post.
 */
function headsup_function() {
  $numPosts = wp_count_posts()->publish;
  $numPages = wp_count_posts('page')->publish;
  $numComments = wp_count_comments()->total_comments;
  $recentPosts = wp_get_recent_posts(
    array(
      'numberposts' => 1,
      'post_status' => 'publish',
    )
  );
  $countUsers = count_users();

  // Safely load options with defaults to avoid undefined index notices.
  $options = get_option(
    'headsup_options',
    array(
      'font_style' => 'None',
      'location'   => 'At a glance',
    )
  );

  $styleInfo = isset($options['font_style']) ? $options['font_style'] : 'None';
  $styling = array(
    'None'   => array('', ''),
    'Bold'   => array('<b>', '</b>'),
    'Italic' => array('<i>', '</i>'),
  );

  // Fallback to no style if saved value is invalid.
  if (!isset($styling[$styleInfo])) {
    $styleInfo = 'None';
  }

  $recentPostDate = 'N/A';
  $recentAuthorUsername = 'N/A';

  // Handle new/empty sites that do not have published posts yet.
  if (!empty($recentPosts) && isset($recentPosts[0])) {
    $recentPost = $recentPosts[0];
    if (!empty($recentPost['post_date'])) {
      $recentPostDate = date('jS F, Y', strtotime($recentPost['post_date']));
    }

    if (!empty($recentPost['post_author'])) {
      $recentAuthor = get_user_by('id', (int) $recentPost['post_author']);
      if ($recentAuthor && isset($recentAuthor->user_login)) {
        $recentAuthorUsername = $recentAuthor->user_login;
      }
    }
  }

  echo "{$styling[$styleInfo][0]}Published Posts: " . esc_html((string) $numPosts) . "{$styling[$styleInfo][1]}<br>";
  echo "{$styling[$styleInfo][0]}Published Pages: " . esc_html((string) $numPages) . "{$styling[$styleInfo][1]}<br>";
  echo "{$styling[$styleInfo][0]}Total Comments: " . esc_html((string) $numComments) . "{$styling[$styleInfo][1]}<br>";
  echo "{$styling[$styleInfo][0]}Most Recent Post: " . esc_html($recentPostDate) . "{$styling[$styleInfo][1]}<br>";
  echo "{$styling[$styleInfo][0]}Most Recent Author: " . esc_html($recentAuthorUsername) . "{$styling[$styleInfo][1]}<br>";
  echo "{$styling[$styleInfo][0]}Total Users: " . esc_html((string) $countUsers['total_users']) . "{$styling[$styleInfo][1]}<br>";
}

/**
 * Add a new dashboard widget.
 */
function wpdocs_add_dashboard_widgets() {
  wp_add_dashboard_widget('dashboard_widget', 'Heads Up Display', 'headsup_function');
}

/**
 * Formats display of information on the main page.
 */
function main_page_display() {
  ?>
  <div style="margin-left:2.75%; font-size:15px; margin-top:1%; margin-bottom:1%;">
    <?php headsup_function(); ?>
  </div>
<?php
}

/**
 * Chooses where to display plugin content.
 */
function display_content() {
  $options = get_option(
    'headsup_options',
    array(
      'font_style' => 'None',
      'location'   => 'At a glance',
    )
  );

  $locationInfo = isset($options['location']) ? $options['location'] : 'At a glance';

  switch ($locationInfo) {
    case 'At a glance':
      add_action('rightnow_end', 'headsup_function');
      break;
    case 'Heads Up Widget':
      add_action('wp_dashboard_setup', 'wpdocs_add_dashboard_widgets');
      break;
    case 'Main page':
      // Render content inside the page body (not inside <head>).
      add_action('wp_body_open', 'main_page_display');
      break;
    default:
      add_action('rightnow_end', 'headsup_function');
  }
}

display_content();
