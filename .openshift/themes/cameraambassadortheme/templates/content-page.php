<?php while (have_posts()) : the_post(); ?>
  <?php
  if ( has_post_thumbnail() ) {
    the_post_thumbnail();
  }
  ?>
  <?php the_content(); ?>
  <?php wp_link_pages(array('before' => '<nav class="pagination">', 'after' => '</nav>')); ?>
<?php endwhile; ?>
