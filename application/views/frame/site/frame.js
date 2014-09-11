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

  if ($('#_top_bar').length) {
    var $_top_bar = $('#_top_bar'), _top_bar_top = parseFloat ($_top_bar.offset ().top), _top_bar_width = parseFloat ($_top_bar.width ()), _top_bar_margin = $_top_bar.css ('margin');
    var containerWidth = parseFloat ($('#container').width ()) + parseFloat ($('#container').css ('border-top-width')) + parseFloat ($('#container').css ('border-bottom-width'));
    
    var _top_bar_all_height = parseFloat ($_top_bar.height ()) + parseFloat ($_top_bar.css ('border-top-width')) + parseFloat ($_top_bar.css ('border-bottom-width')) + parseFloat ($_top_bar.css ('margin-bottom')) + parseFloat ($_top_bar.css ('margin-top'));
    
    $(window).scroll (function (e) {
      if ((parseFloat ($(this).scrollTop ()) >= _top_bar_top) && ($_top_bar.css ('position') == 'relative')) {
        if (parseFloat ($(this).width ()) >= containerWidth)
          $_top_bar.addClass ('to_top').css ({'position': 'fixed', 'top': '-0px', 'width': _top_bar_width + 2 + 'px', 'left': '50%', 'margin-top': '0px', 'margin-left': (0 - (containerWidth / 2)) + 'px'}).next ().css ({'margin-top': _top_bar_all_height + 'px'});
        else;
      } else if ((parseFloat ($(this).scrollTop ()) < _top_bar_top) && (($_top_bar.css ('position') == 'fixed') || ($_top_bar.css ('position') == 'absolute'))) {
        $_top_bar.removeClass ('to_top').css ({'position': 'relative', 'margin': _top_bar_margin, 'width': _top_bar_width + 2 + 'px', 'left': '50%', 'margin-left': (0 - (containerWidth / 2)) + 'px'}).next ().css ({'margin-top': 0});
      }
    });
  }
})