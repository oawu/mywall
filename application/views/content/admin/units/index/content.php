<t2>列表 <?php echo $feature_name; ?></t2>

<input type='button' value='搜尋 <?php echo $feature_name?>' class='OA-ui-OA_Button' id='target_index_list_search'/>

<form id="search_form" method="post" action="<?php echo $search_url; ?>" style='<?php echo $has_append_condition ? '' : 'display: none;';?>'>
  <table class='search_list'>
    <tbody>
      <tr><th>名稱</th><td><input type='text' name='name' value="<?php echo $name; ?>" placeholder='請輸入要搜尋的 名稱...' class='form-control' x-webkit-speech/></td></tr>
      <tr><th>簡介</th><td><input type='text' name='introduction' value="<?php echo $introduction; ?>" placeholder='請輸入要搜尋的 簡介...' class='form-control' x-webkit-speech/></td></tr>
      <tr><th>住址</th><td><input type='text' name='address' value="<?php echo $address; ?>" placeholder='請輸入要搜尋的 住址...' class='form-control' x-webkit-speech/></td></tr>
      <tr><th>狀態</th><td>
        <select id="status" name="status" class='form-control'>
          <option value=""<?php echo '' == $status ? ' selected' : ''; ?>>全選</option>
    <?php if (count ($status_list)) {
            foreach ($status_list as $key => $name) { ?>
              <option value="<?php echo $key; ?>"<?php echo $key == $status ? ' selected' : ''; ?>><?php echo $name; ?></option>
        <?php }
          } ?>
        </select>
      </td></tr>
      <tr><td colspan='2'>
        <input type="submit" class='OA-ui-OA_Button' value="確定搜尋"/>
        <input type="reset" class='OA-ui-OA_Button' value="重新填寫"/>
        </td></tr>
    </tbody>
  </table>
</form>

<?php
  if (count ($objects)) { ?>
  <div class='row' style='margin-top: 5px;'><div class="col-md-3 total_rows">總共有 <?php echo $total_rows;?> 筆資料。</div><div class="col-md-9 pagination_area"><?php echo $pagination;?></div></div>
    <table class='list'>
    <thead>
      <tr>
        <td width='60'>編號</td>
        <td width='100'>使用者名稱</td>
        <td width='100'>景點名稱</td>
        <td width='80'>上傳圖片</td>
        <td width='80'>街景</td>
        <td width='100'>標籤</td>
        <td>景點簡介</td>
        <td width='100'>景點住址</td>
        <td width='50'>分數</td>
        <td width='50'>留言數</td>
        <td width='110'>新增時間</td>
        <td width='170'>編輯</td>
    </thead>
    <tbody>
<?php foreach ($objects as $object) { ?>
        <tr class='item' data-id='<?php echo $object->id;?>'>
          <td><?php echo $object->id;?></td>
          <td class='jqui_tooltip' title='User ID: <?php echo $object->user_id;?><hr/>FB ID: <?php echo $object->user->uid;?>'><?php echo $object->user->name;?></td>
          <td><?php echo $object->name;?></td>
          <td>
      <?php if (count ($pictures = $object->pictures)) {
              foreach ($pictures as $picture) {
                echo img ($picture->picture_url ('60x55C'), false, 'class="fancybox" data-fancybox-group="fancybox-group-content_picture_' . $object->id . '" style="" href="' . $picture->picture_url () . '"');
              }
            } ?>
          </td>
          <td><?php echo verifyObject ($view = $object->view) ? "<a href='" . $create_view_url . '/' . $object->id . "'>" . img ($view->picture_url ('60x55'), false, 'style="cursor: pointer;"') . '</a>' . "<button type='button' class='btn btn-danger btn-sm delete_view' name='delete_view' data-create_url='" . $create_view_url . '/' . $object->id . "' data-loading-text='請稍候..' data-view_id='" . $view->id . "'>移除街景</button>" : "<a class='btn btn-info btn-sm create_view' name='create_view' href='" . $create_view_url . '/' . $object->id . "'>新增街景</a>"?></td>
          <td>
      <?php if (count ($tags = $object->tags)) {
              foreach ($tags as $tag) { ?>
                <span class='tag'><?php echo $tag->name;?></span>
        <?php }
            } ?>
          </td>
          <td><?php echo mb_strimwidth ($object->introduction, 0, 200, '…','UTF-8');?></td>
          <td><?php echo $object->address;?></td>
          <td><?php echo $object->score;?></td>
          <td><?php echo $object->comments_count;?></td>
          <td class='created_at jqui_tooltip' title='<?php echo $object->created_at;?>' data-time='<?php echo $object->created_at;?>'></td>
          <td>
            <a class='icon-pencil2 jqui_tooltip' title='修改資料' href='<?php echo $update_url . '/' . $object->id?>'></a>
            /
            <a class='icon-remove2 jqui_tooltip' title='移除資料' href='<?php echo $delete_url . '/' . $object->id?>'></a>
            /
            <a class='icon-eye4 jqui_tooltip' title='檢視資料' href='<?php echo base_url (array ('units', 'id', $object->id)); ?>' target='_blank'></a>
            /
            <a class='icon-comments jqui_tooltip' title='檢視留言' href='<?php echo $comments_url . '/' . $object->id?>'></a>
            <br/>
            <div class="btn-group" data-toggle="buttons">
        <?php if (count ($status_list)) {
                foreach ($status_list as $key => $name) { ?>
                  <label class="btn btn-info btn-xs<?php echo $object->status == $key ? ' active' : ''; ?>"><input type="radio" value='<?php echo $key;?>' data-object_id="<?php echo $object->id; ?>"><?php echo $name;?></label>
          <?php }
              } ?>
            </div>
          </td>
        </tr>
<?php } ?>
    </tbody>
  </table>
  <div class='row'><div class="col-md-3 total_rows">總共有 <?php echo $total_rows;?> 筆資料。</div><div class="col-md-9 pagination_area"><?php echo $pagination;?></div></div>
<?php
  } else { ?>
    <div class="alert alert-info">
      <strong>提示!</strong> 目前沒有任何資料。
    </div>
<?php
  } ?>
<div class='row'><div class="col-md-6"></div><div class="col-md-6 run_time"><?php echo $run_time;?></div></div>
