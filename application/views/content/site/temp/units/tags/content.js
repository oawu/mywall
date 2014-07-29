$(function() {
  $('.unit').hide ();
  $('.units').each (function () {
    var $that = $(this);
    $(this).imagesLoaded (function () {
      $that.find ('.unit').each (function () { $(this).show ().css ({'height': $(this).children ('.main_picture').css ('height')}).imgLiquid ({verticalAlign: "top"}); });
      var masonry = $that.masonry ({ itemSelector: '.unit', columnWidth: 1, transitionDuration: '0.3s', visibleStyle: { opacity: 1, transform: 'none' }});
    });
  });
});
