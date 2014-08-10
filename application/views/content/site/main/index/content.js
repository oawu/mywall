$(function() {
  $('#promo1, #promo2, #promo3, #promo4, #promo5, #promo6').imgLiquid ({ verticalAlign: 'top' });
  
  // var masonry = $('#shares').masonry ({
  //   itemSelector: '.share',
  //   columnWidth: 1,
  //   transitionDuration: '0.3s',
  //   visibleStyle: {
  //     opacity: 1,
  //     transform: 'none'
  //   }
  // });
  var masonry = null;

    $('#shares .share').hide ().each (function () {
      var $that = $(this);
      $that.imagesLoaded (function () {
        masonry = masonry ? masonry : new Masonry ('#shares', { itemSelector: '.share', columnWidth: 1, transitionDuration: '0.3s', visibleStyle: { opacity: 1, transform: 'none' }})
        $that.find ('.share_pic').css ({'height': parseFloat ($that.fadeIn ().find ('.share_pic img').css ('height')) + 'px'}).imgLiquid ({verticalAlign: "top"});
        $that.find ('.share_user_avatar').imgLiquid ({verticalAlign: "top"});
        masonry.layout ();
      });
    });
    
});