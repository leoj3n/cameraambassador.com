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
  register_widget('Roots_Vcard_Widget');
}
add_action( 'widgets_init', 'roots_widgets_init' );

/**
 * List Posts widget
 */
class List_Posts_Widget extends WP_Widget {
  private $fields = array(
    'title'          => 'Title (optional)',
    'type'           => 'Type'
  );

  function __construct() {
    $widget_ops = array(
      'classname' => 'widget_list_posts',
      'description' => __(
          'Use this widget to list custom posts using Bootstrap', 'roots'
        )
    );

    $this->WP_Widget(
      'widget_list_posts',
      __( 'C.A. List Posts', 'roots' ),
      $widget_ops
    );
  }

  function widget( $args, $instance ) {
    // global $post;

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
    } ?>

    <div class="posts-list list-group">

<?php
    $posts = get_posts(
      array(
        'offset'         => 0,
        'orderby'        => 'title',
        'order'          => 'DESC',
        'post_type'      => 'camera',
        'post_status'    => 'publish',
        'posts_per_page' => -1
      ));

    foreach ( $posts as $key => $post ) {?>
      <a href="<?php echo get_permalink( $post->ID ); ?>"
        class="list-group-item<?php
          echo $post->ID === get_the_ID() ? ' active' : '';
        ?>">
        <?php echo $post->post_title; ?>
      </a>
<?php
      } ?>
    </div>

<?php
    echo $after_widget;
  }

  function update( $new_instance, $old_instance ) {
    $instance = array_map( 'strip_tags', $new_instance );
    return $instance;
  }

  function form( $instance ) {
    foreach ( $this->fields as $name => $label ) {
      ${$name} = isset($instance[ $name ])
        ? esc_attr($instance[ $name ])
        : '';
?>

    <p>
      <label for="<?php echo esc_attr($this->get_field_id($name)); ?>">
        <?php _e( "{$label}:", 'roots' ); ?>
      </label>
      <input class="widefat"
        id="<?php echo esc_attr($this->get_field_id($name)); ?>"
        name="<?php echo esc_attr($this->get_field_name($name)); ?>"
        type="text"
        value="<?php echo ${$name}; ?>">
    </p>

<?php
    }
  }
}


















/**
 * Example vCard widget
 */
class Roots_Vcard_Widget extends WP_Widget {
  private $fields = array(
    'title'          => 'Title (optional)',
    'street_address' => 'Street Address',
    'locality'       => 'City/Locality',
    'region'         => 'State/Region',
    'postal_code'    => 'Zipcode/Postal Code',
    'tel'            => 'Telephone',
    'email'          => 'Email'
  );

  function __construct() {
    $widget_ops = array('classname' => 'widget_roots_vcard', 'description' => __('Use this widget to add a vCard', 'roots'));

    $this->WP_Widget('widget_roots_vcard', __('Roots: vCard', 'roots'), $widget_ops);
    $this->alt_option_name = 'widget_roots_vcard';

    add_action('save_post', array(&$this, 'flush_widget_cache'));
    add_action('deleted_post', array(&$this, 'flush_widget_cache'));
    add_action('switch_theme', array(&$this, 'flush_widget_cache'));
  }

  function widget($args, $instance) {
    $cache = wp_cache_get('widget_roots_vcard', 'widget');

    if (!is_array($cache)) {
      $cache = array();
    }

    if (!isset($args['widget_id'])) {
      $args['widget_id'] = null;
    }

    if (isset($cache[$args['widget_id']])) {
      echo $cache[$args['widget_id']];
      return;
    }

    ob_start();
    extract($args, EXTR_SKIP);

    $title = apply_filters('widget_title', empty($instance['title']) ? __('vCard', 'roots') : $instance['title'], $instance, $this->id_base);

    foreach($this->fields as $name => $label) {
      if (!isset($instance[$name])) { $instance[$name] = ''; }
    }

    echo $before_widget;

    if ($title) {
      echo $before_title, $title, $after_title;
    }
  ?>
    <p class="vcard">
      <a class="fn org url" href="<?php echo home_url('/'); ?>"><?php bloginfo('name'); ?></a><br>
      <span class="adr">
        <span class="street-address"><?php echo $instance['street_address']; ?></span><br>
        <span class="locality"><?php echo $instance['locality']; ?></span>,
        <span class="region"><?php echo $instance['region']; ?></span>
        <span class="postal-code"><?php echo $instance['postal_code']; ?></span><br>
      </span>
      <span class="tel"><span class="value"><?php echo $instance['tel']; ?></span></span><br>
      <a class="email" href="mailto:<?php echo $instance['email']; ?>"><?php echo $instance['email']; ?></a>
    </p>
  <?php
    echo $after_widget;

    $cache[$args['widget_id']] = ob_get_flush();
    wp_cache_set('widget_roots_vcard', $cache, 'widget');
  }

  function update($new_instance, $old_instance) {
    $instance = array_map('strip_tags', $new_instance);

    $this->flush_widget_cache();

    $alloptions = wp_cache_get('alloptions', 'options');

    if (isset($alloptions['widget_roots_vcard'])) {
      delete_option('widget_roots_vcard');
    }

    return $instance;
  }

  function flush_widget_cache() {
    wp_cache_delete('widget_roots_vcard', 'widget');
  }

  function form($instance) {
    foreach($this->fields as $name => $label) {
      ${$name} = isset($instance[$name]) ? esc_attr($instance[$name]) : '';
    ?>
    <p>
      <label for="<?php echo esc_attr($this->get_field_id($name)); ?>"><?php _e("{$label}:", 'roots'); ?></label>
      <input class="widefat" id="<?php echo esc_attr($this->get_field_id($name)); ?>" name="<?php echo esc_attr($this->get_field_name($name)); ?>" type="text" value="<?php echo ${$name}; ?>">
    </p>
    <?php
    }
  }
}
