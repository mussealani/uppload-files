<?php
/*
Plugin Name: Upload File
Description: Upload File plugin give you the opportunity to list any uploaded file to upload_dir folder who is located in uploads
and create links to the original file.
Version: 1.0
Author: MI group No.3
License: GPL2
*/

require_once 'config/config.php';

// Turn on php errors reporting
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Prevent user to get any information if called directly
if (!function_exists('add_action')) {
  echo "OBS: I cannot do anything when called directly.";
  exit;
}

define('UPPLOAD_FILE__MINIMUM_WP_VERSION', '4.4.1');
define('UPLOAD_FILE__PLUGIN_URL', plugin_dir_url(__FILE__));
define('UPLOAD_FILE__PLUGIN_DIR', plugin_dir_url(__FILE__));


register_activation_hook(UPLOAD_FILE__PLUGIN_DIR, 'on_activation');

function on_activation() {
// Define minimum WP version to active upload plugin
  global $wp_version;
  if (version_compare($wp_version, UPPLOAD_FILE__MINIMUM_WP_VERSION, '<')) {
    exit('This plugin requires WordPress version 4.4.1 or higher');
  }
}


function file_upload($html) {

// Define wp upload folder
  $main_path = wp_upload_dir();

  $current_path = '';

// Instaniate Post_Get class
  $get = new Post_Get();

// Check if GET variable has value
  $get->exists('GET');
  $current_path = $get->get('upload_dir');


// Define the folder directory that will hold the content
  $container = $main_path['basedir'] . '/upload_dir';

// Create upload_dir folder to hold the documents that will be uploaded
  if (!file_exists($container)) {

    mkdir($container, 0755, true);
  }

// Define current url
  $current_url = $main_path['baseurl'] . '/upload_dir/';

// Scan current directory
  $current_dir = scandir($main_path['basedir'] . '/upload_dir/' . $current_path);

// Wrap the retusts in unordered list
  $html .= "<ul>";

  if ($current_dir) {


    $categories = get_categories(['child_of' => 7]);
    foreach ($categories as $category) {
// if (!in_array($category->name, $current_dir)) {
//array_push($current_dir, $category->slug);
// $cat_link = get_category_link($category->cat_ID);

// $html .= "<li><a href=" . $cat_link . ">" . $category->slug . "</a></li><br>";

      if (!file_exists($container . '/' . $category->name )) {

            mkdir($container . '/' . $category->name , 0755, true);
        }

      query_posts('category_name=' . $category->name);
      global $post;
      if (have_posts()) : while (have_posts()) : the_post();

      if($terms = wp_get_post_terms($post->ID)){
        foreach ($terms as $term) {
          if (!file_exists($container . '/' . $category->name  . '/' . $term->name)) {

            mkdir($container . '/' . $category->name  . '/' . $term->name , 0755, true);
          }
        }
      }
      endwhile; endif;
      wp_reset_query();
    }
  }

// }

// $diff = array_diff($categories->cat_name, $current_dir);
// print_r($diff);


// Loop throught current folder
  foreach ($current_dir as $file) {
    if (stripos($file, '.') !== 0 && $file !== $category->slug) {

      if (stripos($file, '.html') > -1) {
        $html .= '<li><a href="' . $current_url . $current_path . '/' . $file . '">' . $file . '</a></li>';

      }else{

        $html .= '<li><a href="?upload_dir=' . $current_path . '/' . $file . '">' . $file . '</a></li>';

      }

    }
  }


$html .= '</ul>';

  return $html;
}


//add_filter('the_content', 'file_upload');

add_shortcode( 'upploaded_documents', 'file_upload');


