<h2>修改 <?php echo $feature_name_2; ?></h2>

<hr/>

<form id="update_form" method="post" action="<?php echo $update_url; ?>" enctype="multipart/form-data">
  <table class='update_list'>
    <tbody>
      <tr><th>標題</th><td><input type='text' id='title' name='title' value="<?php echo $object->title; ?>" placeholder='請輸入要新增的 標題...' class='form-control' x-webkit-speech/></td></tr>
      <tr><th>敘述</th><td><input type='text' id='description' name='description' value="<?php echo $object->description; ?>" placeholder='請輸入要新增的 敘述...' class='form-control' x-webkit-speech/></td></tr>
      <tr><th>網址</th><td><input type='text' id='src' name='src' value="<?php echo $object->src; ?>" placeholder='請輸入要新增的 網址...' class='form-control' x-webkit-speech/></td></tr>
      <tr><th>照片</th><td>
        <img class='fancybox' id='img' src='<?php echo $object->file_name->url ('500xW')?>' href='<?php echo $object->file_name->url ('1400xW');?>'/>
        <hr/>
        <input type='file' id='picture' name='picture' value="" class='form-control' x-webkit-speech/>
      </td></tr>
      <tr><td colspan='2'>
        <input type="submit" class='OA-ui-OA_Button' value="確定修改"/>
        <input type="reset" class='OA-ui-OA_Button' value="重新填寫"/>
        <input type="button" class='OA-ui-OA_Button' value="回 <?php echo $feature_name_2; ?> 細節" onClick='window.location.assign ("<?php echo $back_url; ?>");'/>
      </td></tr>
    </tbody>
  </table>
</form>