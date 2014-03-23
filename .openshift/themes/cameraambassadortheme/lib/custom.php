<?php

// require_once __DIR__ . '/../vendor/'

/**
 * Camera custom post type
 */
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
add_action( 'init', 'CA_register_camera_post_type' );

/**
 * Lens custom post type
 */
function CA_register_lens_post_type() {
  $labels = array(
    'name'               => 'Lenses',
    'singular_name'      => 'Lens',
    'add_new'            => 'Add New',
    'add_new_item'       => 'Add New Lens',
    'edit_item'          => 'Edit Lens',
    'new_item'           => 'New Lens',
    'view_item'          => 'View Lens',
    'search_items'       => 'Search Lenses',
    'not_found'          => 'No Lenses found',
    'not_found_in_trash' => 'No Lenses found in trash',
    'parent_item_colon'  => '',
    'menu_name'          => 'Lens'
  );

  $args = array(
    'labels'              => $labels,
    'public'              => true,
    'exclude_from_search' => false,
    'publicly_queryable'  => true,
    'show_ui'             => true,
    'show_in_menu'        => true,
    'query_var'           => true,
    'rewrite'             => array( 'slug' => 'lenses' ),
    'capability_type'     => 'post',
    'has_archive'         => true,
    'hierarchical'        => false,
    'menu_position'       => null,
    'supports' => array( 'title', 'editor', 'thumbnail' )
  );

  register_post_type( 'lens', $args );
}
add_action( 'init', 'CA_register_lens_post_type' );

function ca_the_breadcrumb() {
  if ( function_exists('yoast_breadcrumb') ) {
    echo '<div class="content row"><div class="col-xs-12">';

    $bc = yoast_breadcrumb( '', '', false );

    $bc = str_replace(
        '<span xmlns:v="http://rdf.data-vocabulary.org/#">',
        '<ol class="breadcrumb pull-left" xmlns:v="http://rdf.data-vocabulary.org/#">',
        $bc
      );

    $bc = str_replace( '<span typeof="v:Breadcrumb"></span>', '', $bc );
    $bc = str_replace( '<span typeof', '<li typeof', $bc );
    $bc = str_replace( '></span', '></li', $bc );

    echo str_replace( '</span', '</ol', $bc ) . '</div></div>';
  }
}

