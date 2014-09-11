(function(d, s, id) {
  var js, fjs = d.getElementsByTagName(s)[0];
  if (d.getElementById(id)) return;
  js = d.createElement(s); js.id = id;
  js.src = "//connect.facebook.net/zh_TW/all.js#xfbml=1&appId=1482020658677319";
  fjs.parentNode.insertBefore(js, fjs);
}(document, 'script', 'facebook-jssdk'));

window.fbAsyncInit = function() {
    FB.init({
      appId      : '513554562067842',
      channelUrl : '//style.ioa.tw',
      status     : true,
      cookie     : true,
      xfbml      : true
    });

  // FB.Event.subscribe('edge.create', function(url) {
  //   $.ajax ({
  //         url: $('#create_like_count_url').val (),
  //         data: { url: url },
  //         async: true, cache: false, dataType: 'json', type: 'POST',
  //         beforeSend: function () { }
  //       })
  //       .done (function (result) { })
  //       .fail (function (result) { ajaxError (result); })
  //       .complete (function (result) { });
  // });

  // FB.Event.subscribe('edge.remove', function(url, widget) {
  //   $.ajax ({
  //         url: $('#remove_like_count_url').val (),
  //         data: { url: url },
  //         async: true, cache: false, dataType: 'json', type: 'POST',
  //         beforeSend: function () { }
  //       })
  //       .done (function (result) { })
  //       .fail (function (result) { ajaxError (result); })
  //       .complete (function (result) { });
  // });
};

$(function () {
  if ($('#tag_category_top').length) {
    var $tag_category_top = $('#tag_category_top'), tag_category_top_top = parseFloat ($tag_category_top.offset ().top), tag_category_top_width = parseFloat ($tag_category_top.width ()), tag_category_top_margin = $tag_category_top.css ('margin');
    var containerWidth = parseFloat ($('#container').width ()) + parseFloat ($('#container').css ('border-top-width')) + parseFloat ($('#container').css ('border-bottom-width'));
    
    var tag_category_top_all_height = parseFloat ($tag_category_top.height ()) + parseFloat ($tag_category_top.css ('border-top-width')) + parseFloat ($tag_category_top.css ('border-bottom-width')) + parseFloat ($tag_category_top.css ('margin-bottom')) + parseFloat ($tag_category_top.css ('margin-top'));
    
    $(window).scroll (function (e) {
      if ((parseFloat ($(this).scrollTop ()) >= tag_category_top_top) && ($tag_category_top.css ('position') == 'relative')) {
        if (parseFloat ($(this).width ()) >= containerWidth)
          $tag_category_top.addClass ('to_top').css ({'position': 'fixed', 'top': '-1px', 'width': tag_category_top_width + 2 + 'px', 'left': '50%', 'margin-top': '0px', 'margin-left': (0 - (containerWidth / 2)) + 'px'}).next ().css ({'margin-top': tag_category_top_all_height + 'px'});
        else;
      } else if ((parseFloat ($(this).scrollTop ()) < tag_category_top_top) && (($tag_category_top.css ('position') == 'fixed') || ($tag_category_top.css ('position') == 'absolute'))) {
        $tag_category_top.removeClass ('to_top').css ({'position': 'relative', 'margin': tag_category_top_margin, 'width': tag_category_top_width + 2 + 'px', 'left': '50%', 'margin-left': (0 - (containerWidth / 2)) + 'px'}).next ().css ({'margin-top': 0});
      }
    });
  }

  $('.post_form-fancybox').fancybox ({
    padding: 0,
    type: 'ajax',
    // width: '600',
    // height: '450',
    // minWidth: 600,
    // minHeight: 450,
    maxWidth: 600,
    maxHeight: 450,
    ajax: {
      type: 'POST',
      data: {'current_uri' : $('#_current_uri').val ()},
      cache: false
    },
    helpers: {
      overlay: {
        locked: false
      },
      title: {
        type: 'over'
      }
    },
    data: {
      current_url: 'sss' 
    },
    beforeLoad: function () {
      this.title = $(this.element).data ('fancybox_title');
    }
  });

  $('#search').autocomplete ({
    minLength: 1,
    autoFocus: true,
    source: function( request, response ) {
      $.ajax ({
        url: $('#_search_url').val (),
        data: { q: request.term },
        async: true, cache: false, dataType: 'json', type: 'POST',
        beforeSend: function () {}
      })
      .done (function (result) {
        response( result.datas );
      })
      .fail (function (result) { ajaxError (result); })
      .complete (function (result) { });
    },
    focus: function (event, ui) { $('#project').val (ui.item.label); return false; },
    select: function (event, ui) { window.location.assign (ui.item.url); },
    open: function () { $(this).removeClass ('ui-corner-all').addClass ('ui-corner-top'); },
    close: function () { $(this).removeClass ('ui-corner-top').addClass ('ui-corner-all'); }
  }).data ('ui-autocomplete')._renderItem = function (ul, item) {
    return $('<li />').addClass ('search_item').append ('<a>' + item.label + '<div class="desc">' + item.desc + '</div></a>').appendTo (ul);
  };
})