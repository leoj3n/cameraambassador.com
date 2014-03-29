<?php

$search = get_theme_mod('Search');

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
          placeholder="{$search[ 'placeholder' ]}">
      </div>
    </form>
  </div>
</div>
HTML;

