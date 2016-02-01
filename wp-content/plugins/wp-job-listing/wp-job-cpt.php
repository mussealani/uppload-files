<?php

 /**
  * Registers a new post type
  * @uses $wp_post_types Inserts new post type object into the list
  *
  * @param string  Post type key, must not exceed 20 characters
  * @param array|string  See optional args description above.
  * @return object|WP_Error the registered post type object, or an error object
  */
  function mr_register_post_type() {

    $singular = 'Job Listing';
    $plural   = 'Job Listings';

    $labels = [
         'name'                => $plural,
         'singular_name'       => $singular,
         'add_new'            => 'Add New',
         'add_new_item'        => 'Add New ' . $singular,
         'edit'                => 'Edit',
         'edit_item'           => 'Edit ' . $singular,
         'new_item'            => 'New ' . $singular,
         'view'                => 'View ' . $singular,
         'view_item'           => 'View ' . $singular,
         'search_term'         => 'Search ' . $singular,
         'parent'              => 'Parent ' . $singular,
         'not_found'           => 'No ' . $plural . ' found',
         'not_found_in_trash'  => 'No ' . $plural . ' in Trash',
    ];

    $args = [
      'labels'              => $labels,
      'hierarchical'        => false,
      'description'         => 'description',
      'taxonomies'          => array(),
      'public'              => true,
      'show_ui'             => true,
      'show_in_menu'        => true,
      'show_in_admin_bar'   => true,
      'menu_position'       => 10,
      'menu_icon'           => 'dashicons-businessman',
      'show_in_nav_menus'   => true,
      'publicly_queryable'  => true,
      'exclude_from_search' => false,
      'has_archive'         => true,
      'query_var'           => true,
      'can_export'          => true,
      'delete_with_user'    => false,
      'capability_type'     => 'page',
      'map_meta_cap'        => true,
      'rewrite'             => [
          'slug'        => 'jobs',
          'with_front'  => true,
          'pages'       => true,
          'feeds'       => false,
        ],
      'supports'            => [
        'title',
        ],
    ];

    register_post_type( 'job', $args );
  }


add_action('init', 'mr_register_post_type');



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
function mr_rigister_taxonomy() {

  $plural   = 'Locations';
  $singular = 'Location';

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
    'rewrite'           => ['slug' => 'location'],
    'query_var'         => true,
  ];

  register_taxonomy( 'location', 'job', $args );
}

add_action( 'init', 'mr_rigister_taxonomy' );



