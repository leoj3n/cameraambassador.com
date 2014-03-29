<?php

$theme_mods = get_theme_mods();
$intro_content = $theme_mods[ 'Intro' ][ 'content' ];

ob_start(); get_template_part('templates/search');
$search = ob_get_clean();

echo <<<HTML
<section class="green-screen-bg">
  <div class="container">
    {$intro_content}
    {$search}
  </div>
</section>
HTML;

