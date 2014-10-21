$(function() {
  salvattore['init']();

  $(window).scroll (function () {
    if (!$('.ui-panel-dismiss-open').length && (($(document).height() - $(window).height () - $(window).scrollTop ()) < 100)) {
    }
  }).scroll ();


});