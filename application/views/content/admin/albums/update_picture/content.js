$(function() {
  $('#update_form').submit (function () {
    if ($('#title').val () == '') { alert ('有欄位沒填!'); return false;}
    if ($('#description').val () == '') { alert ('有欄位沒填!'); return false;}
    if ($('#src').val () == '') { alert ('有欄位沒填!'); return false;}
    if (($('#picture').val () == '') && ($('#img').attr ('src') == '')) { alert ('有欄位沒填!'); return false; }

    return true;
  });
});