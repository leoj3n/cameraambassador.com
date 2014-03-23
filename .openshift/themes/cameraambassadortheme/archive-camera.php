<?php get_template_part( 'templates/page', 'header' ); ?>

<?php query_posts($query_string . "&order=ASC&orderby=title"); ?>

<?php
if ( !have_posts() ) : ?>
  <div class="alert alert-warning">
    <?php _e( 'Sorry, no cameras were found.', 'roots' ); ?>
  </div>
  <?php get_search_form(); ?>
<?php endif; ?>

<?php
$j = 0;

while ( have_posts() ) : the_post();

  $even = ++$j % 2 == 0;

  if ( !$even ) : ?>
  <div class="row">
<?php
  endif;

  get_template_part( 'templates/content', 'archive-camera' );

  if ( $even ) : ?>
  </div>
<?php
  endif;
endwhile;
?>

<?php
if ( $wp_query->max_num_pages > 1 ) : ?>
  <nav class="post-nav">
    <ul class="pager">
      <li class="previous">
        <?php next_posts_link(__( '&larr; Older posts', 'roots' )); ?>
      </li>
      <li class="next">
        <?php previous_posts_link(__( 'Newer posts &rarr;', 'roots' )); ?>
      </li>
    </ul>
  </nav>
<?php
endif;

