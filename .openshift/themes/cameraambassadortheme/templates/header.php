<?php

$name = bloginfo('name');
$homeurl = home_url('/');

if ( has_nav_menu('primary_navigation') ) :
  $nav = wp_nav_menu(
    array(
      'echo' => false,
      'menu_class' => 'nav nav-pills',
      'theme_location' => 'primary_navigation'
    )
  );
endif;

echo <<<HTML
<header class="banner container" role="banner">
  <div class="row">
    <div class="col-lg-12">
      <a class="brand" href="{$homeurl}">{$name}</a>
      <nav class="nav-main" role="navigation">
        {$nav}
      </nav>
    </div>
  </div>
</header>
HTML;

