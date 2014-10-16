<?php
  echo render_cell ('menu_cells', 'index', 'merge_index');
?>
<div class='row'>
  <div class='col-md-4'>列表</div>
  <div class='col-md-4'>相似</div>
  <div class='col-md-4'>合併</div>
</div>

<div id='root' class='row'>
  <div id='tags' class='col-md-4' data-next_id='0' data-db_id='<?php echo $db_id ? $db_id : 0;?>'></div>
  <div id='likes' class='col-md-4'></div>
  <div id='chos' class='col-md-4'></div>
</div>