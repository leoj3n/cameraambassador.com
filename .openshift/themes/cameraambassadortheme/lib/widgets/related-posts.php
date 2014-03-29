<?php

/**
 * List Related Posts widget
 */
class List_Related_Posts_Widget extends WP_Widget {
  private $fields = array(
    'title' => 'Title (optional)',
    'relationship' => 'Relationship'
  );

  function __construct() {
    $widget_ops = array(
      'classname' => 'widget_list_related_posts',
      'description' => __(
          'Use this widget to list custom posts using Bootstrap', 'roots'
        )
    );

    $this->WP_Widget(
      'widget_list_related_posts',
      __( 'C.A. List Related Posts', 'roots' ),
      $widget_ops
    );
  }

  function widget( $args, $instance ) {
    $assets = get_template_directory_uri() . '/assets';

    if ( !isset($args[ 'widget_id' ]) ) {
      $args[ 'widget_id' ] = null;
    }

    extract( $args, EXTR_SKIP );

    $title = apply_filters(
      'widget_title',
      empty($instance[ 'title' ])
        ? __( 'Posts List', 'roots' )
        : $instance[ 'title' ],
      $instance,
      $this->id_base
    );

    foreach ( $this->fields as $name => $label ) {
      if ( !isset($instance[ $name ]) ) {
        $instance[ $name ] = '';
      }
    }

    $posts = get_field($instance[ 'relationship' ]);

    if ( empty($posts) ) {
      return;
    }

    echo $before_widget;

    if ( $title ) {
      echo $before_title, $title, $after_title;
    }

    #
    # Abort if no related posts
    #

    if ( empty($posts) ) :
      echo <<<HTML
<div class="alert alert-info">No related posts.</div>
HTML;
      return;
    endif;

    #
    # Continue if posts
    #

    foreach ( $posts as $key => $post ) :
      $title = $post->post_title;
      $permalink = get_permalink($post->ID);
      $desc = trim(
          substr(
            get_field( 'description', $post->ID ),
            0,
            55
          )
        ) . '...';

      echo <<<HTML
  <div class="media">
    <a class="pull-left" href="{$permalink}">
HTML;

      if (
        $img = wp_get_attachment_image_src(
            get_post_meta( $post->ID, '_thumbnail_id', true ),
            'thumbnail'
          )
      ) :
        echo <<<HTML
      <img width="64" class="media-object" src="{$img[ 0 ]}" alt="{$title}">
HTML;
      else :
        echo <<<HTML
      <img class="media-object" src="{$assets}/img/64x64.svg" alt="{$title}">
HTML;
      endif;

      echo <<<HTML
      </a>
      <div class="media-body">
        <h4 class="media-heading">{$title}</h4>
        {$desc}
      </div>
    </div>
HTML;

    endforeach;

    echo $after_widget;
  } # widget()

  function update( $new_instance, $old_instance ) {
    $instance = array_map( 'strip_tags', $new_instance );
    return $instance;
  }


  function form( $instance ) {
    foreach ( $this->fields as $key => $label ) :
      $label = __( "{$label}:", 'roots' );
      $id = esc_attr($this->get_field_id($key));
      $name = esc_attr($this->get_field_name($key));

      $value = isset($instance[ $key ])
        ? esc_attr($instance[ $key ])
        : '';

      echo <<<HTML
<p>
  <label for="{$id}">
    {$label}
  </label>
  <input class="widefat"
    id="{$id}"
    name="{$name}"
    type="text"
    value="{$value}">
</p>
HTML;
    endforeach;
  }
}

