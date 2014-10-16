$(function() {
  $('#tags').on ('click', '.delete', function () {
    $(this).parents ('.tag').fadeOut (function () {
      $.ajax ({
        url: $('#del_trash_url').val (),
        data: { id: $(this).data ('id') },
        async: true, cache: false, dataType: 'json', type: 'POST',
        beforeSend: function () {}
      })
      .done (function (result) {
        if (result.status)
          $(this).remove ();
        else
          $(this).fadeIn ();
      }.bind ($(this)))
      .fail (function (result) { ajaxError (result); })
      .complete (function (result) { });
    });
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
        url: $('#get_trashs_url').val (),
        data: { next_id: $tags.data ('next_id') },
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