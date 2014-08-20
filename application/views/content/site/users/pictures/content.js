var w, container, carousel, item, radius, itemLength, rY, ticker, fps, mouseX = -0.26, mouseY = -1.135, mouseZ = -200, addX = 0;

var fps_counter = {
  tick: function () {
    this.times = this.times.concat (+ new Date ());
    var seconds, times = this.times;
    
    if (times.length > this.span + 1) {
      times.shift ();
      seconds = (times[times.length - 1] - times[0]) / 1000;
      return Math.round (this.span / seconds);
    } 
    else return null;
  },
  times: [],
  span: 20
};

var counter = Object.create (fps_counter);

function init () {
  w = $(window);
  container = $('#contentContainer');
  carousel = $('#carouselContainer');
  item = $('.carouselItem');
  itemLength = $('.carouselItem').length;
  rY = 360 / itemLength;
  radius = Math.round ((150) / Math.tan (Math.PI / itemLength));

  TweenMax.set (container, {perspective: 600});
  TweenMax.set (carousel, {z: -(radius)});
  
  for (var i = 0; i < itemLength; i++) {
    var $item = item.eq (i);
    var $block = $item.find ('.carouselItemInner');

    TweenMax.set ($item, {rotationY: rY * i, z: radius, transformOrigin: "50% 50% " + -radius + "px"});
    
    animateIn ( $item, $block )            
  }
  
  window.addEventListener ("mousemove", onMouseMove, false);
  ticker = setInterval (looper, 1000/60);      
}

function animateIn ( $item, $block ) {
  var $nrX = 360 * getRandomInt (2),
      $nrY = 360 * getRandomInt (2),
      $nx = -(2000) + getRandomInt (4000),
      $ny = -(2000) + getRandomInt (4000),
      $nz = -4000 +  getRandomInt (4000),
      $s = 1.5 + (getRandomInt (10) * .1),
      $d = 1 - (getRandomInt (8) * .1);

  TweenMax.set ($item, {autoAlpha: 1, delay: $d});
  TweenMax.set ($block, {z: $nz, rotationY: $nrY, rotationX: $nrX, x: $nx, y: $ny, autoAlpha: 0});
  TweenMax.to ($block, $s, {delay: $d, rotationY: 0, rotationX: 0, z: 0,  ease: Expo.easeInOut});
  TweenMax.to ($block, $s - .5, {delay: $d, x: 0, y: 0, autoAlpha: 1, ease: Expo.easeInOut});
}

function onMouseMove (event) {
  mouseX = -(-(window.innerWidth * .5) + event.pageX) * .0025;
  mouseY = -(-(window.innerHeight * .5) + event.pageY ) * .01;
  mouseZ = -200;
  mouseX = Math.abs (mouseX) > 0.3 ? mouseX < 0 ? -0.3 : 0.3 : mouseX;
}

function looper () {
  addX += mouseX
  TweenMax.to (carousel, 1, {rotationY: addX, rotationX: mouseY, ease: Quint.easeOut});
  TweenMax.set (carousel, {z: mouseZ });
}

function getRandomInt ($n) {
  return Math.floor ((Math.random () * $n) + 1);  
}

$(function() {
  var footer_height = $("#footer").height ();

  var masonry = new Masonry ('#pictures', { itemSelector: '.picture', columnWidth: 1, transitionDuration: '0.3s', visibleStyle: { opacity: 1, transform: 'none' }});

  var setPictureFeature = function ($obj) {
    $obj.imagesLoaded (function () {
      $obj.find ('.picture_pic').css ({'height': $obj.show ().find ('.picture_pic img').css ('height')}).imgLiquid ({verticalAlign: "top"});
      $obj.find ('.picture_user_avatar').imgLiquid ({verticalAlign: "top"});
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
        data: { user_id: $pictures.data ('user_id'), next_id: $pictures.data ('next_id') },
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
          $pictures.data ('next_id', result.next_id);
        }
      })
      .fail (function (result) { ajaxError (result); })
      .complete (function (result) { });
    }
  }

  $('#carouselContainer .carouselItem').hide ();
  $('.user_banner_img').imgLiquid ({verticalAlign: "top"});
  $('#user_avatar').imgLiquid ({verticalAlign: "top"});

  $('#carouselContainer .carouselItem').imagesLoaded (function () {
    $('#carouselContainer .carouselItem').show ();
    $('.carouselItemInner').imgLiquid ({horizontalAlign: "top"});
    init ();
    $(window).scroll (function () {
      if ($(document).height() - $(window).height () - $(window).scrollTop () < footer_height)
        loadPictures ();
    }).scroll ();
  });

  
  $('.user_feature_area_left').on ('click', '.icon-user-add', function () {
    var $that = $(this);
    if ($that.data ('is_enable') && $that.data ('user_id') && $that.data ('be_user_id') && ($that.data ('user_id') != $that.data ('be_user_id'))) {
      $.ajax ({
        url: $('#set_follow_url').val (),
        data: { action: 'add', user_id: $that.data ('user_id'), be_user_id: $that.data ('be_user_id') },
        async: true, cache: false, dataType: 'json', type: 'POST',
        beforeSend: function () {
          $that.data ('is_enable', 0);
        }
      })
      .done (function (result) {
        if (result.status) {
          $that.removeClass ('icon-user-add').addClass ('icon-user-delete').data ('is_enable', 1).tooltip ("option", "content", "我不想 Follow 他！"); //('title', '我不想 Follow 他！');
        }
        $.jGrowl (result.message, {theme: 'j_growl', easing: "easeInExpo"});
      })
      .fail (function (result) { ajaxError (result); })
      .complete (function (result) { });
    }
    
  });
  $('.user_feature_area_left').on ('click', '.icon-user-delete', function () {
    var $that = $(this);
    if ($that.data ('is_enable') && $that.data ('user_id') && $that.data ('be_user_id') && ($that.data ('user_id') != $that.data ('be_user_id'))) {
      $.ajax ({
        url: $('#set_follow_url').val (),
        data: { action: 'del', user_id: $that.data ('user_id'), be_user_id: $that.data ('be_user_id') },
        async: true, cache: false, dataType: 'json', type: 'POST',
        beforeSend: function () {
          $that.data ('is_enable', 0);
        }
      })
      .done (function (result) {
        if (result.status) {
          $that.removeClass ('icon-user-delete').addClass ('icon-user-add').data ('is_enable', 1).tooltip ("option", "content", "我想要 Follow 他！"); //('title', '我不想 Follow 他！');
        }
        $.jGrowl (result.message, {theme: 'j_growl', easing: "easeInExpo"});
      })
      .fail (function (result) { ajaxError (result); })
      .complete (function (result) { });
    }
  });
});