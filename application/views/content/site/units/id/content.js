$(function() {
  var setCommentFeature = function ($comment) {
    if (typeof FB !== 'undefined') FB.XFBML.parse ($comment.find ('.like').get (0));
    $comment.find ('.comment_user_pic').imgLiquid ({verticalAlign: "center"});
    $comment.find ('.created_at').timeago ();
    $comment.find ('.delete_comment button').click (function () {
      var unit_comment_id = $(this).data ('unit_comment_id');
      var $that = $(this);
      $that.bs_button ('loading');

      $.ajax ({
        url: $('#delete_unit_comment_url').val (),
        data: { unit_comment_id: unit_comment_id },
        async: true, cache: false, dataType: 'json', type: 'POST',
        beforeSend: function () {
          $that.bs_button ('loading');
        }
      })
      .done (function (result) {
        $that.bs_button ('reset');
        showAlert (result.title, result.message, eval ('(' + result.action + ')'));
      })
      .fail (function (result) { ajaxError (result); })
      .complete (function (result) { });

    });
    
    return $comment;
  }

  $('#comment_list .comment').each (function () { setCommentFeature ($(this)); });

  $('.unit').imgLiquid ({verticalAlign: "center"});
  $('.user_pic').imgLiquid ({verticalAlign: "center"});
  $('.content_picture').imgLiquid ({verticalAlign: "center"});
  $('.content_1_picture').imgLiquid ({verticalAlign: "center"});
  $('.user_info .created_at').timeago ();

  $('#delete_unit').click (function () {
     var unit_id = $(this).data ('unit_id');
     var $that = $(this);

     $.ajax ({
      url: $('#delete_unit_url').val (),
      data: { unit_id: unit_id },
      async: true, cache: false, dataType: 'json', type: 'POST',
      beforeSend: function () {
        $that.bs_button ('loading');
      }
    })
    .done (function (result) {
      $that.bs_button ('reset');
      showAlert (result.title, result.message, eval ('(' + result.action + ')'));
    })
    .fail (function (result) { ajaxError (result); })
    .complete (function (result) { });
  });

  var push_advice_message = function (message, unit_advice_id) {
    if (message.length) {
      $.ajax ({
        url: $('#push_advice_message_url').val (),
        data: { unit_advice_id: unit_advice_id, message: message },
        async: true, cache: false, dataType: 'json', type: 'POST',
        beforeSend: function () { }
      })
      .done (function (result) {
        $.jGrowl (result.message, {theme: 'j_growl', easing: "easeInExpo"});
      })
      .fail (function (result) { ajaxError (result); })
      .complete (function (result) { });
    }
  }

  var fetchStarDetails = function (unit_id) {
    if (unit_id > 0) {
      var $star_details = null;

      $.ajax ({
        url: $('#fetch_star_details_url').val (),
        data: { unit_id: unit_id },
        async: true, cache: false, dataType: 'json', type: 'POST',
        beforeSend: function () { if (!($star_details = $('.star_details')).length) $star_details = $('<div />').addClass ('star_details').css ({'background': 'url(data:image/gif;base64,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) no-repeat center center'}).prependTo ($('.other_panel')); }
      })
      .done (function (result) {
        $star_details.remove ();  
        if (result.status) {
          $star_details = $(result.star_details).prependTo ($('.other_panel'));
          $('#set_score').empty ().css ({'background': 'transparent'}).append ($(result.score_star));
          initSetScoreStar ();
        }
      })
      .fail (function (result) { ajaxError (result); })
      .complete (function (result) { });
    }
  }

  var initSetScoreStar = function () {
    $('#set_score').find ('span[class*=icon-star]').mouseenter (function () {
      $(this).siblings ('span').andSelf ().removeClass ().addClass ('icon-star4');
      $(this).prevAll ('span').andSelf ().removeClass ('icon-star4').addClass ('icon-star6').addClass ('select_star');
    }).mouseleave (function () {
      $(this).siblings ('span').andSelf ().each (function () {
        $(this).removeClass ().addClass ($(this).data ('class'))  
      });
    }).click (function () {

      var $set_score = $('#set_score');

      if ($set_score.data ('is_sign_in')) {
        if (!$set_score.data ('is_set_scored')) {
          $.ajax ({
            url: $('#set_score_url').val (),
            data: { unit_id: $set_score.data ('unit_id'), score: $(this).index () + 1 },
            async: true, cache: false, dataType: 'json', type: 'POST',
            beforeSend: function () { 
              $set_score.find ('span[class*=icon-star]').hide ();
              $set_score.css ({'background': 'url(data:image/gif;base64,R0lGODlhEAALAPQAANnf6ztamsLL3rvG28vU5D5cmztamldxqIudw3aLt6271VBqpGh/sY+ixXiNubC81VJtpT1bmmqCssnR4sDK3tLZ51x3q8LN39DY5qu4052tzLjD2c7V5QAAAAAAAAAAACH/C05FVFNDQVBFMi4wAwEAAAAh/hpDcmVhdGVkIHdpdGggYWpheGxvYWQuaW5mbwAh+QQJCwAAACwAAAAAEAALAAAFLSAgjmRpnqSgCuLKAq5AEIM4zDVw03ve27ifDgfkEYe04kDIDC5zrtYKRa2WQgAh+QQJCwAAACwAAAAAEAALAAAFJGBhGAVgnqhpHIeRvsDawqns0qeN5+y967tYLyicBYE7EYkYAgAh+QQJCwAAACwAAAAAEAALAAAFNiAgjothLOOIJAkiGgxjpGKiKMkbz7SN6zIawJcDwIK9W/HISxGBzdHTuBNOmcJVCyoUlk7CEAAh+QQJCwAAACwAAAAAEAALAAAFNSAgjqQIRRFUAo3jNGIkSdHqPI8Tz3V55zuaDacDyIQ+YrBH+hWPzJFzOQQaeavWi7oqnVIhACH5BAkLAAAALAAAAAAQAAsAAAUyICCOZGme1rJY5kRRk7hI0mJSVUXJtF3iOl7tltsBZsNfUegjAY3I5sgFY55KqdX1GgIAIfkECQsAAAAsAAAAABAACwAABTcgII5kaZ4kcV2EqLJipmnZhWGXaOOitm2aXQ4g7P2Ct2ER4AMul00kj5g0Al8tADY2y6C+4FIIACH5BAkLAAAALAAAAAAQAAsAAAUvICCOZGme5ERRk6iy7qpyHCVStA3gNa/7txxwlwv2isSacYUc+l4tADQGQ1mvpBAAIfkECQsAAAAsAAAAABAACwAABS8gII5kaZ7kRFGTqLLuqnIcJVK0DeA1r/u3HHCXC/aKxJpxhRz6Xi0ANAZDWa+kEAA7AAAAAAAAAAAA) no-repeat center center'});
            }
          })
          .done (function (result) {
            if (result.status) {
              $.jGrowl (result.message, {theme: 'j_growl', easing: "easeInExpo"});
              $set_score.data ('is_set_scored', 1);
              fetchStarDetails ($set_score.data ('unit_id'));
            } else {
              $set_score.find ('span[class*=icon-star]').show ();
              $set_score.css ({'background': 'transparent'});
              showConfirm (result.title, result.message, eval ('(' + result.action + ')'));
            }
          })
          .fail (function (result) { ajaxError (result); })
          .complete (function (result) { });
        } else { $.jGrowl ('你已經評過分數囉!', { theme: 'j_growl', easing: "easeInExpo"}); }
      } else { showConfirm ('提示', '你還沒登入喔！趕快按下確定，就可以輕鬆使用 Facebook 登入評分囉!', function () { window.location.assign ($('#fb_sing_in_url').val ()); }); }
    });
  }
  
  $('#advice_unit').click (function () {
     var unit_id = $(this).data ('unit_id');
     var $that = $(this);

     $.ajax ({
      url: $('#advice_unit_url').val (),
      data: { unit_id: unit_id },
      async: true, cache: false, dataType: 'json', type: 'POST',
      beforeSend: function () {
        $that.bs_button ('loading');
      }
    })
    .done (function (result) {
      $that.bs_button ('reset');
      showAlert (result.title, result.message, eval ('(' + result.action + ')'));
      // $.jGrowl (result.message, {theme: 'j_growl', easing: "easeInExpo"});
    })
    .fail (function (result) { ajaxError (result); })
    .complete (function (result) { });
  });


  

  $('#submit_comment').click (function () {
    var $that = $(this);
    var user_id = $that.data ('user_id');
    var unit_id = $that.data ('unit_id');
    var message = $('#comment_text').val ();
    var sync_fb = $('#sync_fb').is (":checked");

    if ((message.length) && (message != '')) {
      $.ajax ({
        url: $('#submit_comment_url').val (),
        data: { user_id: user_id, unit_id: unit_id, sync_fb: sync_fb, message: message },
        async: true, cache: false, dataType: 'json', type: 'POST',
        beforeSend: function () { 
          $that.bs_button ('loading');
          $('#comment_text').hide ();
          $('#comment_loadding').show ();
        }
      })
      .done (function (result) {
        $('#comment_loadding').hide ();

        if (result.status) $('#comment_text').val ('').show ();
        else $('#comment_text').show ();

        $('#comment_result_message').stop ().empty ().text (result.message).addClass (result.status ? 'alert-info' : 'alert-danger').show (function () {
          setTimeout (function () {
            $that.bs_button ('reset');
            $('#comment_result_message').removeClass ('alert-danger').removeClass ('alert-info').hide ();
          }, 2000);
        });

        if (result.status && result.content) {
          var $comment = setCommentFeature ($(result.content)).prependTo ($('#comment_list')).hide ().show ('blind');
        }
        $("html, body").animate({ scrollTop: '+=130px' }, "slow");
      })
      .fail (function (result) { ajaxError (result); })
      .complete (function (result) { });
    }
  });


  $('#create_comment').click (function () {
    $(this).bs_button ('loading');
    window.location.assign ($('#fb_sing_in_url').val ());
  });

  $('#read_more_comment').click (function () {
    var $that = $(this);
    var unit_id = $that.data ('unit_id');
    var next_id = $that.data ('next_id');

    if (unit_id > 0 && next_id > 0) {
      $.ajax ({
        url: $('#read_more_comment_url').val (),
        data: { unit_id: unit_id, next_id: next_id },
        async: true, cache: false, dataType: 'json', type: 'POST',
        beforeSend: function () { 
          $that.bs_button ('loading');
        }
      })
      .done (function (result) {console.info (result);
        $that.bs_button ('reset');
        if (result.status && result.contents) {

          for (var i = 0; i < result.contents.length; i++) {
            var $comment = setCommentFeature ($(result.contents[i])).appendTo ($('#comment_list')).hide ().show ('blind');
          };

          if (result.next_id > 0) $that.data ('next_id', result.next_id);
          else $that.remove ();
          
          $("html, body").animate({ scrollTop: '+=250px' }, "slow");

        } else { $that.remove (); }
      })
      .fail (function (result) { ajaxError (result); })
      .complete (function (result) { });
    }
  });

  initSetScoreStar ();
});

