<?php
ob_start(); post_class('col-sm-6');
$class = ob_get_clean();

$title = get_the_title();
$price = get_field('price');
$permalink = get_permalink();
$desc = get_field('description');

echo <<<HTML
<article {$class}>
  <div class="inner">
    <header>
      <h2 class="entry-title"><a href="{$permalink}">{$title}</a></h2>
HTML;

if (
  $img = wp_get_attachment_image_src( get_post_thumbnail_id(), 'medium' )
) :
  echo <<<HTML
      <a href="{$permalink}">
        <p class='lens-preview'>
          <span class="btn btn-primary">$ {$price}</span>
          <img
            src="{$img[ 0 ]}"
            alt="Photo of the {$title}"
            class="img-responsive center-block">
        </p>
      </a>
HTML;
endif;

echo <<<HTML
    </header>
    <div class="entry-summary">
      {$desc}
    </div>
  </div><!-- /.inner -->
</article>
HTML;

