<?php
get_template_part('templates/head');

ob_start(); body_class();
$body_class = ob_get_clean();

$main_class = roots_main_class();

ob_start(); include roots_template_path();
$template_html = ob_get_clean();

ob_start(); get_template_part('templates/intro');
$intro = ob_get_clean();

echo <<<HTML
<body {$body_class}>
HTML;

do_action('get_header');

get_template_part('templates/header-top-navbar');

echo <<<HTML
  <div class="modal fade" id="askModal">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <button
            type="button"
            class="close"
            aria-hidden="true"
            data-dismiss="modal">&times;</button>
          <h4 class="modal-title">Ask a Question</h4>
        </div>
        <div class="modal-body">
          Coming soon...
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-info">
            Ask!
          </button>
        </div>
      </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
  </div><!-- /.modal -->
HTML;

echo <<<HTML
  <div class="wrap" role="document">
    <div class="content">
      {$intro}
      <main class="main {$main_class}" role="main">
        {$template_html}
      </main><!-- /.main -->
    </div><!-- /.content -->
  </div><!-- /.wrap -->
HTML;

get_template_part('templates/footer');

echo <<<HTML
</body>
</html>
HTML;

