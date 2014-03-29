<?php
/**
 * Camera custom post type
 */
add_action( 'init', 'CA_register_camera_post_type' );
function CA_register_camera_post_type() {
  $labels = array(
    'name'               => 'Cameras',
    'singular_name'      => 'Camera',
    'add_new'            => 'Add New',
    'add_new_item'       => 'Add New Camera',
    'edit_item'          => 'Edit Camera',
    'new_item'           => 'New Camera',
    'view_item'          => 'View Camera',
    'search_items'       => 'Search Cameras',
    'not_found'          => 'No Cameras found',
    'not_found_in_trash' => 'No Cameras found in trash',
    'parent_item_colon'  => '',
    'menu_name'          => 'Camera'
  );

  $args = array(
    'labels'              => $labels,
    'public'              => true,
    'exclude_from_search' => false,
    'publicly_queryable'  => true,
    'show_ui'             => true,
    'show_in_menu'        => true,
    'query_var'           => true,
    'rewrite'             => array( 'slug' => 'camera' ),
    'capability_type'     => 'post',
    'has_archive'         => true,
    'hierarchical'        => false,
    'menu_position'       => null,
    'supports' => array( 'title', 'editor', 'thumbnail' )
  );

  register_post_type( 'camera', $args );
}

