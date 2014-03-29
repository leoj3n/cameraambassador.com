<?php

$intro = get_theme_mod('Intro');

ob_start(); get_template_part('templates/search');
$search = ob_get_clean();

echo <<<HTML
<section class="green-screen-bg">
  <div class="container">
    {$intro[ 'content' ]}
    {$search}
  </div>
</section>
HTML;

