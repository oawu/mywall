<t2>列表 <?php echo $feature_name; ?></t2>

<input type='button' value='搜尋 <?php echo $feature_name?>' class='OA-ui-OA_Button' id='target_index_list_search'/>
<input type='button' value='新增 <?php echo $feature_name?>' class='OA-ui-OA_Button' onClick='window.location.assign ("<?php echo $create_url; ?>");'/>

<form id="search_form" method="post" action="<?php echo $search_url; ?>" style='<?php echo $has_append_condition ? '' : 'display: none;';?>'>
  <table class='search_list'>
    <tbody>
      <tr><th>名稱</th><td><input type='text' name='object_name' value="<?php echo $name; ?>" placeholder='請輸入要搜尋的 名稱...' class='form-control' x-webkit-speech/></td></tr>
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
        <td>名稱</td>
        <td width='120'>景點數</td>
        <td width='130'>新增時間</td>
        <td width='40'>編輯</td>
    </thead>
    <tbody>
<?php foreach ($objects as $object) { ?>
        <tr class='item' data-id='<?php echo $object->id;?>'>
          <td><?php echo $object->id;?></td>
          <td><?php echo $object->name;?></td>
          <td><?php echo $object->units_count;?></td>
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
