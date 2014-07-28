$(function () {
  $('.btn-group input[type="radio"]').change (function () {
    $.ajax ({
      url: $('#update_url').val (),
      data: { object_id: $(this).data ('object_id'), is_read: $(this).val ()},
      async: true, cache: false, dataType: 'json', type: 'POST',
      beforeSend: function () {  }
    })
    .done (function (result) { $.jGrowl (result.message, {theme: 'j_growl', easing: "easeInExpo"}); })
    .fail (function (result) { ajaxError (result); })
    .complete (function (result) {  });
  });
});