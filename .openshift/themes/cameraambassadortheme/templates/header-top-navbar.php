<?php

$home_url = home_url();
$blog_title = get_bloginfo('name');
$assets = get_template_directory_uri() . '/assets';

$nav = '';

if ( has_nav_menu('primary_navigation') ) :
  $nav = wp_nav_menu(
      array(
        'echo' => false,
        'theme_location' => 'primary_navigation',
        'menu_class' => 'nav navbar-nav navbar-right'
      )
    );
endif;

echo <<<HTML
<div class="banner-wrapper">
<header class="banner navbar navbar-default navbar-static-top" role="banner">
  <div class="container">
    <div class="navbar-header">
      <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
        <span class="sr-only">Toggle navigation</span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
      </button>
      <a class="navbar-brand" href="{$home_url}/">
        <img
          width="70"
          height="70"
          src="{$assets}/img/Camera-Ambassador-Logo_@2x.png">
        <span>{$blog_title}</span>
      </a>
    </div>

    <nav class="collapse navbar-collapse" role="navigation">
      {$nav}
    </nav>
  </div>
</header>
</div>
HTML;

