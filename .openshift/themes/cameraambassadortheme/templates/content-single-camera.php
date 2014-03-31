<?php
while ( have_posts() ) : the_post();

ob_start(); post_class();
$class = ob_get_clean();

$id = get_the_ID();
$title = get_the_title();
$price = get_field('price');
$weight = get_field('weight');
$caption = get_field('caption');
$desc = get_field('description');
$popularity = ( get_field('popularity') * 10 );

echo <<<HTML
<article {$class}>
  <header>
    <h1 class="entry-title"><span>{$title}</span> (Camera)</h1>
    <p class="lead">{$caption}</p>
HTML;

if (
  $img = wp_get_attachment_image_src( get_post_thumbnail_id(), 'large' )
) :
  echo <<<HTML
        <img
          src="{$img[ 0 ]}"
          alt="Photo of the {$title}"
          class="img-responsive img-rounded">
HTML;
endif;

echo <<<HTML
  </header>
  <div class="well well-lg">
HTML;

if ( get_field('coming_soon') ) :
  echo <<<HTML
    <div class="alert alert-warning">
      <em>Not here yet!</em> This product is coming soon.
    </div>
HTML;
else:
  echo <<<HTML
    <button type="button" class="btn btn-lg btn-primary btn-block" data-toggle="modal" data-target="#rentModal">
      Rent this camera
    </button>
    <button type="button" class="btn btn-default btn-block jstooltip saver" data-toggle="tooltip" data-placement="bottom" title="Save for later" data-id="{$id}">
      Save <span class="glyphicon glyphicon-camera"></span>
    </button>

    <div class="modal fade" id="rentModal">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
            <h4 class="modal-title">{$title}</h4>
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
              Request camera
            </button>
          </div>
        </div><!-- /.modal-content -->
      </div><!-- /.modal-dialog -->
    </div><!-- /.modal -->
HTML;
endif;

echo <<<HTML
  </div>
  <div class="entry-content well well-lg">
    <p>{$desc}</p>
    <section class="specs">
      <h2>Specs</h2>
      <table class="table">
        <tr>
          <td>Price</td>
          <td>{$price} USD per day</td>
        </tr>

        <tr>
          <td>Weight</td>
          <td>{$weight} lbs. Body only</td>
        </tr>

        <tr>
          <td>Popularity</td>
          <td>
            <div class="progress progress-striped active">
              <div
                class="progress-bar"
                role="progressbar"
                aria-valuenow="{$popularity}"
                aria-valuemin="0"
                aria-valuemax="100"
                style="width: {$popularity}%">
                <span class="sr-only">{$popularity}% Complete</span>
              </div>
            </div>
          </td>
        </tr>
HTML;

$rows = array(
    array( 'Sensor Size', get_field('sensor_size') ),
    array( 'Base D ISO', get_field('base_d_iso') ),
    array( 'Latitude', get_field('latitude') ),
    array( 'Frame Rate', get_field('frame_rate') ),
    array( 'Resolution', get_field('resolution') ),
    array( 'Bitrate/Format/Time', get_field('bitrate_format_time') ),
    array( 'Data', get_field('data') )
  );

foreach ( $rows as $key => $row ) :
  if ( empty($row[ 1 ]) ) :
    continue;
  endif;

  echo <<<HTML
        <tr>
          <td>{$row[ 0 ]}</td>
          <td>{$row[ 1 ]}</td>
        </tr>
HTML;
endforeach;

ob_start();
wp_link_pages(
  array(
    'before' => '<nav class="page-nav"><p>' . __( 'Pages:', 'roots' ),
    'after' => '</p></nav>'
  )
);
$link_pages = ob_get_clean();

ob_start(); comments_template('/templates/comments.php');
$comments = ob_get_clean();

echo <<<HTML
      </table>
    </section>
  </div><!-- /.entry-content -->
  <footer>
    {$link_pages}
  </footer>
  {$comments}
</article>
HTML;

endwhile;

