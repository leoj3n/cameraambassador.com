<?php
/**
 * Lens custom post type
 */
add_action( 'init', 'CA_register_lens_post_type' );
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
    'rewrite'             => array( 'slug' => 'lens' ),
    'capability_type'     => 'post',
    'has_archive'         => true,
    'hierarchical'        => false,
    'menu_position'       => null,
    'supports' => array( 'title', 'editor', 'thumbnail' )
  );

  register_post_type( 'lens', $args );
}

