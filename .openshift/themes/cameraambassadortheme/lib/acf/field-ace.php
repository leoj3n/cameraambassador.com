<?php
class acf_field_ace_code_editor extends acf_field
{
    #
    # will hold info such as dir / path
    #

    var $settings;

    /*
    *  __construct
    *
    *  Set name / label needed for actions / filters
    *
    *  @since   3.6
    *  @date    23/01/13
    */
    function __construct()
    {
      require_once __DIR__ . '/../../vendor/htmLawed/htmLawed/htmLawed.php';

      // vars
      $this->name = 'ace_code_editor';
      $this->label = __('Ace Code Editor');
      $this->category = __( 'Basic','acf' );

      // do not delete!
      parent::__construct();

      // settings
      $this->settings = array(
          'path' => apply_filters( 'acf/helpers/get_path', __FILE__ ),
          'dir' => apply_filters( 'acf/helpers/get_dir', __FILE__ ),
          'version' => '1.0.0'
        );

    }

    /*
    *  create_field()
    *
    *  Create the HTML interface for your field
    *
    *  @param   $field - an array holding all the field's data
    *
    *  @type    action
    *  @since   3.6
    *  @date    23/01/13
    */
    function create_field( $field )
    {
      $field[ 'value' ] = trim(esc_textarea($field[ 'value' ]));

      echo <<<HTML
  <div class="ace-wrapper">
    <textarea
      rows="4"
      id="{$field[ 'id' ]}"
      name="{$field[ 'name' ]}">{$field[ 'value' ]}</textarea>
  </div>
HTML;
    }

    /*
    *  input_admin_enqueue_scripts()
    *
    *  This action is called in the admin_enqueue_scripts action on the edit screen where your field is created.
    *  Use this action to add css + javascript to assist your create_field() action.
    *
    *  $info    http://codex.wordpress.org/Plugin_API/Action_Reference/admin_enqueue_scripts
    *  @type    action
    *  @since   3.6
    *  @date    23/01/13
    */
    function input_admin_enqueue_scripts()
    {

        #
        # register
        #

        wp_register_script(
          'acf-input-ace_code_editor_js',
          get_template_directory_uri() . '/bower_components/ace-editor/src-min-noconflict/ace.js',
          array('acf-input'),
          $this->settings[ 'version' ]
        );

        wp_register_style(
          'acf-input-ace_code_editor_css',
          $this->settings[ 'dir' ] . '/../css/input.css', array('acf-input'),
          $this->settings[ 'version' ]
        );

        #
        # scripts
        #

        wp_enqueue_script(
          array(
            'acf-input-ace_code_editor_js',
          )
        );

        #
        # styles
        #

        // wp_enqueue_style(array(
        //     'acf-input-ace_code_editor_css',
        // ));
    }


    /*
    *  input_admin_head()
    *
    *  This action is called in the admin_head action on the edit screen where your field is created.
    *  Use this action to add css and javascript to assist your create_field() action.
    *
    *  @info    http://codex.wordpress.org/Plugin_API/Action_Reference/admin_head
    *  @type    action
    *  @since   3.6
    *  @date    23/01/13
    */
    function input_admin_head() {
      echo <<<'JS'
<script>

//
// Create Advanced Code Editor (ace)
//

jQuery(function( $, undefined ) {
  $('.ace-wrapper').each(function( i ) {
    var $textarea = $( 'textarea', this ).hide(),
      $editor = $('<div>')
        .addClass(
          'ace_code_editor'
        )
        .appendTo(
          $(this)
        ),
      editor = ace.edit(
          $editor.get(0)
        );

    //
    // Editor preferences
    //

    editor.setTheme('ace/theme/chrome');
    editor.getSession().setTabSize(2);
    editor.getSession().setUseSoftTabs(true);
    editor.getSession().setMode('ace/mode/html');

    //
    // Textarea synchronization
    //

    editor.getSession().setValue($textarea.val());

    editor.getSession().on( 'change', function() {
      $textarea.val(editor.getSession().getValue());
    });
  });
});

</script>
JS;

      echo <<<'CSS'
<style type="text/css" media="screen">
.ace-wrapper {
  position: relative;
  height: 300px;
}

.ace_code_editor {
  margin: 0;
  position: absolute;
  top: 0;
  bottom: 0;
  left: 0;
  right: 0;
}
</style>
CSS;
    } # input_admin_head()

    /*
    *  format_value()
    *
    *  This filter is appied to the $value after it is loaded from the db and before it is passed to the create_field action
    *
    *  @type    filter
    *  @since   3.6
    *  @date    23/01/13
    *
    *  @param   $value  - the value which was loaded from the database
    *  @param   $post_id - the $post_id from which the value was loaded
    *  @param   $field  - the field array holding all the field options
    *
    *  @return  $value  - the modified value
    */
    function format_value( $value, $post_id, $field )
    {
        $value = htmLawed(
            trim($value),
            array(
              'tidy' => '1t0n; s',
              'schemes' => '*: *'
            )
          );

        return $value;
    }

}

// create field
new acf_field_ace_code_editor();

