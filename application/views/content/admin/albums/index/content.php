<h2><?php echo $feature_name_1?> 列表</h2>
<br/>

<input type='button' value='搜尋 <?php echo $feature_name_1?>' class='OA-ui-OA_Button' id='target_index_list_search'/>
<input type='button' value='新增 <?php echo $feature_name_1?>' class='OA-ui-OA_Button' onClick='window.location.assign ("<?php echo $create_url; ?>");'/>

<hr/>

<form id="search_form" method="post" action="<?php echo $search_url; ?>" style='<?php echo $has_append_condition ? '' : 'display: none;';?>'>
  <table class='search_list'>
    <tbody>
      <tr><th>編號</th><td><input type='text' name='id' value="<?php echo $id?>" placeholder='請輸入要搜尋的 編號...' class='form-control' x-webkit-speech/></td></tr>
      <tr><th>標題</th><td><input type='text' name='title' value="<?php echo $title?>" placeholder='請輸入要搜尋的 標題...' class='form-control' x-webkit-speech/></td></tr>
      <tr><th>敘述</th><td><input type='text' name='description' value="<?php echo $description?>" placeholder='請輸入要搜尋的 敘述...' class='form-control' x-webkit-speech/></td></tr>
      <tr><td colspan='2'>
        <input type="submit" class='OA-ui-OA_Button' value="確定搜尋"/>
        <input type="reset" class='OA-ui-OA_Button' value="重新填寫"/>
        </td></tr>
    </tbody>
  </table>
  <hr/>
</form>

<?php
  if (count ($objects)) { ?>
    <div class='row'><div class="col-md-6">總共有 <?php echo $total_rows;?> 筆資料。</div><div class="col-md-6"><?php echo $pagination;?></div></div>
    <table class='list'>
      <thead>
        <tr>
          <td>排序</td>
          <td>編號</td>
          <td>標題</td>
          <td>敘述</td>
          <td><?php echo $feature_name_2; ?></td>
          <td>新增日期</td>
          <td>細節/新增/修改/刪除</td></tr>
      </thead>
      <tbody id='sortable'>
  <?php foreach ($objects as $object) { ?>
          <tr class='item' data-id='<?php echo $object->id;?>'>
            <td width='50' class='handle'><span class='icon-move2'></span></td>
            <td width='50'><?php echo $object->id;?></td>
            <td width='100'><?php echo $object->title;?></td>
            <td width='100'><?php echo $object->description;?></td>
            <td>
        <?php if (count ($object->pictures)) {
                foreach ($object->pictures as $i => $picture) { 
                  if ($i < 3) { ?>
                    <img class='fancybox' src='<?php echo $picture->file_name->url ('100xW'); ?>' href='<?php echo $picture->file_name->url ('1400xW');?>'/>
            <?php } else { ?>
                    ...
            <?php   break;
                  }
                }
              } else { ?>
                  <strong>提示!</strong> 目前沒有任何資料。
        <?php } ?>
            </td>
            <td width='180'><?php echo $object->created_at;?></td>
            <td width='160'>
              <span class='icon-details jqui_tooltip' onClick='window.location.assign ("<?php echo $detail_url . '/' . $object->id; ?>");' title='瀏覽 <?php echo $feature_name_1?> 細節'></span>
              /
              <span class='glyphicon glyphicon-upload jqui_tooltip' onClick='window.location.assign ("<?php echo $create_picture_url . '/' . $object->id; ?>");' title='新增 <?php echo $feature_name_1?> <?php echo $feature_name_2?>'></span>
              /
              <span class='icon-edit jqui_tooltip' onClick='window.location.assign ("<?php echo $update_url . '/' . $object->id; ?>");' title='修改 <?php echo $feature_name_1?>'></span>
              /
              <span class='icon-trash2 jqui_tooltip' onClick='window.location.assign ("<?php echo $delete_url . '/' . $object->id; ?>");' title='刪除 <?php echo $feature_name_1?>'></span>
            </td>
          </tr>
  <?php } ?>
      </tbody>
    </table>
    <div class='row'><div class="col-md-6">總共有 <?php echo $total_rows;?> 筆資料。</div><div class="col-md-6"><?php echo $pagination;?></div></div>
<?php
  } else { ?>
    <div class="alert alert-info">
      <strong>提示!</strong> 目前沒有任何資料。
    </div>
<?php
  }
?>
<hr/>
<div class='row'><div class="col-md-6"></div><div class="col-md-6"><?php echo $run_time;?></div></div>
