<t2>新增 <?php echo $feature_name?> <span>※ 注意！當新增後就不可刪除。</span></t2>

<form id="create_form" method="post" action="<?php echo $create_url; ?>" enctype="multipart/form-data">
  <table class='create_list'>
    <tbody>
      <tr><th>※ 名稱</th><td><input type='text' id='name' name='name' value="" placeholder='請輸入要新增的 名稱...' class='form-control' x-webkit-speech/></td></tr>
      <tr><td colspan='2'>
        <input type="submit" class='OA-ui-OA_Button' value="確定新增"/>
        <input type="reset" class='OA-ui-OA_Button' value="重新填寫"/>
        <input type="button" class='OA-ui-OA_Button' value="回 <?php echo $feature_name; ?> 列表" onClick='window.location.assign ("<?php echo $back_url; ?>");'/>
      </td></tr>
    </tbody>
  </table>
</form>