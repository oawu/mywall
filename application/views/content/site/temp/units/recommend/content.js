$(function() {
  // .scrollTop()
  // $('#panel').css ({'top': $('#map').offset ().top});
  // console.info (1);
});

var timer = null;
var marker = null;
var $controlPanel = null;
var infowindow = new google.maps.InfoWindow ();

function initialize () {

  var mapOptions = {
    zoom: 17,
    scaleControl: false,
    navigationControl: false,
    mapTypeControl: false,
    zoomControl: true,
    scrollwheel: true,
    streetViewControl: false,
    center: new google.maps.LatLng (23.568596231491233, 120.3035703338623)
  };

  var map = new google.maps.Map ($('#map').get (0), mapOptions);

  google.maps.event.addListener (map, 'click', function(e) {
    if (marker == null) {
      marker = new google.maps.Marker ({
        map: map,
        draggable: true,
        center: e.latLng,
        position: e.latLng,
      });
      map.panTo(new google.maps.LatLng (e.latLng.k, e.latLng.B + 0.0018));

      google.maps.event.addListener (marker, 'dragend', function () {
        new google.maps.Geocoder ().geocode({ 'latLng': marker.getPosition () }, function (result, status) {
          if (status == google.maps.GeocoderStatus.OK) {

            infowindow.setContent(result[0].formatted_address);
            infowindow.open (map, marker);
            loadControlPanel (result[0].formatted_address, marker.getPosition ());
            // console.info (result);
          }
        });
      });
    } else {
      marker.setPosition (e.latLng);
      map.panTo(new google.maps.LatLng (e.latLng.k, e.latLng.B + 0.0018));
    }

    new google.maps.Geocoder ().geocode ({'latLng': e.latLng }, function (result, status) {
          if (status == google.maps.GeocoderStatus.OK) {
            // console.info (result[0].formatted_address);
            infowindow.setContent(result[0].formatted_address);
            infowindow.open (map, marker);

            loadControlPanel (result[0].formatted_address, e.latLng);
          }
    });
  });

  initializeControlPanel ();
  // setTimeout (function () {loadControlPanel ('qwe', {k:'fsdfsd', A:'fdsfs'});}, 1000)
}

function loadControlPanel (address, latLng) {
  if ($controlPanel == null) initializeControlPanel ();

  $controlPanel.animate ({'right': '0px'});
  $controlPanel.find ('#address').val (address);
  $controlPanel.find ('#latitude').val (latLng.k);
  $controlPanel.find ('#longitude').val (latLng.B);

}
var error = function ($alert, msg, $obj) {
  if (typeof $obj !== 'undefined') $obj.parent ('.input-group').addClass ('has-error');

  $alert.empty ().text (msg).show ();
  $('#control_panel').effect( "shake" );

  if (timer) clearTimeout (timer);

  timer = setTimeout (function () {
    $('#control_panel').find ('.input-group').removeClass ('has-error');
    $alert.empty ().hide ('blind');
  }, 3000);

  return false;
}

