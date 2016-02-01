<?php
/*
* Plugin Name: Custom Post Types and Taxonomies
* Description: Create custom post types
* Plugin URI: http://#
* Author: Mohamad Rashid
* Version: 1.0
* License: GPL2
*/

/*

    Copyright (C) 2016  Mohamad Rashid  mohtof2000@gmail.com

    This program is free software; you can redistribute it and/or modify
    it under the terms of the GNU General Public License, version 2, as
    published by the Free Software Foundation.

    This program is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU General Public License for more details.

    You should have received a copy of the GNU General Public License
    along with this program; if not, write to the Free Software
    Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA
*/


 // Turn on php errors reporting
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

/**
* Registers a new post type
* @uses $wp_post_types Inserts new post type object into the list
*
* @param string  Post type key, must not exceed 20 characters
* @param array|string  See optional args description above.
* @return object|WP_Error the registered post type object, or an error object
*/
function mr_test_post_type() {

  // Testimonials post type

  $singular = 'Testimonial';
  $plural = 'Testimonials';

  $labels = array(
    'name'                => $plural,
    'singular_name'       => $singular,
    'add_new'             => 'Add New ' . $singular,
    'add_new_item'        => 'Add New ' . $singular . ' item',
    'edit_item'           => 'Edit '    . $singular,
    'new_item'            => 'New '     . $singular,
    'all_items'           => 'All '      . $plural,
    'view_item'           => 'View '    . $singular,
    'search_items'        => 'Search '  . $plural   . ' items',
    'not_found'           => 'No '      . $plural   . ' found',
    'not_found_in_trash'  => 'No '      . $plural   . 'found in trash'
  );

  $args = array(
    'labels'              => $labels,
    'hierarchical'        => false,
    'description'         => 'description',
    'taxonomies'          => array(),
    'public'              => true,
    'show_ui'             => true,
    'show_in_menu'        => true,
    'show_in_admin_bar'   => true,
    'menu_position'       => 10,
    'menu_icon'           => 'dashicons-editor-kitchensink',
    'show_in_nav_menus'   => true,
    'publicly_queryable'  => true,
    'exclude_from_search' => false,
    'has_archive'         => true,
    'query_var'           => true,
    'capability_type'     => 'post',
    'can_export'          => true,
      'rewrite'           => [
          'slug'        => 'testtimonials',
          'with_front'  => true,
          'pages'       => true,
          'feeds'       => false,
        ],
    'supports'            => array(
      'title', 'editor', 'thumbnail',
      )
  );

  register_post_type( 'testimonials', $args );


  // Reviews post type

  $singular = 'Review';
  $plural = 'Reviews';

  $labels = array(
    'name'                => $plural,
    'singular_name'       => $singular,
    'add_new'             => 'Add New ' . $singular,
    'add_new_item'        => 'Add New ' . $singular . ' item',
    'edit_item'           => 'Edit '    . $singular,
    'new_item'            => 'New '     . $singular,
    'view_item'           => 'View '    . $singular,
    'search_items'        => 'Search '  . $plural   . ' items',
    'not_found'           => 'No '      . $plural   . ' found',
    'not_found_in_trash'  => 'No '      . $plural   . 'found in trash'
  );

  $args = array(
    'labels'              => $labels,
    'hierarchical'        => false,
    'description'         => 'description',
    'taxonomies'          => array(),
    'public'              => true,
    'show_ui'             => true,
    'show_in_menu'        => true,
    'show_in_admin_bar'   => true,
    'menu_position'       => 10,
    'menu_icon'           => 'dashicons-admin-settings',
    'show_in_nav_menus'   => true,
    'publicly_queryable'  => true,
    'exclude_from_search' => false,
    'has_archive'         => true,
    'query_var'           => true,
    'capability_type'     => 'post',
    'can_export'          => true,
      'rewrite'           => [
          'slug'        => 'reviews',
          'with_front'  => true,
          'pages'       => true,
          'feeds'       => false,
        ],
    'supports'            => array(
      'title', 'editor', 'thumbnail', 'author', 'excerpt', 'comments'
      ),
    'taxonomies'        => ['category', 'post_tag'],
  );

  register_post_type( 'reviews', $args );
}

