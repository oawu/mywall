$(function () {
  $('.btn-group input[type="radio"]').change (function () {
    $.ajax ({
      url: $('#update_status_url').val (),
      data: { object_id: $(this).data ('object_id'), status: $(this).val ()},
      async: true, cache: false, dataType: 'json', type: 'POST',
      beforeSend: function () {  }
    })
    .done (function (result) { $.jGrowl (result.message, {theme: 'j_growl', easing: "easeInExpo"}); })
    .fail (function (result) { ajaxError (result); })
    .complete (function (result) {  });
  });

  $('.delete_view').click (function () {
    var $that = $(this);
    $.ajax ({
      url: $('#delete_view_url').val (),
      data: { view_id: $(this).data ('view_id')},
      async: true, cache: false, dataType: 'json', type: 'POST',
      beforeSend: function () { $that.bs_button ('loading'); }
    })
    .done (function (result) {
      if (result.status) $("<a class='btn btn-info btn-sm create_view' name='create_view' href='" + $that.data ('create_url') + "'>新增街景</a>").insertAfter ($that).siblings ().remove ();
      $.jGrowl (result.message, {theme: 'j_growl', easing: "easeInExpo"});
    })
    .fail (function (result) { ajaxError (result); })
    .complete (function (result) {  });
  });
});