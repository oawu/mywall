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

  $('#set_score').click (function () {
    var initSetScore = function ($set_score, user_id) {
      for (var i = 0; i < 5; i++) $("<span class='icon-star4'></span>").appendTo ($set_score);

      $set_score.find ('.icon-star4').mouseenter (function () {
        $(this).prevAll ('span').andSelf ().removeClass ('icon-star4').addClass ('icon-star6');
      }).mouseleave (function () {
        $(this).siblings ('span').andSelf ().removeClass ('icon-star6').addClass ('icon-star4');
      }).click (function () {
        $.ajax ({
          url: $('#set_score_url').val (),
          data: { unit_id: $set_score.data ('unit_id'), user_id: user_id, score: $(this).index () + 1 },
          async: true, cache: false, dataType: 'json', type: 'POST',
          beforeSend: function () { 
            $set_score.empty ().css ({'background': 'url(data:image/gif;base64,R0lGODlhEAALAPQAANnf6ztamsLL3rvG28vU5D5cmztamldxqIudw3aLt6271VBqpGh/sY+ixXiNubC81VJtpT1bmmqCssnR4sDK3tLZ51x3q8LN39DY5qu4052tzLjD2c7V5QAAAAAAAAAAACH/C05FVFNDQVBFMi4wAwEAAAAh/hpDcmVhdGVkIHdpdGggYWpheGxvYWQuaW5mbwAh+QQJCwAAACwAAAAAEAALAAAFLSAgjmRpnqSgCuLKAq5AEIM4zDVw03ve27ifDgfkEYe04kDIDC5zrtYKRa2WQgAh+QQJCwAAACwAAAAAEAALAAAFJGBhGAVgnqhpHIeRvsDawqns0qeN5+y967tYLyicBYE7EYkYAgAh+QQJCwAAACwAAAAAEAALAAAFNiAgjothLOOIJAkiGgxjpGKiKMkbz7SN6zIawJcDwIK9W/HISxGBzdHTuBNOmcJVCyoUlk7CEAAh+QQJCwAAACwAAAAAEAALAAAFNSAgjqQIRRFUAo3jNGIkSdHqPI8Tz3V55zuaDacDyIQ+YrBH+hWPzJFzOQQaeavWi7oqnVIhACH5BAkLAAAALAAAAAAQAAsAAAUyICCOZGme1rJY5kRRk7hI0mJSVUXJtF3iOl7tltsBZsNfUegjAY3I5sgFY55KqdX1GgIAIfkECQsAAAAsAAAAABAACwAABTcgII5kaZ4kcV2EqLJipmnZhWGXaOOitm2aXQ4g7P2Ct2ER4AMul00kj5g0Al8tADY2y6C+4FIIACH5BAkLAAAALAAAAAAQAAsAAAUvICCOZGme5ERRk6iy7qpyHCVStA3gNa/7txxwlwv2isSacYUc+l4tADQGQ1mvpBAAIfkECQsAAAAsAAAAABAACwAABS8gII5kaZ7kRFGTqLLuqnIcJVK0DeA1r/u3HHCXC/aKxJpxhRz6Xi0ANAZDWa+kEAA7AAAAAAAAAAAA) no-repeat center center'});
          }
        })
        .done (function (result) {
            $set_score.empty ().css ({'background': 'transparent'}).text (result.message);
          
          if (result.status) {
            setTimeout (function () {
              $set_score.empty ();
            }, 1500);
          } else {
            setTimeout (function () {
              initSetScore ($set_score.empty ().css ({'background': 'transparent'}), user_id);
            }, 1500);
          }
        })
        .fail (function (result) { ajaxError (result); })
        .complete (function (result) { });
      });
    }

    var $set_score = $(this).parents ('.set_score');
    var user_id    = $(this).data ('user_id');
    $(this).remove ();

    initSetScore ($set_score, user_id);
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
