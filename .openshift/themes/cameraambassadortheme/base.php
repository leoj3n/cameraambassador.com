<?php

get_template_part('templates/head');

ob_start(); body_class();
$body_class = ob_get_clean();

echo <<<HTML
<body {$body_class}>
HTML;

  do_action('get_header');

  get_template_part('templates/header-top-navbar');

  $breadcrumb = ca_breadcrumb();

  $breadcrumb_html = <<<HTML
  {$breadcrumb}
  <a
    href="#saved"
    class="saved"
    data-toggle="modal"
    data-target="#savedModal">
    <span class="glyphicon glyphicon-camera"></span>
  </a>

  <div class="modal fade" id="savedModal">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <button
            type="button"
            class="close"
            aria-hidden="true"
            data-dismiss="modal">&times;</button>
          <h4 class="modal-title">Saved items</h4>
        </div>
        <div class="modal-body">
          No saved items &mdash; see
          <a href="/camera">Cameras</a> or
          <a href="/lens">Lenses</a>.
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-info">
            Contact sales about these items
          </button>
        </div>
      </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
  </div><!-- /.modal -->
HTML;

  $main_class = roots_main_class();

  ob_start(); include roots_template_path();
  $template_html = ob_get_clean();

  if ( roots_display_sidebar() ) {
    $sidebar_class = roots_sidebar_class();

    ob_start(); include roots_sidebar_path();
    $sidebar = ob_get_clean();

    $sidebar_html = <<<HTML
      <aside class="sidebar {$sidebar_class}" role="complementary">
        {$sidebar}
      </aside><!-- /.sidebar -->
HTML;
  }

  echo <<<HTML
  <div class="wrap container" role="document">
      {$breadcrumb_html}
      <div class="content row">
        <main class="main {$main_class}" role="main">
          {$template_html}
        </main><!-- /.main -->
        {$sidebar_html}
    </div><!-- /.content -->
  </div><!-- /.wrap -->
HTML;

  get_template_part('templates/footer');

echo <<<HTML
</body>
</html>
HTML;

