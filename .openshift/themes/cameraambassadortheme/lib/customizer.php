<?php
/**
 * Binds JS handlers to make preview reload changes asynchronously.
 */
add_action( 'customize_preview_init', 'ca_customize_preview_js' );
function ca_customize_preview_js() {
  wp_enqueue_script(
    'ca_customizer',
    get_template_directory_uri() . '/assets/js/customizer.js',
    array('customize-preview'),
    '888',
    true
  );
}

/**
 * Theme customizer additions
 */
add_action( 'customize_register', 'ca_customize_register' );
function ca_customize_register( $wp_customize ) {
  ca_custom_control_classes();

  #
  # Intro
  #

  $wp_customize->add_section(
    'Intro',
    array(
      'title' => esc_html__( 'Intro', 'roots' )
    )
  );

  $default_intro_content = <<<HTML
<div class="row">
  <div class="col-sm-12 text-center">
    <h1 class="brand-font"><b>Camera Ambassador</b></h1>
    <p class="lead">Camera gear & post-production for the rest of us.</p>
    </p>
  </div>
</div>
HTML;

  $wp_customize->add_setting(
    'Intro[content]',
    array(
      'default' => $default_intro_content,
      'sanitize_callback' => array(
        'CA_Textarea_Control',
        'sanitize_content'
      ),
      'sanitize_js_callback' => array(
        'CA_Textarea_Control',
        'sanitize_content'
      )
    )
  );

  $wp_customize->add_control(
    new CA_Textarea_Control(
      $wp_customize,
      'Intro[content]',
      array(
        'section' => 'Intro',
        'settings' => 'Intro[content]',
        'label' => esc_html__( 'Intro Content', 'roots' ),
      )
    )
  );

  #
  # Search
  #

  $wp_customize->add_section(
    'Search',
    array(
      'title' => esc_html__( 'Search', 'roots' )
    )
  );

  $wp_customize->add_setting(
    'Search[placeholder]',
    array(
      'default' => esc_attr__(
        'Start typing a camera, lens, or service name',
        'roots'
      ),
      'sanitize_callback' => array(
        'CA_Text_Control',
        'sanitize_content'
      ),
      'sanitize_js_callback' => array(
        'CA_Text_Control',
        'sanitize_content'
      )
    )
  );

  $wp_customize->add_control(
    new CA_Text_Control(
      $wp_customize,
      'Search[placeholder]',
      array(
        'section' => 'Search',
        'settings' => 'Search[placeholder]',
        'label' => esc_html__( 'Placeholder Text', 'roots' )
      )
    )
  );

  #
  # CTA content
  #

  $wp_customize->add_section(
    'CTA',
    array(
      'title' => esc_html__( 'CTA', 'roots' )
    )
  );

  $wp_customize->add_setting(
    'CTA[content]',
    array(
      'default' =>
        '<a class="btn btn-secondary btn-lg" href="#">Get Started</a>',
      'sanitize_callback' => array(
        'CA_Textarea_Control',
        'sanitize_content'
      ),
      'sanitize_js_callback' => array(
        'CA_Textarea_Control',
        'sanitize_content'
      )
    )
  );

  $wp_customize->add_control(
    new CA_Textarea_Control(
      $wp_customize,
      'CTA[content]',
      array(
        'section'  => 'CTA',
        'settings' => 'CTA[content]',
        'label'    => esc_html__( 'CTA Content', 'roots' ),
      )
    )
  );

  #
  # Add postMessage support
  #

  $wp_customize->get_setting('blogname')->transport = 'postMessage';
  $wp_customize->get_setting('Intro[content]')->transport = 'postMessage';
  $wp_customize->get_setting('Search[placeholder]')->transport = 'postMessage';
  $wp_customize->get_setting('CTA[content]')->transport = 'postMessage';

}

function ca_custom_control_classes() {
  class CA_Text_Control extends WP_Customize_Control {
    public static function sanitize_content( $value ) {
      if ( $value != '' ) {
        $value = trim(convert_chars(wptexturize($value)));
      }

      return $value;
    }
  }

  class CA_Textarea_Control extends WP_Customize_Control {
    public $type = 'textarea';

    public function render_content() {
      $label = esc_html($this->label);
      $valu = esc_textarea($this->value());

      ob_start(); $this->link();
      $link = ob_get_clean();

      echo <<<HTML
<label>
  <span class="customize-control-title">{$label}</span>
  <textarea rows="8" style="width: 100%;" {$link}>{$value}</textarea>
</label>
HTML;
    }

    public static function sanitize_content( $value ) {
      if ( !empty($value) ) {
        $value = apply_filters( 'the_content', $value );
      }

      return $value;
    }
  }
}

