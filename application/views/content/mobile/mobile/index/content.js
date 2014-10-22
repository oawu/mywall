$(function() {

  var masonry = new Masonry ('#pictures', { itemSelector: '.picture', columnWidth: 1, transitionDuration: '0.3s', visibleStyle: { opacity: 1, transform: 'none' }});

  var setPictureFeature = function ($obj) {
    $obj.imagesLoaded (function () {
      $obj.find ('.image').css ({'height': $obj.show ().find ('.image img').css ('height')}).imgLiquid ({verticalAlign: "top"});
      $obj.find ('.avatar').imgLiquid ({verticalAlign: "top"});
      $obj.find ('.timeago').timeago ();
      masonry.appended ($obj.get (0)); 
    });
    return $obj;
  }

  var loadPictures = function () {
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
          if (result.next_id < 0) {
            $('#loading').remove ();
          }
          $pictures.data ('next_id', result.next_id);
        }
      })
      .fail (function (result) { ajaxError (result); })
      .complete (function (result) { });
    }
  }


  var loading_height = $('#loading').height ();
  $(window).scroll (function () {
    if (!$('.ui-panel-dismiss-open').length && (($(document).height() - $(window).height () - $(window).scrollTop ()) < loading_height * 2)) {
      loadPictures ();
    }
  }).scroll ();


});