<?php
while ( have_posts() ) : the_post(); ?>
  <article <?php post_class(); ?>>
    <header>
      <h1 class="entry-title"><?php the_title(); ?> (Camera)</h1>
      <p class="lead"><?php the_field('caption'); ?></p>
      <div class="well well-lg">

<?php
      if (
        $img = wp_get_attachment_image_src( get_post_thumbnail_id(), 'large' )
      ) {
        printf(
          '<img src="%s" alt="Photo of the %s" class="img-responsive">',
          $img[0],
          get_the_title()
        );
      }

      if ( get_field('coming_soon') ) : ?>

        <div class="alert alert-warning"><em>Not here yet!</em> This product is coming soon.</div>

<?php
      else: ?>

          <button type="button" class="btn btn-lg btn-primary btn-block" data-toggle="modal" data-target="#rentModal">
            Rent this camera
          </button>
          <button type="button" class="btn btn-default jstooltip btn-block" data-toggle="tooltip" data-placement="bottom" title="Save for later">
            Save <span class="glyphicon glyphicon-camera"></span>
          </button>

          <div class="modal fade" id="rentModal">
            <div class="modal-dialog">
              <div class="modal-content">
                <div class="modal-header">
                  <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                  <h4 class="modal-title">Rent the <?php the_title(); ?></h4>
                </div>
                <div class="modal-body">
                  <form role="form">
                    <div class="form-group">
                      <label for="exampleInputEmail1">Email address</label>
                      <input type="email" class="form-control" id="exampleInputEmail1" placeholder="Enter email">
                    </div>
                    <div class="form-group">
                      <label for="exampleInput1">Number of days</label>
                      <input type="text" class="form-control" id="exampleInput1" placeholder="e.g. 7 days">
                    </div>
                    <div class="form-group">
                      <label for="exampleInput2">Additional details</label>
                      <textarea class="form-control" rows="3" id="exampleInput2"></textarea>
                    </div>
                  </form>
                </div>
                <div class="modal-footer">
                  <button type="button" class="btn btn-primary">
                    Request this camera
                  </button>
                </div>
              </div><!-- /.modal-content -->
            </div><!-- /.modal-dialog -->
          </div><!-- /.modal -->

<?php
      endif; ?>

      </div>

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

          <tr>
            <td>Popularity</td>
            <td>
              <div class="progress progress-striped active">
                <div class="progress-bar" role="progressbar" aria-valuenow="45" aria-valuemin="0" aria-valuemax="100" style="width: <?php echo ( get_field('popularity') * 10 ); ?>%">
                  <span class="sr-only"><?php echo ( get_field('popularity') * 10 ); ?>% Complete</span>
                </div>
              </div>
            </td>
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

<?php
endwhile; ?>

