<article <?php post_class('col-sm-6'); ?>>
  <header>
<?php
      if (
        $img = wp_get_attachment_image_src( get_post_thumbnail_id(), 'medium' )
      ) {
?>
    <a href="<?php the_permalink(); ?>">
      <p class='camera-preview'>
        <span class="btn btn-primary">$<?php the_field('price'); ?></span>
<?php
        printf(
          '<img src="%s" alt="Photo of the %s" class="img-responsive center-block">',
          $img[0],
          get_the_title()
        );
?>
      </p>
    </a>
<?php
      }
?>
    <h2 class="entry-title"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>
  </header>
  <div class="entry-summary hide">
    <?php the_field('description'); ?>
  </div>
</article>

