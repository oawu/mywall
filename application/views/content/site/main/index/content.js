$(function() {
  var is_blur_num = 2;
  $('#promo1').mouseenter (function () {
    var $text = $(this).find ('.promo1_text'),
        top = parseFloat ($(this).height ()) - parseFloat ($text.height ()) - 5,
        is_blur = top < (parseFloat ($(this).height ()) / is_blur_num);
    $text.stop ().animate ({'top': (top < 0 ? 0 : top) + 'px'}, {
      duration: 500,
      easing: 'swing',
      step: function () {
        if (is_blur)
          $('#promo1').children ().not ('div.promo1_text').addClass ('blur');
    }});
  }).mouseleave (function () {
    var $text = $(this).find ('.promo1_text'),
        is_blur = (parseFloat ($(this).height ()) - parseFloat ($text.height ()) - 5) < (parseFloat ($(this).height ()) / is_blur_num);
    $text.stop ().animate ({'top': '298px'}, {
      duration: 500,
      easing: 'swing',
      step: function () {
        if (is_blur)
          $('#promo1').children ().not ('div.promo1_text').removeClass ('blur');
    }});
  });
  $('#promo6').mouseenter (function () {
    var $text = $(this).find ('.promo6_text'),
        top = parseFloat ($(this).height ()) - parseFloat ($text.height ()) - 22,
        is_blur = top < (parseFloat ($(this).height ()) / is_blur_num);
    $text.stop ().animate ({'top': (top < 0 ? 0 : top) + 'px'}, {
      duration: 500,
      easing: 'swing',
      step: function () {
        if (is_blur)
          $('#promo6').children ().not ('div.promo6_text').addClass ('blur');
    }});
  }).mouseleave (function () {
    var $text = $(this).find ('.promo6_text'),
        is_blur = (parseFloat ($(this).height ()) - parseFloat ($text.height ()) - 22) < (parseFloat ($(this).height ()) / is_blur_num);
    $text.stop ().animate ({'top': '280px'}, {
      duration: 500,
      easing: 'swing',
      step: function () {
        if (is_blur)
          $('#promo6').children ().not ('div.promo6_text').removeClass ('blur');
    }});
  });

  $('#promo1 .promo1_img, #promo2, #promo3, #promo4, #promo5, #promo6 .promo6_img').imgLiquid ({ verticalAlign: 'top' });

  var masonry = new Masonry ('#pictures', { itemSelector: '.picture', columnWidth: 1, transitionDuration: '0.3s', visibleStyle: { opacity: 1, transform: 'none' }});

  var setPictureFeature = function ($obj) {
    $obj.imagesLoaded (function () {
      $obj.find ('.picture_pic').css ({'height': $obj.show ().find ('.picture_pic img').css ('height')}).imgLiquid ({verticalAlign: "top"});
      $obj.find ('.picture_user_avatar').imgLiquid ({verticalAlign: "top"});
      $obj.find ('.timeago').timeago ();
      masonry.appended ($obj.get (0)); 
    });
    return $obj;
  }

  var loadPicture = function () {
    $pictures = $('#pictures');
    if ($pictures.data ('next_id') >= 0) {
      $.ajax ({
        url: $('#get_pictures_url').val (),
        data: { next_id: $pictures.data ('next_id') },
        async: true, cache: false, dataType: 'json', type: 'POST',
        beforeSend: function () {
          $pictures.data ('next_id', -1);
        }
      })
      .done (function (result) {
        if (result.status && result.contents) {
          for (var i = 0; i < result.contents.length; i++) {
            $obj = $(result.contents[i]);
            $obj.appendTo ($pictures);
            setPictureFeature ($obj.hide ()); 
          };
          $pictures.data ('next_id', result.next_id);
        }
      })
      .fail (function (result) { console.info (result.responseText); })
      .complete (function (result) { });
    }
  }

  var footer_height = $("#footer").height ();
  $(window).scroll (function () {
    if ($(document).height() - $(window).height () - $(window).scrollTop () < footer_height)
      loadPicture ();
  }).scroll ();
});