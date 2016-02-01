<?php
/*
* Plugin Name: Basic Plugin
* and create links to the original file.
* Version: 1.0
* description: A plugin for creating and displaying job opportunities
* Author: Mohamad Rashid
* License: GPL2
*/

// Remove WP News widget in dash bord
function mr_remove_dashboard_widget() {
  remove_meta_box('dashboard_primary', 'dashboard', 'side');
}

add_action( 'wp_dashboard_setup', 'mr_remove_dashboard_widget' );


// Add google anylize to admin menu
function mr_add_google_link() {
  global $wp_admin_bar;
  $args = [
    'id'     => 'google_analytics',
    'title'  => 'Google Analytics',
    'href'   => 'http://google.com/analytics',
    'target' => '_blank',
  ];

  $wp_admin_bar->add_menu($args);
}

add_action('wp_before_admin_bar_render', 'mr_add_google_link');