function submitCreate ($obj) {
  var $create  = $obj.find ('#create');
  var $clear  = $obj.find ('#clear');
  var $alert  = $obj.find ('#alert');

  var $create_form  = $obj.find ('#create_form');

  // var $user_name    = $obj.find ('#user_name');
  var $name         = $obj.find ('#name');
  var $introduction = $obj.find ('#introduction');
  var $open_time    = $obj.find ('#open_time');
  var $address      = $obj.find ('#address');
  var $latitude     = $obj.find ('#latitude');
  var $longitude    = $obj.find ('#longitude');
  var $pictures     = $obj.find ('[name="pictures[]"]');
  // var $picture      = $obj.find ('#picture');
//     var $dd = $obj.find ('[name="pictures[]"]');
// console.info ($dd.length);

  // var $tags         = $obj.find ('#tags');
// var conditions = $.makeArray ($obj.find ('input[type=checkbox][name=tags]:checked').map (function () { return $(this).val(); }));
     

  
    // if ($('#enable').val () == 'false' && (((new Date ().getTime () / 1000) - parseFloat ($('#update_time').val ())) < parseFloat ($('#duration').val ()))) return error ('為避免過載.. 別急! 先慢慢挑選好下一張照片 ' + parseFloat ($('#duration').val ()) + ' 秒後再上傳吧!');
    
    // if (($user_name.val () == '') || ($user_name.val ().length == 0))
    //   return error ($alert, $user_name.attr ('placeholder'), $user_name);

    // if ($user_name.val ().length > parseFloat ($user_name.attr ('maxlength')))
    //   return error ($alert, '請輸入少於 ' + $user_name.attr ('maxlength') + '個字!', $user_name);

    if (($name.val () == '') || ($name.val ().length == 0))
      return error ($alert, $name.attr ('placeholder'), $name);

    if ($name.val ().length > parseFloat ($name.attr ('maxlength')))
      return error ($alert, '請輸入少於 ' + $name.attr ('maxlength') + '個字!', $name);

    if (($introduction.val () == '') || ($introduction.val ().length == 0))
      return error ($alert, $introduction.attr ('placeholder'), $introduction);

    if ($introduction.val ().length > parseFloat ($introduction.attr ('maxlength')))
      return error ($alert, '請輸入少於 ' + $introduction.attr ('maxlength') + '個字!', $introduction);

    // if (($open_time.val () == '') || ($open_time.val ().length == 0))
    //   return error ($alert, $open_time.attr ('placeholder'), $open_time);

    // if ($open_time.val ().length > parseFloat ($open_time.attr ('maxlength')))
    //   return error ($alert, '請輸入少於 ' + $open_time.attr ('maxlength') + '個字!', $open_time);

    if (($address.val () == '') || ($address.val ().length == 0))
      return error ($alert, $address.attr ('placeholder'), $address);

    if ($address.val ().length > parseFloat ($address.attr ('maxlength')))
      return error ($alert, '請輸入少於 ' + $address.attr ('maxlength') + '個字!', $address);


    for (var i = 0; i < $pictures.length; i++) {
      if (!(($pictures.eq (i).val () == '') || ($pictures.eq (i).val ().length == 0))) {
        var ext = $pictures.eq (i).val ().split ('.').pop ().toLowerCase ();
        if($.inArray (ext, $pictures.eq (i).data ('formats').split ('|')) == -1) return error ($alert, '照片格式不符合規定!', $pictures.eq (i));

        if (($pictures.eq (i).data ('size') == 'false')) return error ($alert, '照片大小不符合規定!', $pictures.eq (i));
      }
    }

  $create.bs_button ('loading');
  $clear.bs_button ('loading');

  $name.attr ('readonly', 'readonly');
  $introduction.attr ('readonly', 'readonly');
  $open_time.attr ('readonly', 'readonly');
  $address.attr ('readonly', 'readonly');
  $obj.find ('.delete_picture, .create_picture').attr ('readonly', 'readonly');

  for (var i = 0; i < $pictures.length; i++) $pictures.eq (i).attr ('readonly', 'readonly');

  $('#create_form').submit ();
}

function createPicture ($inputGroup) {
  $inputGroup.find ('[name="pictures[]"]').change (function () {
    var fileSize = this.files[0].size||this.files[0].fileSize
    if (parseFloat (fileSize) < $(this).data ('max_size')) $(this).data ('size', 'true');
    else $(this).data ('size', 'false');
  });

  $inputGroup.find ('.delete_picture').click (function () {
    $(this).parents ('.input-group').remove ();
  });
}

