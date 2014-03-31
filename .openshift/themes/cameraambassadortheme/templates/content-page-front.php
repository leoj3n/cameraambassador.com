<?php

$cta = get_theme_mod('CTA');
$location = get_field('location');
$team_content = get_field('section_2');
$location_content = get_field('section_1');
$assets = get_template_directory_uri() . '/assets';

#
# Location map
#

if ( !empty($location) ) :
  $lat = $location[ 'lat' ];
  $lng = $location[ 'lng' ];

  echo <<<HTML
<section class="section_2">
  <div class="container">
    {$location_content}
    <div class="row">
      <div class="col-sm-12">
        <div class="acf-map">
          <div class="marker" data-lat="{$lat}" data-lng="{$lng}"></div>
        </div>
      </div>
    </div>
  </div>
</section>
HTML;
endif;

// if ( $cta[ 'content' ] ) :
//   echo <<<HTML
// <section class="cta">
//   <div class="container">
//     <div class="cta-content">
//       {$cta[ 'content' ]}
//     </div>
//   </div>
// </section>
// HTML;
// endif;

#
# Team help
#
# @TODO: Use repeater ACF for employee images, or use user profile images
#

echo <<<HTML
<section class="section_1">
  <div class="container">
    <div class="row">
      <div class="col-sm-4 col-sm-push-8">
        <div class="team-content">
          {$team_content}
        </div>
      </div>
      <div class="col-sm-8 col-sm-pull-4 hidden-xs">
        <ol>
          <li>
            <img
              alt="Eirca"
              src="http://api.randomuser.me/0.3.2/portraits/women/16.jpg">
              <b>Erica Duffy</b>
          </li>
          <li>
            <img
              alt="Jake"
              src="http://api.randomuser.me/0.3.2/portraits/men/30.jpg">
              <b>Jacob Archebold</b>
          </li>
          <li>
            <img
              alt="Amir"
              src="http://api.randomuser.me/0.3.2/portraits/men/1.jpg">
              <b>Amir Stuart</b>
          </li>
        </ol>
      </div>
    </div>
  </div>
</section>
HTML;

