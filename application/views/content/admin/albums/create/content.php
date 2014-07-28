<h2>新增 <?php echo $feature_name_1; ?></h2>

<hr/>

<form id="create_form" method="post" action="<?php echo $create_url; ?>" enctype="multipart/form-data">
  <table class='create_list'>
    <tbody>
      <tr><th>標題</th><td><input type='text' id='title' name='title' value="" placeholder='請輸入要新增的 標題...' class='form-control' x-webkit-speech/></td></tr>
      <tr><th>敘述</th><td><input type='text' id='description' name='description' value="" placeholder='請輸入要新增的 敘述...' class='form-control' x-webkit-speech/></td></tr>
      <tr><td colspan='2'>
        <input type="submit" class='OA-ui-OA_Button' value="確定新增"/>
        <input type="reset" class='OA-ui-OA_Button' value="重新填寫"/>
        <input type="button" class='OA-ui-OA_Button' value="回 <?php echo $feature_name_1; ?> 列表" onClick='window.location.assign ("<?php echo $back_url; ?>");'/>
      </td></tr>
    </tbody>
  </table>
</form>