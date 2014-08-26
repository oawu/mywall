<?php
  if ($components)
    foreach ($components as $component)
      echo $component; ?>
<div id='pf_root'>
  <div class='row pf_main_area'>
    <div class="col-md-6 pf_left_main_area">
      <div id='pf_pic_area' class='pf_pic_area'>
        <img src='<?php echo base_url (array ('resource', 'image', 'default', 'upload.jpg'));?>' data-ori_src='<?php echo base_url (array ('resource', 'image', 'default', 'upload.jpg'));?>' />
      </div>
      <div class='pf_choice_area'>
        <div id='pf_fileuploader'>選擇圖片</div>
      </div>
      <div class='pf_disable_panel'></div>
    </div>
    <div class="col-md-6 pf_right_main_area">
      <div class='pf_text_area'>
        <textarea id='pf_text' name='pf_text' placeholder='快輸入敘述，讓照片更生動吧！' class='form-control pf_text'></textarea>
      </div>
      <div class='pf_tags'>
        <div id='pf_tags_area' class='pf_tags_area' placeholder='快來為這張照片選擇些專屬的標簽吧！'></div>

        <div class='row pf_tag_choice'>
          <div class="col-md-9"><input type="text" id='pf_tag_choice' class="form-control" placeholder="請輸入要新增的標簽！" value="" maxlength="100" x-webkit-speech /></div>
          <div class="col-md-3" style='margin-top: 2px;'>
            <button type="button" id='pf_create_tag_choice' class="btn btn-primary btn-sm" data-loading-text="請稍候.." >新增</button>
          </div>
        </div>
      </div>

      <div class='row control_area'>
        <div class="col-md-8">
          <label class='sync_fb'><input type="checkbox" name='sync_fb' id='pf_sync_fb' value='true' checked/> 同步至 Facebook</label>
        </div>
        <div class="col-md-4">
          <button type="button" id='pf_submit' class="btn btn-primary btn-sm" data-loading-text="請稍候.." >確定送出</button>
        </div>
      </div>
    </div>
  </div>
</div>
