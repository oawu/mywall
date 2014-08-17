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
  var scroll_timer = null,
      scroll_count = 0,
      scroll_range = $('#get_scroll_range').val ();

  $('#carouselContainer .carouselItem').hide ();
  $('.user_banner_img').imgLiquid ({verticalAlign: "top"});
  $('#user_avatar').imgLiquid ({verticalAlign: "top"});
  $('.content_img').imgLiquid ({verticalAlign: "top"});

  $('#carouselContainer .carouselItem').imagesLoaded (function () {
    $('#carouselContainer .carouselItem').show ();
    $('.carouselItemInner').imgLiquid ({horizontalAlign: "top"});
    init ();
  });

  var setActiveFeature = function ($obj) {
    $obj.imagesLoaded (function () {
      $obj.find ('.content_unit_img').imgLiquid ({verticalAlign: "top"});
      $obj.find ('.content_img').imgLiquid ({verticalAlign: "top"});
      $obj.find ('.timeago').timeago ();

      $obj.find ('.point_area div').mouseenter (function () {
        $(this).parents ('.active').find ('.time').stop (true, true).fadeIn (300);
      }).mouseleave (function () {
        $(this).parents ('.active').find ('.time').stop (true, true).fadeOut ();
      });

      $obj.find ('.content_panel').mouseenter (function () {
        $(this).parents ('.active').find ('.time').stop (true, true).fadeIn (300);
      }).mouseleave (function () {
        $(this).parents ('.active').find ('.time').stop (true, true).fadeOut ();
      });

      return $obj.show ('blind');;
    });
  }
  var loadActive = function () {
    var $actives = $('#actives');
    $.ajax ({
      url: $('#get_actives_url').val (),
      data: { id: $actives.data ('id'), next_id: $actives.data ('next_id') },
      async: true, cache: false, dataType: 'json', type: 'POST',
      beforeSend: function () {
        $actives.data ('next_id', -1);
      }
    })
    .done (function (result) {
      if (result.status && result.contents) {
        for (var i = 0; i < result.contents.length; i++) {
          $obj = $(result.contents[i]);
          $obj.appendTo ($actives).hide ();
          setActiveFeature ($obj);
        }
        $actives.data ('next_id', result.next_id);
        if (result.next_id < 0)
          $('#end_point').removeClass ().addClass ('icon-ban-circle');
      }
    })
    .fail (function (result) { ajaxError (result); })
    .complete (function (result) { });
  }

  $('#end_point').click (function () {
    loadActive ();
  });

  $(window).scroll (function () {
    clearTimeout (scroll_timer);
    if (((scroll_count < scroll_range) || (scroll_range < 1)) && $(window).height () + $(window).scrollTop () > $('#not_banner').height () + $('#not_banner').offset ().top + 70) {
      scroll_timer = setTimeout (function () {
        if (scroll_count >= 0)
          scroll_count++;
        loadActive ();
      }, 300);
    }
  }).scroll ();

});