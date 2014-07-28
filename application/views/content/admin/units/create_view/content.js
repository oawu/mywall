var panorama_position = null;
var panorama_pov = null;

function initialize () {
  panorama_position = new google.maps.LatLng ($('#view').data ('latitude'), $('#view').data ('longitude'));

  panorama_pov = {
      heading: $('#view').data ('heading'),
      pitch: $('#view').data ('pitch'),
      zoom: $('#view').data ('zoom')
    };

  var markerLatLng = new google.maps.LatLng (
    $('#map').data ('latitude'),
    $('#map').data ('longitude'));

  var mapOptions = {
    zoom: 17,
    scaleControl: false,
    navigationControl: false,
    mapTypeControl: false,
    zoomControl: false,
    draggable: true,
    scrollwheel: false,
    streetViewControl: true,
    center: markerLatLng
  };
  var map = new google.maps.Map ($('#map').get (0), mapOptions);
  
  var marker = new google.maps.Marker ({
      map: map,
      draggable: false,
    });
  
  map.panTo (markerLatLng);
  marker.setPosition (markerLatLng);

  var panoramaOptions = {
    position: panorama_position,
    linksControl: true,
    addressControl: false,
    pov: panorama_pov
  };
  var panorama = new  google.maps.StreetViewPanorama ($('#view').get (0), panoramaOptions);
  map.setStreetView (panorama);
 
  google.maps.event.addListener(panorama, 'position_changed', function() {
    if ($('#create_view').data ('is_save')) $('#create_view').val ('* ' + $('#create_view').data ('value'));
    panorama_position = panorama.getPosition ();
  });
  google.maps.event.addListener(panorama, 'pov_changed', function() {
    if ($('#create_view').data ('is_save')) $('#create_view').val ('* ' + $('#create_view').data ('value'));
    panorama_pov = panorama.getPov ();
  });
}

google.maps.event.addDomListener (window, 'load', initialize);

$(function () {
  $('#create_view').val ((!$('#create_view').data ('is_save') ? '* ' : '') + $('#create_view').data ('value'));

  $('#create_view').click (function () {
    console.info (panorama_pov);
    if ((panorama_position != null) && (panorama_pov != null)) {
      var $that = $(this);
      $.ajax ({
        url: $('#create_view_url').val (),
        data: { 
          latitude: panorama_position.k,
          longitude: panorama_position.B,
          heading: panorama_pov.heading,
          pitch: panorama_pov.pitch,
          zoom: panorama_pov.zoom
        },
        async: true, cache: false, dataType: 'json', type: 'POST',
        beforeSend: function () { $that.bs_button ('loading'); }
      })
      .done (function (result) {
        $that.bs_button ('reset');
        $.jGrowl (result.message, {theme: 'j_growl', easing: "easeInExpo"});
        if (result.status) $('#create_view').val ($('#create_view').data ('value')).data ('is_save');
      })
      .fail (function (result) { ajaxError (result); })
      .complete (function (result) {  });
    }
  });
})