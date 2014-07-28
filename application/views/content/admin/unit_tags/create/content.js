  $(function() {
    $('#create_form').submit (function () {
      if ($('#name').val () == '') { showAlert ('警告', '有標示 ※ 的欄位資料不完整!', function () { $(this).OA_Dialog ('close'); }); return false;}
      return true;
    });
  });