add_action( 'init', 'mr_test_post_type' );

function mr_rewrite_flush() {
    // First, we "add" the custom post type via the above written function.
    // Note: "add" is written with quotes, as CPTs don't get added to the DB,
    // They are only referenced in the post_type column with a post entry,
    // when you add a post of this CPT.
    mr_test_post_type();

    // ATTENTION: This is *only* done during plugin activation hook in this example!
    // You should *NEVER EVER* do this on every page load!!
    flush_rewrite_rules();
}
register_activation_hook( __FILE__, 'mr_rewrite_flush' );


/**
 * Create a taxonomy
 *
 * @uses  Inserts new taxonomy object into the list
 * @uses  Adds query vars
 *
 * @param string  Name of taxonomy object
 * @param array|string  Name of the object type for the taxonomy object.
 * @param array|string  Taxonomy arguments
 * @return null|WP_Error WP_Error if errors, otherwise null.
 */
function mr_rigister_new_taxonomy() {

  // Create Programs Taxonomy
  $plural   = 'Programs';
  $singular = 'program';

  $labels = [
    'name'                      => $plural,
    'singular_name'             => $singular,
    'search_items'              => 'Search ' . $plural,
    'popular_items'             => 'Popular ' . $plural,
    'all_items'                 => 'All',
    'parent_item'               => null,
    'parent_item_colon'         => null,
    'edit_item'                 => 'Edit ' . $singular,
    'update_item'               => 'Update ' . $singular,
    'add_new_item'              => 'Add New ' . $singular,
    'new_item_name'             => 'New ' . $singular . ' Name',
    'separate_items_with_comma' => 'Separate ' . $plural. ' with commas',
    'add_or_remove_items'       => 'Add or remove ' . $plural,
    'choose_from_most_used'     => 'choose_from_most_used ' . $plural,
    'not_found'                 => 'No ' . $plural . ' found',
    'menu_name'                 => $plural,
  ];

  $args = [
    'labels'            => $labels,
    'public'            => true,
    'show_in_nav_menus' => true,
    'show_admin_column' => true,
    'hierarchical'      => true,
    'show_tagcloud'     => true,
    'show_ui'           => true,
    'query_var'         => true,
    'rewrite'           => ['slug' => 'program'],
    'query_var'         => true,
  ];

  register_taxonomy( 'program', 'testimonials', $args );

  // Create Price Range taxonomy

  $plural   = 'Price Range';
  $singular = 'Prices Range';

  $labels = [
    'name'                      => $plural,
    'singular_name'             => $singular,
    'search_items'              => 'Search ' . $plural,
    'popular_items'             => 'Popular ' . $plural,
    'all_items'                 => 'All',
    'parent_item'               => null,
    'parent_item_colon'         => null,
    'edit_item'                 => 'Edit ' . $singular,
    'update_item'               => 'Update ' . $singular,
    'add_new_item'              => 'Add New ' . $singular,
    'new_item_name'             => 'New ' . $singular . ' Name',
    'separate_items_with_comma' => 'Separate ' . $plural. ' with commas',
    'add_or_remove_items'       => 'Add or remove ' . $plural,
    'choose_from_most_used'     => 'choose_from_most_used ' . $plural,
    'not_found'                 => 'No ' . $plural . ' found',
    'menu_name'                 => $plural,
  ];

  $args = [
    'labels'            => $labels,
    'public'            => true,
    'show_in_nav_menus' => true,
    'show_admin_column' => true,
    'hierarchical'      => true,
    'show_tagcloud'     => true,
    'show_ui'           => true,
    'query_var'         => true,
    'rewrite'           => ['slug' => 'price-range'],
    'query_var'         => true,
  ];

  register_taxonomy( 'price-range', 'reviews', $args );
}

add_action( 'init', 'mr_rigister_new_taxonomy' );



