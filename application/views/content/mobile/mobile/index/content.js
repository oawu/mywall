$(function() {
  salvattore['init']();
  var columns = document.querySelector ('#pictures');
  
  var setPictureFeature = function ($obj) {
    $obj.hide ();

    var pin = document.createElement ('article');
    salvattore['append_elements'](columns, [$obj[0]]);
    
    $obj.imagesLoaded (function () {
      $obj.find ('.image').css ({'height': $obj.find ('.image img').css ('height')}).imgLiquid ({verticalAlign: "top"});
      $obj.find ('.avatar').imgLiquid ({verticalAlign: "top"});
      $obj.find ('.timeago').timeago ();
    });
    return $obj.show ();
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
            setPictureFeature ($obj); 

            // var pin = document.createElement ('article');
            
            // salvattore['append_elements'](columns, [pin]);
            // pin.outerHTML = $obj[0].outerHTML;

            // $obj.appendTo ($pictures);
            // setPictureFeature ($obj.hide ()); 
          };
          $pictures.data ('next_id', result.next_id);
        }
      })
      .fail (function (result) { ajaxError (result); })
      .complete (function (result) { });
    }
  }

  $(window).scroll (function () {
    if (!$('.ui-panel-dismiss-open').length && (($(document).height() - $(window).height () - $(window).scrollTop ()) < 100)) {
      loadPictures ();
    }
  }).scroll ();


});