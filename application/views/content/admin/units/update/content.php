<t2>修改 <?php echo $feature_name?></t2>

<form id="update_form" method="post" action="<?php echo $update_url; ?>" enctype="multipart/form-data">
  <table class='update_list'>
    <tbody>
      <tr><th>※ 景點名稱</th><td><input type='text' id='name' name='name' value="<?php echo $object->name; ?>" placeholder='請輸入要修改的 景點名稱...' class='form-control' x-webkit-speech/></td></tr>
      <tr><th>※ 景點簡介</th><td>
        <textarea name='introduction' id='introduction' placeholder='請輸入要修改的 景點簡介...' class='form-control'><?php echo $object->introduction; ?></textarea>
      </td></tr>
      <tr><th>※ 景點住址</th><td><input type='text' id='address' name='address' value="<?php echo $object->address; ?>" placeholder='請輸入要修改的 景點住址...' class='form-control' x-webkit-speech/></td></tr>
      <tr><th>營業時間</th><td><input type='text' id='open_time' name='open_time' value="<?php echo $object->open_time; ?>" placeholder='請輸入要修改的 營業時間...' class='form-control' x-webkit-speech/></td></tr>
<?php if (count ($unit_tags)) { ?>
        <tr><th>景點分類</th><td>
    <?php foreach ($unit_tags as $unit_tag) { ?>
            <label class='tag'><input type="checkbox" name='tags[]' id='tags[]' value='<?php echo $unit_tag->id; ?>'<?php echo count ($tag_ids) && in_array ($unit_tag->id, $tag_ids) ? 'checked' : ''; ?>/> <?php echo $unit_tag->name; ?></label>
    <?php } ?>
        </td></tr>
<?php } ?>

<?php if (verifyArray ($pictures = $object->pictures)) { ?>
        <tr><th>推薦照片</th><td>
    <?php foreach ($pictures as $i => $picture) { ?>
            <div class='pictures'>
              <img id='img' src='<?php echo $picture->picture_url ('60x55C')?>' style='width: 60px;' class="fancybox" data-fancybox-group="fancybox-group-content_picture" href="<?php echo $picture->picture_url (); ?>"/>
              <label class='delete_imgs'><input type="checkbox" name='delete_imgs[]' id='delete_imgs[]' value='<?php echo $picture->id; ?>'/></label>
            </div>
    <?php } ?>
        </td></tr>
<?php } ?>
        <tr><th>推薦照片</th><td>
          <input type='file' id='picture' name='pictures[]' value="" class='form-control' x-webkit-speech/>
          <input type="button" class="OA-ui-OA_Button add_items" value="+"/>
        </td></tr>

      <tr><td colspan='2'>
        <input type="submit" class='OA-ui-OA_Button' value="確定修改"/>
        <input type="reset" class='OA-ui-OA_Button' value="重新填寫"/>
        <input type="button" class='OA-ui-OA_Button' value="回 <?php echo $feature_name; ?> 列表" onClick='window.location.assign ("<?php echo $back_url; ?>");'/>
      </td></tr>
    </tbody>
  </table>
</form>
