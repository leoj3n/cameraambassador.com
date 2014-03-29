<?php
get_template_part( 'templates/page', 'header' );

query_posts("{$query_string}&order=ASC&orderby=title");

if ( !have_posts() ) :
  $err = __( 'Sorry, no cameras were found.', 'roots' );

  echo <<<HTML
<div class="alert alert-warning">
  {$err}
</div>
HTML;

  get_search_form();
endif;

$j = 0;

while ( have_posts() ) : the_post();

  $even = ++$j % 2 == 0;

  if ( !$even ) :
    echo <<<HTML
<div class="row">
HTML;
  endif;

  get_template_part( 'templates/content', 'archive-camera' );

  if ( $even ) :
    echo <<<HTML
</div>
HTML;
  endif;
endwhile;

if ( $wp_query->max_num_pages > 1 ) :
  ob_start(); next_posts_link(__( '&larr; Older posts', 'roots' ));
  $next = ob_get_clean();

  ob_start(); previous_posts_link(__( 'Newer posts &rarr;', 'roots' ));
  $prev = ob_get_clean();

  echo <<<HTML
<nav class="post-nav">
  <ul class="pager">
    <li class="previous">
      {$next}
    </li>
    <li class="next">
      {$prev}
    </li>
  </ul>
</nav>
HTML;
endif;

