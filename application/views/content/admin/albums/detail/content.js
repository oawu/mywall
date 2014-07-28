$(function() {
  $('#update_form').submit (function () {
    if ($('#title').val () == '') { alert ('有欄位沒填!'); return false;}
    if ($('#content').val () == '') { alert ('有欄位沒填!'); return false; }
    if ($('#link').val () == '') { alert ('有欄位沒填!'); return false; }

    return true;
  });
});