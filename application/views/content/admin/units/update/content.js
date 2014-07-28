$(function() {
  $('#update_form').submit (function () {
    if ($('#name').val () == '') { showAlert ('警告', '有標示 ※ 的欄位資料不完整!', function () { $(this).OA_Dialog ('close'); }); return false;}
    if ($('#address').val () == '') { showAlert ('警告', '有標示 ※ 的欄位資料不完整!', function () { $(this).OA_Dialog ('close'); }); return false;}
    if ($('#introduction').val () == '') { showAlert ('警告', '有標示 ※ 的欄位資料不完整!', function () { $(this).OA_Dialog ('close'); }); return false;}

    return true;
  });


  var del_items = function () { $(this).parent ('td').parent ('tr').remove (); }
  var add_items = function () {
    $tr = $(this).parent ('td').parent ('tr');
    if ($tr.find ('input[name="pictures[]"]').val () != '') {
      $tr_clone = $tr.clone ();
      $tr_clone.insertAfter ($tr).find ('.add_items').click (add_items);
      $tr.find ('.add_items').removeClass ('add_items').addClass ('del_items').unbind ('click').click (del_items).val ('-');
    }
  };

  $('.del_items').click (del_items);
  $('.add_items').click (add_items);
});