function initializeControlPanel () {
  if ($controlPanel == null) {
    var $tempControlPanel = $('<div />').attr ('id', 'control_panel').hide ().appendTo ($('#map')).css ({'right': '-320px'}).show ();

    $.ajax ({
      url: $('#get_recommend_panel_url').val (),
      data: {  },
      async: true, cache: false, dataType: 'json', type: 'POST',
      beforeSend: function () {
        $tempControlPanel.empty ().append ($('<center style="margin-top: 10px"><img src="data:image/gif;base64,R0lGODlhIAAgAMQYAFJvp3mOup6sy+Dl7vHz+OXp8fT2+WV+sOjr8oiawae10OPn74mbwaKxzrrF2+zv9ens8/L0+O/y99DX5sDJ3a+71e/y9vf5+////wAAAAAAAAAAAAAAAAAAAAAAAAAAACH/C05FVFNDQVBFMi4wAwEAAAAh+QQFCAAYACwAAAAAIAAgAAAFlCAmjmRpnmiqrmzrvnAsz6JBWLhFGKSd67yRL7cjXI5IAsmIPCpHzOatebSQLNSLdYSl4rJbUbcZxoyRX+8VvPaeq21yHP3WzuFccL28v2v7eWqBZIBibIN0h4aCi4SKZo97hZCMlI6Vk5KRm26ccohVmZ6JmKNVUUlLWU8iqE5DODs9N0RBNbSxtjS7vL2+v8DBGCEAIfkEBQgAGAAsAAAFAAgAFgAABR+gQVikRYhXqo5Y61puLM90bd94ru88Dssm1UpUMhlCACH5BAkIABgALAAAAAAUACAAAAV0IHMAJHAwWKqu6VG98MHOGADDAM3ad5XrKt7tB6z1fCsDwcK0EAxC3IpwqVoJ0RcRY5lZssiisbfVgcu0s3g8XKvF72IcODcf0bN6+u7mw/1ygHSCdmQrXSxfglRWVViCSk1OUIR7hn+XRS49MmIiJSYoYiEAIfkECQgAGAAsAAAAACAAIAAABcsgJo6kyBxAChxM6WJNEsxB0pBHpe/HWyaUoDBBAux2AB8pIBQGikddUiliNinPkTE6pVqbWdH22MUYCJa0hWD4OqFcEuFCrxPcwTBmjCRZXBZ4WHBkVFVXg1pRFWU+gnp8UoYYj4R9hpWKcZiIkIuNL5lin5Oie6ScV56bXp2Wkqlgr4ylrpqFsW+3l62qs6AuppG0uXm/tb67sCJ/JYG2o6wYc3V0d9Cn0mdqa23Yw8AlwqhUQFdEysRUMTQ1NyM5UT2ThicqKy2GIQAh+QQJCAAYACwAAAAAIAAgAAAF5CAmjmRpjswBrMDBnGWTBHSQNORR7fwBkwmKcJggAXg8gEMhaAoUDlJgOAwYkTuAYsLtKqRUoXV0xAIE3a4AHB6LyshzmrseTdtXM3peF92pbhhwSXtpfRh/VXlxhWpsgIuEcxOHiWKRWY10j4pkWBVyfJyXnnqTlWEUgYOZp6OqmKCalK+rn6GGtbG4jnaptqaivniljK7DkMWSwn6/u7OoxG+30LrKrcyIzteyx83SgtTe2uCs3dmWsNxak1/IndNmS05PUe+k8XE/I0FhRev7RMioYQPHCB1YfARcmIJFCwYhAAAh+QQJCAAYACwAAAAAIAAgAAAF1iAmjmRpnmiqYk0SvEHSrDSWUHie0I4i/AKFgxTI5QI0xWTJVBCNuABkMagOFhCSgMkUPKGBhWRMXmi5S++oCB6QyYMzWi1iGwPutyQ+2s6/d3lvfCJ+XHQYdkeCcHKHgIt6e45dkFGMY4QYhpVrUBR4kpqcaZagmJN9aBOIipeilKWebbCqf7OBtYWrrZ+heqO8pr+DsazDqMG3db7Jxr20wM/IupvCuJHSto/YUWJ6ZtudzGBTVldZ4rLkd0mrTt2gPD5AQsM1KzdQO/gpLTAxZvQbGAIAIfkECQgAGAAsAAAAACAAIAAABc0gJo5kaZ5oqq5s676OIsyC4rypMu28wkKLgXCwgJAEPJ7ggSg4C4gHaSGpWhfH5E6AiHi/CNLAah1ktYLC91sQk6vmERKtXkfao/E7Lpon03Z3bntnf3VreCJ6ZHwYfkqHbIOMhZCBiRiLZZVbkV6YmnCcE4B2oG8SjY+dl5ObclqknoJ5qKqxpYiuorB0rbWEvYa/irajuZLAlMKWprupx7OnwX24XXZhyq/VaExPUFIjVG9YzFs/QUNFxzgoOlo+7SYxNDU38vj5+u0hACH5BAkIABgALAAAAAAgACAAAAXIICaOZGmeaKqubOu+cCy30DLcwwIZhOVbBAPpgSgYC4gHaSFpOheEi3RKICEi2CyCNHA6B5bp1EIqZLMFrrcJFkvJI/M5kh511203XCQ/10V3Xnliexh9aGp4YXplc3SJgouEjXN/GIFfkmOUfpCZbheFh1iWmGyab5yIdmsSg5txjqWtr6mxlZ6noKKyua6ooaqkvrXBt52sirvCj8mRy8ergLRRblUjV3Nbzl88P0BCI0RHSEojTGsLMyU1ODkQ6/Hy8/T19SEAIfkEBQgAGAAsAAAAACAAIAAABbAgJo5kaZ5oqq5s675wLM+iQVi4RRikneu80QNRKBYQD8JlySSQlMylc4SIWK8IS3RpIWm33VHhei18o2HRmZnGjMkR8/bSXnNJb7Ic7J2382V2dH18YnBxgnV+eId7aISPhnCObJCVknqJlneYgYsjmp1WlJxqnyKAo6GmhaiNqxiwqYinsbWzpIOgt6+1so1QUVMiwU0kVXAIPjk7PTfMQSJDRkcPNNfY2drb3N0kIQAh+QQFFAAYACwYAAYACAAUAAAFKKBBWKRFiFeqjqpKtukLyy3tWvBlx/jc179bbqcL8obG4pCQO41KpxAAOw==" /></center>'));
      }
    })
    .done (function (result) {
      if (result.status && result.content) {
        $tempControlPanel.empty ().append ($(result.content));

        $tempControlPanel.find ('#clear').click (function () { marker.setMap (null); marker = null; });
        $tempControlPanel.find ('#create').click (function () { submitCreate ($tempControlPanel); });
        $tempControlPanel.find ('#create_picture').click (function () { createPicture ($tempControlPanel.find ('.model').clone ().removeClass ('model').insertBefore ($(this).parents ('.input-group'))); });

        $controlPanel = $tempControlPanel;
      }
    })
    .fail (function (result) { ajaxError (result); })
    .complete (function (result) { });

  }
}


google.maps.event.addDomListener (window, 'load', initialize);

