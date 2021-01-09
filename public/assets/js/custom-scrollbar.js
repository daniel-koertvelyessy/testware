(function ($) {
  'use strict';

  $(document).on('ready', function () {
    // Custom Scroll
    $('.js-scrollbar').mCustomScrollbar({
      // theme: 'dark-thick',
      theme: 'rounded-dark',
      scrollInertia: 200,
        setTop: 502
    });

    // Scroll to Active
    $('.js-scrollbar').mCustomScrollbar('scrollTo', '.js-scrollbar a.active');
     $('.duik-content').mCustomScrollbar('scrollTo', window.location.hash);
  });
})(jQuery);
