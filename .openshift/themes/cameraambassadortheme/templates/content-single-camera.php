<?php while (have_posts()) : the_post(); ?>
  <article <?php post_class(); ?>>
    <header>
      <h1 class="entry-title"><?php the_title(); ?> (Camera)</h1>
      <p class="lead"><?php the_field('caption'); ?></p>
<?php
      if (
        $img = wp_get_attachment_image_src( get_post_thumbnail_id(), 'large' )
      ) {
        printf(
          '<img src="%s" alt="Photo of the %s" class="img-responsive">',
          $img[0],
          get_the_title()
        );
      } ?>

    </header>
    <div class="entry-content">
      <p>
        <?php the_field('description'); ?>
      </p>
      <section class="specs">
        <h2>Specs</h2>
        <table class="table">
          <tr>
            <td>Price</td>
            <td><?php the_field('price'); ?> USD per day</td>
          </tr>

          <tr>
            <td>Weight</td>
            <td><?php the_field('weight'); ?> lbs. Body only</td>
          </tr>

<?php
          $rows = array(
              array( 'Sensor Size', get_field('sensor_size') ),
              array( 'Base D ISO', get_field('base_d_iso') ),
              array( 'Latitude', get_field('latitude') ),
              array( 'Frame Rate', get_field('frame_rate') ),
              array( 'Resolution', get_field('resolution') ),
              array( 'Bitrate/Format/Time', get_field('bitrate_format_time') ),
              array( 'Data', get_field('data') )
            );

          foreach( $rows as $key => $row ) {
            if ( empty($row[ 1 ]) ) {
              continue;
            } ?>

            <tr>
              <td><?php echo $row[ 0 ]; ?></td>
              <td><?php echo $row[ 1 ]; ?></td>
            </tr>
<?php
          } ?>

        </table>
      </section>
    </div>
    <footer>
      <?php wp_link_pages(array('before' => '<nav class="page-nav"><p>' . __('Pages:', 'roots'), 'after' => '</p></nav>')); ?>
    </footer>
    <?php comments_template('/templates/comments.php'); ?>
  </article>
<?php endwhile; ?>
