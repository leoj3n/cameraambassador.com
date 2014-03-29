<?php

require_once __DIR__ . '/cpt/lens.php';
require_once __DIR__ . '/cpt/camera.php';
require_once __DIR__ . '/acf/field-ace.php';
// require_once __DIR__ . '/../vendor/'

/**
 * Enqueue scripts
 */
add_action( 'wp_enqueue_scripts', 'ca_enqueue_scripts', 101 );
function ca_enqueue_scripts() {

  #
  # will make variables accessible to script.js
  # which can be used like WPURLS.siteurl
  #

  wp_localize_script(
    'roots_scripts',
    'WPURLS',
    array( 'stylesheet_directory_uri' => get_stylesheet_directory_uri() )
  );
}

/**
 * Cleanup and output yoast breadcrumb
 */
function ca_breadcrumb() {
  if ( function_exists('yoast_breadcrumb') ) {
    $bc = yoast_breadcrumb( '', '', false );

    $bc = str_replace(
        '<span xmlns:v="http://rdf.data-vocabulary.org/#">',
        '<ol class="breadcrumb pull-left" xmlns:v="http://rdf.data-vocabulary.org/#">',
        $bc
      );

    $bc = str_replace( '<span typeof="v:Breadcrumb"></span>', '', $bc );
    $bc = str_replace( '<span typeof', '<li typeof', $bc );
    $bc = str_replace( '></span', '></li', $bc );
    $bc = str_replace( '</span', '</ol', $bc );

    return <<<HTML
<div class="breadcrumb-wrapper content row">
  <div class="col-xs-12">
    {$bc}
  </div>
</div>
HTML;
  }
}

/**
 * Rehydrate JSON on post save
 */
add_action( 'save_post', 'save_book_meta' );
function save_book_meta( $post_id ) {
  switch( $_POST[ 'post_type' ] ) {
    case 'camera':
      $data = array();
      $cameras = get_posts(
          array(
            'offset' => 0,
            'order' => 'ASC',
            'orderby' => 'title',
            'post_type' => 'camera',
            'posts_per_page' => -1,
            'post_status' => 'publish'
          )
        );

      foreach ( $cameras as $camera ) {
        array_push(
          $data,
          array(
            'camera' => $camera->post_title
          )
        );
      }

      file_put_contents(
        get_template_directory() . '/data/cameras.json',
        json_encode($data)
      );
      break;

    case 'lens':
      $data = array();
      $lenses = get_posts(
          array(
            'offset' => 0,
            'order' => 'ASC',
            'orderby' => 'title',
            'post_type' => 'lens',
            'posts_per_page' => -1,
            'post_status' => 'publish'
          )
        );

      foreach ( $lenses as $lens ) {
        array_push(
          $data,
          array(
            'lens' => $lens->post_title
          )
        );
      }

      file_put_contents(
        get_template_directory() . '/data/lenses.json',
        json_encode($data)
      );
      break;

    case 'service':
      break;
  }
}

