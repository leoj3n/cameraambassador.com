<?php
/**
 * Register sidebars and widgets
 */
function roots_widgets_init() {

  #
  # Sidebars
  #

  register_sidebar(
    array(
      'name'          => __( 'Primary', 'roots' ),
      'id'            => 'sidebar-primary',
      'before_widget' => '<section class="widget %1$s %2$s">',
      'after_widget'  => '</section>',
      'before_title'  => '<h3>',
      'after_title'   => '</h3>',
    )
  );

  register_sidebar(
    array(
      'name'          => __( 'Single Camera', 'roots' ),
      'id'            => 'sidebar-single-camera',
      'before_widget' => '<section class="widget %1$s %2$s">',
      'after_widget'  => '</section>',
      'before_title'  => '<h3>',
      'after_title'   => '</h3>',
    )
  );

  register_sidebar(
    array(
      'name'          => __( 'Single Lens', 'roots' ),
      'id'            => 'sidebar-single-lens',
      'before_widget' => '<section class="widget %1$s %2$s">',
      'after_widget'  => '</section>',
      'before_title'  => '<h3>',
      'after_title'   => '</h3>',
    )
  );

  register_sidebar(
    array(
      'name'          => __( 'Footer', 'roots' ),
      'id'            => 'sidebar-footer',
      'before_widget' => '<section class="widget %1$s %2$s">',
      'after_widget'  => '</section>',
      'before_title'  => '<h3>',
      'after_title'   => '</h3>',
    )
  );

  #
  # Widgets
  #

  register_widget('List_Posts_Widget');
  register_widget('List_Related_Posts_Widget');
  register_widget('Roots_Vcard_Widget');
}
add_action( 'widgets_init', 'roots_widgets_init' );

require_once __DIR__ . '/widgets/vcard.php';
require_once __DIR__ . '/widgets/list-posts.php';
require_once __DIR__ . '/widgets/related-posts.php';

