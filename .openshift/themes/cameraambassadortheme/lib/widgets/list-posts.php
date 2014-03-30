<?php
/**
 * List Posts widget
 */
class List_Posts_Widget extends WP_Widget {
  private $fields = array(
    'title' => 'Title (optional)',
    'type' => 'Type'
  );

  function __construct() {
    $widget_ops = array(
      'classname' => 'widget_list_posts',
      'description' =>
        __(
          'Use this widget to list custom posts using Bootstrap',
          'roots'
        )
    );

    $this->WP_Widget(
      'widget_list_posts',
      __( 'C.A. List Posts', 'roots' ),
      $widget_ops
    );
  }

  function widget( $args, $instance ) {
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

    echo $before_widget;

    if ( $title ) {
      echo $before_title, $title, $after_title;
    }

    echo <<<HTML
<div class="panel panel-primary">
  <div class="posts-list list-group">
HTML;

    $posts = get_posts(
        array(
          'offset' => 0,
          'order' => 'ASC',
          'orderby' => 'title',
          'posts_per_page' => -1,
          'post_status' => 'publish',
          'post_type' => $instance[ 'type' ]
        )
      );

    foreach ( $posts as $key => $post ) :
      $active = ( $post->ID === get_the_ID() );
      $class = $active ? 'active' : '';
      $permalink = get_permalink( $post->ID );
      $checked = $active ? 'checked="checked"' : '';

      echo <<<HTML
    <a href="{$permalink}"
      class="list-group-item {$class}">
      <span class="compare-checkbox hidden">
        <input type="checkbox" {$checked}>
      </span>
      {$post->post_title}
    </a>
HTML;
    endforeach;

    echo <<<HTML
    <!--
    <div class="panel-footer">
      <button type="button" class="compare-button btn btn-lg btn-primary">
        <span class="glyphicon glyphicon-list"></span>
      </button>
      <span class="label label-info">Click to compare</span>
    </div>
    -->

  </div>
</div>
HTML;

    echo $after_widget;
  }

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

