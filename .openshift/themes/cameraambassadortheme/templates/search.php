<?php

$theme_mods = get_theme_mods();
$search_placeholder = $theme_mods[ 'Search' ][ 'placeholder' ];

echo <<<HTML
<div class="search-wrapper">
  <div class="search" data-spy="affix">
    <form class="form-horizontal" role="form">
      <div class="input-group">
        <span class="input-group-addon">
          <span class="glyphicon glyphicon-camera"></span>
        </span>
        <input
          id="search"
          type="text"
          class="form-control typeahead"
          placeholder="{$search_placeholder}">
      </div>
    </form>
  </div>
</div>
HTML;