function initialize () {
  var markerLatLng = new google.maps.LatLng ($('#map').data ('latitude'), $('#map').data ('longitude'));

  var mapOptions = {
    zoom: 17,
    scaleControl: false,
    navigationControl: false,
    mapTypeControl: false,
    zoomControl: false,
    draggable: false,
    scrollwheel: false,
    streetViewControl: typeof $('#view').get (0) !== 'undefined',
    center: markerLatLng
  };
  var map = new google.maps.Map ($('#map').get (0), mapOptions);
  
  var marker = new google.maps.Marker ({
      map: map,
      draggable: false,
    });
  
  map.panTo (markerLatLng);
  marker.setPosition (markerLatLng);

  if (typeof $('#view').get (0) !== 'undefined') {
    var panoramaOptions = {
      position: new google.maps.LatLng ($('#view').data ('latitude'), $('#view').data ('longitude')),
      linksControl: true,
      addressControl: false,
      pov: {
        heading: $('#view').data ('heading'),
        pitch: $('#view').data ('pitch'),
        zoom: $('#view').data ('zoom')
      }
    };
    var panorama = new  google.maps.StreetViewPanorama ($('#view').get (0), panoramaOptions);
    map.setStreetView (panorama);
  } else if ($('#main_picture').length) {
    $('#main_picture').parents ('.picture_panel').imgLiquid ({verticalAlign: "center"});
  }

  // initializeControlPanel ();
}

google.maps.event.addDomListener(window, 'load', initialize);
