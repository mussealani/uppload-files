<?php
/*
* Plugin Name: WP Job Listing
* Description: This plugin allows you to add a simple job listing section to your WordPress website.
* Version: 0.0.1
* Author: Mohamad Rashid
* License: GPL2
*/

// Exit if accessed directly
if (!defined('ABSPATH')) {
  exit;
}

// Turn on php errors reporting
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Define plugin path
define('PLUGIN_DIR_PATH', plugin_dir_path(__FILE__));

require_once  (PLUGIN_DIR_PATH . 'wp-job-cpt.php');
require_once  (PLUGIN_DIR_PATH . 'wp-job-render-admin.php');
require_once  (PLUGIN_DIR_PATH . 'wp-job-fields.php');

/**
* Enqueue scripts
*
* @param string $handle Script name
* @param string $src Script url
* @param array $deps (optional) Array of script names on which this script depends
* @param string|bool $ver (optional) Script version (used for cache busting), set to null to disable
* @param bool $in_footer (optional) Whether to enqueue the script before </head> or before </body>
*/
function mr_admin_enqueue_script() {

  // Define current screen
  $screen_now = get_current_screen();

  // Check if current has post_type job
  if ($screen_now->post_type == 'job') {
      wp_enqueue_style('mr_admin_css', plugins_url('css/admin-jobs.css', __FILE__));
      wp_enqueue_script('mr_job_js', plugins_url('js/admin-jobs.js', __FILE__), array('jquery', 'jquery-ui-datepicker'), '2016-01-30', true);
  }
}
  add_action( 'admin_enqueue_scripts', 'mr_admin_enqueue_script' );
