var showAlert = function (title, content, action, isShow) {
  if (!($dialog = $('body').children ('#_alert')).length) $dialog = $('<div />').attr ('id', '_alert').appendTo ($('body')).OA_Dialog ({ openEffect: 'explode', closeEffect: 'explode'});

  title   = (typeof title   === 'undefined') ? '':title;
  content = (typeof content === 'undefined') ? '':content;
  action  = (typeof action  === 'undefined') ? function (){}:action;
  isShow  = (typeof isShow  === 'undefined') ? true:isShow;

  $dialog.OA_Dialog ('option', 'title', title)
         .OA_Dialog ('option', 'content', content)
         .OA_Dialog ('option', 'buttons', {'確定':action});

  isShow && $dialog.OA_Dialog ('open');
  return $dialog;
}

var showWait = function (title, content, isShow) {
  if (!($dialog = $('body').children ('#_wait')).length) $dialog = $('<div />').attr ('id', '_wait').appendTo ($('body')).OA_Dialog ({ openEffect: 'explode', closeEffect: 'explode'});
  
  title   = (typeof title   === 'undefined') ? '':title;
  content = (typeof content === 'undefined') ? '':content;
  isShow  = (typeof isShow  === 'undefined') ? true:isShow;

  $dialog.OA_Dialog ('option', 'title', title)
         .OA_Dialog ('option', 'content', content);

  isShow && $dialog.OA_Dialog ('open');
  return $dialog;
}

var showConfirm = function (title, content, action, closeAction, isShow) {
  if (!($dialog = $('body').children ('#_confirm')).length) $dialog = $('<div />').attr ('id', '_confirm').appendTo ($('body')).OA_Dialog ({ openEffect: 'explode', closeEffect: 'explode'});
  
  title       = (typeof title       === 'undefined') ? 'Title':title;
  content     = (typeof content     === 'undefined') ? 'Content':content;
  action      = (typeof action      === 'undefined') ? function (){}:action;
  closeAction = (typeof closeAction === 'undefined') ? function (){}:closeAction;
  isShow      = (typeof isShow      === 'undefined') ? true:isShow;

  var callbacks = $.Callbacks()
  callbacks.add (closeAction);
  callbacks.add (function () {$(this).OA_Dialog ('close');});

  $dialog.OA_Dialog ('option', 'title', title)
         .OA_Dialog ('option', 'content', content)
         .OA_Dialog ('option', 'buttons', { '取消': callbacks.fire, '確定': action});

  isShow && $dialog.OA_Dialog ('open');
  return $dialog;
}

var ajaxError = function (result) {
  console.info (result.responseText);
  showAlert ('Error!', 'The Ajax response error! Please inform the website admin this issue!', function () {location.reload();});
}

var base_url = function () {
  params = new Array ();
  for (var i = 0; i < arguments.length; i++) params.push (arguments[i]);
  params.unshift ('http://' + document.domain);
  return jQuery.map (params, function (t, i) { return t.length != 0 ? t : null; }).join ('/');
}

