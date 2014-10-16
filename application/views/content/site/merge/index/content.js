$(function() {
  $('#chos').on ('click', '.sub', function () {
    var $likes = $('#likes'),
        $tags = $('#tags');

    $(this).parents ('.tag').fadeOut (function () {
      $.ajax ({
        url: $('#sub_cho_url').val (),
        data: { group_id: $(this).data ('group_id') },
        async: true, cache: false, dataType: 'json', type: 'POST',
        beforeSend: function () {}
      })
      .done (function (result) {
        if (result.status) {
          $(this).remove ();

          $obj = $(result.content1);
          $obj.appendTo ($likes);
          setTagFeature ($obj.hide ()); 

          $obj = $(result.content2);
          $obj.appendTo ($tags);
          setTagFeature ($obj.hide ()); 
        }
        else
          $(this).fadeIn ();
      }.bind ($(this)))
      .fail (function (result) { ajaxError (result); })
      .complete (function (result) { });
    });
  });

  $('#likes').on ('click', '.add', function () {
    var $chos = $('#chos');

    $(this).parents ('.tag').fadeOut (function () {
      $.ajax ({
        url: $('#get_cho_url').val (),
        data: { main_id: $(this).data ('main'), id: $(this).data ('id') },
        async: true, cache: false, dataType: 'json', type: 'POST',
        beforeSend: function () {}
      })
      .done (function (result) {
        if (result.status && result.contents) {
          $(this).remove ();

          $('#tags .tag[data-id=' + $(this).data ('id') + ']').fadeOut (function () {
            $(this).remove ();
          });

          for (var i = 0; i < result.contents.length; i++) {
            $obj = $(result.contents[i]);
            $obj.appendTo ($chos);
            setTagFeature ($obj.hide ()); 
          };
        } else
          $(this).fadeIn ();
      }.bind ($(this)))
      .fail (function (result) { ajaxError (result); })
      .complete (function (result) { });
    });

  });

  $('#tags').on ('click', '.tag', function () {
    var $likes = $('#likes').empty (),
        $chos  = $('#chos').empty ();

    $('#tags .tag').removeClass ('active');
    $(this).addClass ('active');
    
    $.ajax ({
      url: $('#get_likes_url').val (),
      data: { id: $(this).data ('id') },
      async: true, cache: false, dataType: 'json', type: 'POST',
      beforeSend: function () {}
    })
    .done (function (result) {
      if (result.status && result.content1s && result.content2s) {
        for (var i = 0; i < result.content1s.length; i++) {
          $obj = $(result.content1s[i]);
          $obj.appendTo ($likes);
          setTagFeature ($obj.hide ()); 
        };
        for (var i = 0; i < result.content2s.length; i++) {
          $obj = $(result.content2s[i]);
          $obj.appendTo ($chos);
          setTagFeature ($obj.hide ()); 
        };
        checkScroll ();
      }
    }.bind ($(this)))
    .fail (function (result) { ajaxError (result); })
    .complete (function (result) { });
  });

  var setTagFeature = function ($obj) {
    $obj.imagesLoaded (function () {
      $obj.tooltip ({ track: true, position: { my: "left+10 top+10"}, show: { effect: 'fade', delay: 150 }, content: function () { return $(this).data ('pic') ? $('<img />').css ({'width': '500px'}).attr ('src', $(this).attr ('title')) : $(this).attr ('title'); } });
      $obj.show ();
    });
    return $obj;
  }

  var loadTags = function () {
    $tags = $('#tags');
    if ($tags.data ('next_id') >= 0) {
      $.ajax ({
        url: $('#get_tags_url').val (),
        data: { db_id: $tags.data ('db_id'), next_id: $tags.data ('next_id') },
        async: true, cache: false, dataType: 'json', type: 'POST',
        beforeSend: function () {
          $tags.data ('next_id', -1);
        }
      })
      .done (function (result) {
        if (result.status && result.contents) {
          for (var i = 0; i < result.contents.length; i++) {
            $obj = $(result.contents[i]);
            $obj.appendTo ($tags);
            setTagFeature ($obj.hide ()); 
          };
          $tags.data ('next_id', result.next_id);
          checkScroll ();
        }
      })
      .fail (function (result) { ajaxError (result); })
      .complete (function (result) { });
    }
  }

  var checkScroll = function () {
    var footer_height = $("#footer").height ();
    $(window).scroll (function () {
      if ($(document).height() - $(window).height () - $(window).scrollTop () < footer_height)
        loadTags ();
    });
  }
  loadTags ();
});