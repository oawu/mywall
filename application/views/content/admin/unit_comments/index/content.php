<t2>列表 <?php echo $feature_name; ?></t2>

<input type='button' value='搜尋 <?php echo $feature_name?>' class='OA-ui-OA_Button' id='target_index_list_search'/>

<form id="search_form" method="post" action="<?php echo $search_url; ?>" style='<?php echo $has_append_condition ? '' : 'display: none;';?>'>
  <table class='search_list'>
    <tbody>
      <tr><th>景點編號</th><td><input type='number' name='unit_id' value="<?php echo $unit_id; ?>" placeholder='請輸入要搜尋的 景點編號...' class='form-control' x-webkit-speech/></td></tr>
      <tr><th>使用者編號</th><td><input type='number' name='user_id' value="<?php echo $user_id; ?>" placeholder='請輸入要搜尋的 使用者編號...' class='form-control' x-webkit-speech/></td></tr>
      <tr><th>留言內容</th><td><input type='text' name='message' value="<?php echo $message; ?>" placeholder='請輸入要搜尋的 內容...' class='form-control' x-webkit-speech/></td></tr>
      </td></tr>
      <tr><th>是否同步FB</th><td>
        <select id="is_sync" name="is_sync" class='form-control'>
          <option value=""<?php echo '' == $is_sync ? ' selected' : ''; ?>>全選</option>
          <option value="1"<?php echo '1' == $is_sync ? ' selected' : ''; ?>>是</option>
          <option value="0"<?php echo '0' == $is_sync ? ' selected' : ''; ?>>否</option>
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
        <td width='100'>景點名稱</td>
        <td width='100'>使用者</td>
        <td width='100'>使用者頭像</td>
        <td>內容</td>
        <td width='120'>是否同步FB</td>
        <td width='120'>新增時間</td>
        <td width='40'>編輯</td>
    </thead>
    <tbody>
<?php foreach ($objects as $object) { ?>
        <tr class='item' data-id='<?php echo $object->id;?>'>
          <td><?php echo $object->id;?></td>
          <td class='jqui_tooltip' title='Unit ID: <?php echo $object->unit_id;?>'><?php echo mb_strimwidth ($object->unit->name, 0, 50, '…','UTF-8');?></td>
          <td class='jqui_tooltip' title='User ID: <?php echo $object->user->id;?><hr/>FB ID: <?php echo $object->user->uid;?>'><?php echo $object->user->name;?></td>
          <td>
      <?php echo img ($object->user->avatar_url (60, 60), false, 'class="fancybox avatar" data-fancybox-group="fancybox-group-content_picture" style="" href="' . $object->user->avatar_url (480, 320) . '&.jpg"'); ?>
          </td>
          <td><?php echo $object->message;?></td>
          <td><?php echo $object->is_sync ? '是' : '否';?></td>
          <td class='created_at jqui_tooltip' title='<?php echo $object->created_at;?>' data-time='<?php echo $object->created_at;?>'></td>
          <td>
            <a class='icon-remove2 jqui_tooltip' title='移除資料' href='<?php echo $delete_url . '/' . $object->id?>'></a>
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
