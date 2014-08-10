(function(d, s, id) {
  var js, fjs = d.getElementsByTagName(s)[0];
  if (d.getElementById(id)) return;
  js = d.createElement(s); js.id = id;
  js.src = "//connect.facebook.net/zh_TW/all.js#xfbml=1&appId=1482020658677319";
  fjs.parentNode.insertBefore(js, fjs);
}(document, 'script', 'facebook-jssdk'));

window.fbAsyncInit = function() {
    FB.init({
      appId      : '1482020658677319',
      channelUrl : '//matsu.ioa.tw',
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
  var $menu = $('#menu'), menu_top = parseFloat ($menu.offset ().top), menu_width = parseFloat ($menu.width ()), menu_margin = $menu.css ('margin');
  var containerWidth = parseFloat ($('#container').width ()) + parseFloat ($('#container').css ('border-top-width')) + parseFloat ($('#container').css ('border-bottom-width'));
  $(window).scroll (function (e) {
    if ((parseFloat ($(this).scrollTop ()) > menu_top) && ($menu.css ('position') == 'relative')) {
      if (parseFloat ($(this).width ()) >= containerWidth)
        $menu.css ({'position': 'fixed', 'top': '0px', 'width': menu_width + 2 + 'px', 'left': '50%', 'margin-top': '0px', 'margin-left': (0 - (containerWidth / 2)) + 'px'});
      else;
    } else if ((parseFloat ($(this).scrollTop ()) <= menu_top) && (($menu.css ('position') == 'fixed') || ($menu.css ('position') == 'absolute'))) {
      $menu.css ({'position': 'relative', 'margin': menu_margin, 'width': menu_width + 2 + 'px', 'left': '50%', 'margin-left': (0 - (containerWidth / 2)) + 'px'});
    }
  });
})