var sprintf = function () {
  var i = 0, a, f = arguments[i++], o = [], m, p, c, x, s = '';
  while (f) {
    if (m = /^[^\x25]+/.exec(f)) {
      o.push(m[0]);
    }
    else if (m = /^\x25{2}/.exec(f)) {
      o.push('%');
    }
    else if (m = /^\x25(?:(\d+)\$)?(\+)?(0|'[^$])?(-)?(\d+)?(?:\.(\d+))?([b-fosuxX])/.exec(f)) {
      if (((a = arguments[m[1] || i++]) == null) || (a == undefined)) {
        throw('Too few arguments.');
      }
      if (/[^s]/.test(m[7]) && (typeof(a) != 'number')) {
        throw('Expecting number but found ' + typeof(a));
      }
      switch (m[7]) {
        case 'b': a = a.toString(2); break;
        case 'c': a = String.fromCharCode(a); break;
        case 'd': a = parseInt(a); break;
        case 'e': a = m[6] ? a.toExponential(m[6]) : a.toExponential(); break;
        case 'f': a = m[6] ? parseFloat(a).toFixed(m[6]) : parseFloat(a); break;
        case 'o': a = a.toString(8); break;
        case 's': a = ((a = String(a)) && m[6] ? a.substring(0, m[6]) : a); break;
        case 'u': a = Math.abs(a); break;
        case 'x': a = a.toString(16); break;
        case 'X': a = a.toString(16).toUpperCase(); break;
      }
      a = (/[def]/.test(m[7]) && m[2] && a >= 0 ? '+'+ a : a);
      c = m[3] ? m[3] == '0' ? '0' : m[3].charAt(1) : ' ';
      x = m[5] - String(a).length - s.length;
      p = m[5] ? str_repeat(c, x) : '';
      o.push(s + (m[4] ? a + p : p + a));
    }
    else {
      throw('Huh ?!');
    }
    f = f.substring(m[0].length);
  }
  return o.join('');
}

$(function(){

  var containerWidth = parseFloat ($('#container').width ()) + parseFloat ($('#container').css ('border-top-width')) + parseFloat ($('#container').css ('border-bottom-width')),
      $nav = $('nav.navbar').css ({'width': containerWidth + 'px'}),
      navAllHeight = parseFloat ($nav.height ()) + parseFloat ($nav.css ('border-top-width')) + parseFloat ($nav.css ('border-bottom-width')) + parseFloat ($nav.css ('margin-bottom')) + parseFloat ($nav.css ('margin-top'));
      $('#container').css ({'padding-top': navAllHeight + 'px'});
  
  $(window).resize (function() {
    if (parseFloat ($(this).width ()) < containerWidth) { $nav.css ({'position': 'absolute', 'left': '0px', 'margin-left': 0 + 'px'}); }
    else { $nav.css ({'position': 'fixed', 'left': '50%', 'margin-left': (0 - (containerWidth / 2)) + 'px'}); } 
  }).resize ();
  
  var visit_menu_margin_top = parseFloat ($('#visit_menu').hide ().css ('margin-top'));
  var visit_menu_height = parseFloat ($('#visit_menu').css ('height'));

  $('#visit_menu').css ({'margin-top': 0 - visit_menu_height + visit_menu_margin_top + 'px'});
  $nav.css ({'top': (0 - navAllHeight) + 'px'}).stop ().animate ({'top': '0px'}, 500, function () { $('#visit_menu').show ().animate ({'margin-top': visit_menu_margin_top + 'px'}); })
  
  $('div.bs-sidebar ul.list-group li.list-group-item.pointer').click (function () { window.location.assign ($(this).data ('url')); }).each (function (i, t) {if (window.location.href.indexOf ($(this).data ('url')) != -1) $(this).addClass ('active'); });
  $('#nav_bar_myself_picture span').imgLiquid ({verticalAlign: "center"});

  $('.fancybox').fancybox ({ beforeLoad: function() { this.title = $(this.element).data ('fancybox_title'); }, padding : 0, helpers : { overlay: {locked: false}, title : { type : 'over' }, thumbs: {width: 50, height: 50}}});
  
  $.jGrowl.defaults.closerTemplate = '<div>關閉所有提示</div>';
  
  $('.jqui_tooltip').tooltip ({ track: true, position: { my: "left+10 top+10"}, show: { effect: 'fade', delay: 150 }, content: function () { return $(this).data ('pic') ? $('<img />').css ({'width': '500px'}).attr ('src', $(this).attr ('title')) : $(this).attr ('title'); } });
  // $('.fancybox').fancybox ({ padding : 0, helpers : { overlay: {locked: false}, title : { type : 'over' }}});
  if (($('#_fb_sing_in_message').val () != '') && $('#_fb_sing_in_message').val ().length) $.jGrowl ($('#_fb_sing_in_message').val (), {theme: 'j_growl', easing: "easeInExpo"});
});