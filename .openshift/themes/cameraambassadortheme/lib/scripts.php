<?php
/**
 * Enqueue scripts and stylesheets
 */
function roots_scripts() {
  wp_enqueue_style(
    'roots_main',
    get_template_directory_uri() . '/assets/css/main.min.css',
    false,
    '70b3a2f6a845aa4788ebf2527081b364'
  );

  if ( !is_admin() && current_theme_supports('jquery-cdn') ) {
    wp_deregister_script('jquery');
    wp_register_script(
      'jquery',
      '//ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js',
      array(),
      null,
      false
    );
    add_filter( 'script_loader_src', 'roots_jquery_local_fallback', 10, 2 );
  }

  if ( is_single() && comments_open() && get_option('thread_comments') ) {
    wp_enqueue_script('comment-reply');
  }

  wp_register_script(
    'polymer',
    get_template_directory_uri() . '/bower_components/platform/platform.js',
    array(),
    null,
    false
  );

  wp_register_script(
    'maps',
    'https://maps.googleapis.com/maps/api/js?v=3.exp&sensor=false',
    array(),
    null,
    false
  );

  wp_register_script(
    'modernizr',
    get_template_directory_uri() . '/assets/js/vendor/modernizr-2.7.0.min.js',
    array(),
    null,
    false
  );

  wp_register_script(
    'roots_scripts',
    get_template_directory_uri() . '/assets/js/scripts.min.js',
    array(),
    'a2489a750cc8fe27625e1f4952bc6121',
    true
  );

  // wp_enqueue_script('polymer');
  wp_enqueue_script('modernizr');
  wp_enqueue_script('maps');
  wp_enqueue_script('jquery');
  wp_enqueue_script('roots_scripts');
}
add_action( 'wp_enqueue_scripts', 'roots_scripts', 100 );

// http://wordpress.stackexchange.com/a/12450
function roots_jquery_local_fallback( $src, $handle = null ) {
  static $add_jquery_fallback = false;

  if ( $add_jquery_fallback ) {
    $tmpldir = get_template_directory_uri();

    echo <<<JS
<script>window.jQuery || document.write('<script src="{$tmpldir}/assets/js/vendor/jquery-1.11.0.min.js"><\/script>')</script>
JS;
    $add_jquery_fallback = false;
  }

  if ( $handle === 'jquery' ) {
    $add_jquery_fallback = true;
  }

  return $src;
}
add_action( 'wp_head', 'roots_jquery_local_fallback' );

function roots_google_analytics() {
  echo <<<HTML
<script>
  (function(b,o,i,l,e,r){b.GoogleAnalyticsObject=l;b[l]||(b[l]=
  function(){(b[l].q=b[l].q||[]).push(arguments)});b[l].l=+new Date;
  e=o.createElement(i);r=o.getElementsByTagName(i)[0];
  e.src='//www.google-analytics.com/analytics.js';
  r.parentNode.insertBefore(e,r)}(window,document,'script','ga'));
  ga('create','<?php echo GOOGLE_ANALYTICS_ID; ?>');ga('send','pageview');
</script>
HTML;
}

if ( GOOGLE_ANALYTICS_ID && !current_user_can('manage_options') ) {
  add_action( 'wp_footer', 'roots_google_analytics', 20 );
}
