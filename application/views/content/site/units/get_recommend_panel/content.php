<form id="create_form" method="post" action="<?php echo $recommend_submit_url; ?>" enctype="multipart/form-data">
  <input type="hidden" name="user_id" id="user_id" value="<?php echo $that->identity->get_session ('user_id'); ?>"/>
  <input type="hidden" name="latitude" id="latitude" value=""/>
  <input type="hidden" name="longitude" id="longitude" value=""/>


  <div class="input-group">
    <span class="input-group-addon">推薦者</span>
    <input type="text" class="form-control" placeholder="請輸入推薦者名稱!" name="user_name" id="user_name" value="<?php echo $that->identity->get_session ('fb_name'); ?>" title="請輸入推薦者名稱!" readonly/>
  </div>

  <div class="input-group">
    <span class="input-group-addon">景點名稱</span>
    <input type="text" class="form-control" placeholder="請輸入景點名稱!" name="name" id="name" value="" maxlength="<?php echo config ('unit_config', 'recommend', 'name_max_length'); ?>" title="請輸入景點名稱!" x-webkit-speech/>
  </div>

  <div class="input-group introduction-group">
    <span class="input-group-addon">景點簡介</span>
    <textarea class="form-control" placeholder="請輸入景點簡介!" name="introduction" id="introduction" maxlength="<?php echo config ('unit_config', 'recommend', 'introduction_max_length'); ?>" title="請輸入景點簡介!" x-webkit-speech></textarea>
  </div>

  <div class="input-group">
    <span class="input-group-addon">營業時間</span>
    <input type="text" class="form-control" placeholder="請輸入營業時間!" name="open_time" id="open_time" value="" maxlength="<?php echo config ('unit_config', 'recommend', 'open_time_max_length'); ?>" title="請輸入營業時間!" x-webkit-speech/>
  </div>

  <div class="input-group">
    <span class="input-group-addon">景點住址</span>
    <input type="text" class="form-control" placeholder="請點選地圖或輸入景點住址!" name="address" id="address" value="" maxlength="<?php echo config ('unit_config', 'recommend', 'address_max_length'); ?>" title="請點選地圖或輸入景點住址!" x-webkit-speech/>
  </div>

  <div class="input-group model">
    <span class="input-group-addon">推薦照片</span>
    <input type="file" class="form-control" placeholder="請選擇大小不超過3MB的照片!" accept="<?php echo implode (', ', config ('unit_config', 'recommend', 'upload_picture', 'format_2s')); ?>" name="pictures[]" title="請選擇大小不超過 <?php echo (config ('unit_config', 'recommend', 'upload_picture', 'max_size') / 1024 / 1024); ?>MB 的照片!" data-formats="<?php echo implode ('|', config ('unit_config', 'recommend', 'upload_picture', 'format_1s')); ?>" data-max_size="<?php echo config ('unit_config', 'recommend', 'upload_picture', 'max_size'); ?>" />
    <span class="input-group-addon input-group-addon-end"><button type="button" name='delete_picture' class="btn btn-success btn-sm delete_picture" data-loading-text="-" >－</button></span>
  </div>

  <div class="input-group">
    <span class="input-group-addon input-group-addon-end"><button type="button" name='create_picture' id='create_picture' class="btn btn-info btn-sm create_picture" data-loading-text="+" >＋新增 推薦照片</button></span>
  </div>

<?php if (count ($unit_tags)) { ?>
  <div class="input-group">
    <span class="input-group-addon">景點分類</span>
    <div class='form-control'>
  <?php foreach ($unit_tags as $unit_tag) { ?>
          <label class='tag'><input type="checkbox" name='tags[]' id='tags[]' value='<?php echo $unit_tag->id; ?>'/> <?php echo $unit_tag->name; ?></label>
  <?php } ?>
    </div>
  </div>
<?php } ?>

  <div class='bottom_area'>
    <div class="bottoms row">
      <div class="col-md-6 alert_area">
        <div id='alert' class="alert alert-danger"></div>
      </div>
      <div class="col-md-７">
        <button type="button" id='create' class="btn btn-primary btn-sm" data-loading-text="請稍候.." >確定推薦</button>
        <button type="reset" id='clear' class="btn btn-warning btn-sm" data-loading-text="重新填寫" >重新填寫</button>
      </div>
    </div>
  </div>

</form>