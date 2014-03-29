//
// Make the theme customizer preview reload changes asynchronously
//

(function( $ ) {

  //
  // Site title
  //

  wp.customize(
    'blogname',
    function( value ) {
      value.bind(
        function( to ) {
          $('.brand').text(to);
        }
      );
    }
  );

  //
  // Intro content
  //

  wp.customize(
    'Intro[content]',
    function( value ) {
      value.bind(
        function( to ) {
          $('.intro-content').html(to);
        }
      );
    }
  );

  //
  // Search placeholder
  //

  wp.customize(
    'Search[placeholder]',
    function( value ) {
      value.bind(
        function( to ) {
          $('#search').val('').attr( 'placeholder', to );
        }
      );
    }
  );

  //
  // CTA content
  //

  wp.customize(
    'CTA[content]',
    function( value ) {
      value.bind(
        function( to ) {
          $('.cta-content').html(to);
        }
      );
    }
  );

})( jQuery );
