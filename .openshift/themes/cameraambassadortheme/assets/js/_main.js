(function( $ ) {

var Roots = {

  //
  // All pages
  //

  common: {
    init: function() {

/*
      var comparing = false,
        $compareBtn = $('.compare-button'),
        $compareCheckbox = $('.compare-checkbox');

      $compareBtn.click(function( e ) {
        var $glyph = $( 'span', this );

        if ( !comparing ) {
          $compareCheckbox.show();

          if ( $glyph.hasClass('glyphicon-list') ) {
            $glyph
              .removeClass('glyphicon-list')
              .addClass('glyphicon-remove');
          }

          comparing = true;
        } else {
          $compareCheckbox.hide();

          if ( $glyph.hasClass('glyphicon-remove') ) {
            $glyph
              .removeClass('glyphicon-remove')
              .addClass('glyphicon-list');
          }

          comparing = false;
        }

        e.preventDefault();
        return false;
      });
*/

      $('.jstooltip').tooltip();

      var $saved = $('.saved'),
        $saver = $('.saver');

      $saved.popover({
        title: 'Saved',
        placement: 'left',
        content: function() {
          return $('h1.entry-title').text();
        },
        trigger: 'manual',
        container: 'body'
      });

      $saver.click(function() {
        var id = $(this).data('id');

        $(window).scrollTop(0);

        $saved.popover('show');
      });

      $saved.click(function() {
        $saved.popover('hide');
      });
    }
  },

  //
  // Home page
  //

  home: {
    init: function() {
      var $sss,
        placeholder,
        $window = $(window),
        $search = $('#search'),
        $searchClass = $('.search'),
        orig_search_placeholder = $search.attr('placeholder'),
        short_search_placeholder = $search.data('placeholder-short');

      //
      // Window resize
      //

      $(window).on( 'resize', function() {
        if (
          Modernizr.mq(
            'only screen and ' +
            '(max-width: 991px) and (min-width: 768px), ' +
            '(max-width: 652px)'
          )
        ) {
          $sss = $search;
          placeholder = short_search_placeholder;
        } else {
          placeholder = orig_search_placeholder;
          $sss = $('.green-screen-bg .intro-content');
        }

        $search.attr( 'placeholder', placeholder );
      }).resize();

      //
      // Search
      //

      var windowChanging = false;

      var cameras = new Bloodhound({
        ttl: 1,
        queryTokenizer: Bloodhound.tokenizers.whitespace,
        datumTokenizer: Bloodhound.tokenizers.obj.whitespace('camera'),
        prefetch: WPURLS.stylesheet_directory_uri + '/data/cameras.json'
      });

      var lenses = new Bloodhound({
        ttl: 1,
        queryTokenizer: Bloodhound.tokenizers.whitespace,
        datumTokenizer: Bloodhound.tokenizers.obj.whitespace('lens'),
        prefetch: WPURLS.stylesheet_directory_uri + '/data/lenses.json'
      });

      lenses.initialize();
      cameras.initialize();

      lenses.clearPrefetchCache();
      cameras.clearPrefetchCache();

      $('.search .typeahead').typeahead({
        highlight: true
      },
      {
        name: 'cameras',
        displayKey: 'camera',
        source: cameras.ttAdapter(),
        templates: {
          header: '<h3 class="product-type">Cameras</h3>'
        }
      },
      {
        name: 'lenses',
        displayKey: 'lens',
        source: lenses.ttAdapter(),
        templates: {
          header: '<h3 class="product-type">Lenses</h3>'
        }
      }).on(
        'typeahead:selected typeahead:autocompleted',
        function( obj, datum ) {
          windowChanging = true;
          window.location.href = datum.link;
        }
      );

      //
      // Handle search enter event
      //

      $search.keyup(function( e ) {
        if ( ( e.keyCode !== 13 ) || windowChanging ) {
          return;
        }

        // cameras.get(
        //   $search.val(),
        //   function( suggestions ) {
        //     $.each(
        //       suggestions,
        //       function( index, value ) {
        //         console.log( value );
        //       }
        //     );
        //   }
        // );

        window.location.href = '/search/' + $search.val();
      });

      //
      // Focus search input when clicking icon
      //

      $('.search .input-group-addon').click(function() {
        $search.focus();
      });

      //
      // Affix plugin the search
      //

      $searchClass.affix({
        offset: {
          top: $searchClass.offset().top
        }
      });

      //
      // On search focus, scroll to $sss
      //

      $search.focus(function() {

        //
        // Don't scroll when affixed
        //

        if ( $searchClass.hasClass('affix') ) {
          return;
        }

        //
        // Scroll to input
        //

        $( 'html, body' ).animate(
          {
            scrollTop: ( $sss.offset().top - 20 )
          },
          'slow'
        );

      });

      /*
      *  render_map
      *
      *  This function will render a Google Map onto the selected jQuery element
      *
      *  @type  function
      *  @date  8/11/2013
      *  @since 4.3.0
      *
      *  @param $el (jQuery element)
      *  @return  n/a
      */

      function render_map( $el ) {

        // var
        var $markers = $el.find('.marker');

        // vars
        var args = {
          zoom    : 16,
          scrollwheel: false,
          center    : new google.maps.LatLng(0, 0),
          mapTypeId : google.maps.MapTypeId.ROADMAP
        };

        // create map
        var map = new google.maps.Map( $el[0], args);

        // add a markers reference
        map.markers = [];

        // add markers
        $markers.each(function(){

            add_marker( $(this), map );

        });

        // center map
        center_map( map );

      }

      /*
      *  add_marker
      *
      *  This function will add a marker to the selected Google Map
      *
      *  @type  function
      *  @date  8/11/2013
      *  @since 4.3.0
      *
      *  @param $marker (jQuery element)
      *  @param map (Google Map object)
      *  @return  n/a
      */

      function add_marker( $marker, map ) {

        // var
        var latlng = new google.maps.LatLng( $marker.attr('data-lat'), $marker.attr('data-lng') );

        // create marker
        var marker = new google.maps.Marker({
          position  : latlng,
          map     : map
        });

        // add to array
        map.markers.push( marker );

        // if marker contains HTML, add it to an infoWindow
        if( $marker.html() )
        {
          // create info window
          var infowindow = new google.maps.InfoWindow({
            content   : $marker.html()
          });

          // show info window when marker is clicked
          google.maps.event.addListener(marker, 'click', function() {

            infowindow.open( map, marker );

          });
        }

      }

      /*
      *  center_map
      *
      *  This function will center the map, showing all markers attached to this map
      *
      *  @type  function
      *  @date  8/11/2013
      *  @since 4.3.0
      *
      *  @param map (Google Map object)
      *  @return  n/a
      */

      function center_map( map ) {

        // vars
        var bounds = new google.maps.LatLngBounds();

        // loop through all markers and create bounds
        $.each( map.markers, function( i, marker ){

          var latlng = new google.maps.LatLng( marker.position.lat(), marker.position.lng() );

          bounds.extend( latlng );

        });

        // only 1 marker?
        if( map.markers.length === 1 )
        {
          // set center of map
            map.setCenter( bounds.getCenter() );
            map.setZoom( 16 );
        }
        else
        {
          // fit to bounds
          map.fitBounds( bounds );
        }

      }

      $('.acf-map').each(function(){

        render_map( $(this) );

      });

    }
  },
  // About us page, note the change from about-us to about_us.
  about_us: {
    init: function() {
      // JavaScript to be fired on the about us page
    }
  }
};

// The routing fires all common scripts, followed by the page specific scripts.
// Add additional events for more control over timing e.g. a finalize event
var UTIL = {
  fire: function(func, funcname, args) {
    var namespace = Roots;
    funcname = (funcname === undefined) ? 'init' : funcname;
    if (func !== '' && namespace[func] && typeof namespace[func][funcname] === 'function') {
      namespace[func][funcname](args);
    }
  },
  loadEvents: function() {
    UTIL.fire('common');

    $.each(document.body.className.replace(/-/g, '_').split(/\s+/),function(i,classnm) {
      UTIL.fire(classnm);
    });
  }
};

$(document).ready(UTIL.loadEvents);

})(jQuery); // Fully reference jQuery after this point.
