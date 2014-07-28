$(function() {
  $('#create_form').submit (function () {
    if ($('#title').val () == '') { alert ('有欄位沒填!'); return false;}
    if ($('#description').val () == '') { alert ('有欄位沒填!'); return false;}
    if ($('#src').val () == '') { alert ('有欄位沒填!'); return false;}
    if ($('#picture').val () == '') { alert ('有欄位沒填!'); return false; }

    return true;
  });
});