<div id='menu'>
  <a class='btn btn-info btn-sm item<?php echo $now == 'index' ? ' active': '';?>' href='<?php echo base_url (array ('main'));?>'>刪除</a>
  <a class='btn btn-info btn-sm item<?php echo $now == 'trash' ? ' active': '';?>' href='<?php echo base_url (array ('main', 'trash'));?>'>復活</a>
  <div class='line'>&nbsp;</div>
  <a class='btn btn-info btn-sm item<?php echo $now == 'merge_index' ? ' active': '';?>' href='<?php echo base_url (array ('merge', 'index'));?>'>合併</a>
  <div class='line'>&nbsp;</div>
<!--   <a class='btn btn-info btn-sm item<?php echo $now == 'del_list' ? ' active': '';?>' href='<?php echo base_url (array ('table', 'del_list'));?>'>要刪除 List</a>
  <a class='btn btn-info btn-sm item<?php echo $now == 'group_list' ? ' active': '';?>' href='<?php echo base_url (array ('table', 'group_list'));?>'>要 Merge 的 List</a>
  <div class='line'>&nbsp;</div> -->
  <a class='btn btn-info btn-sm item<?php echo $now == 'output_delect' ? ' active': '';?>' href='<?php echo base_url (array ('output', 'del_list'));?>'>Delete excel</a>
  <a class='btn btn-info btn-sm item<?php echo $now == 'output_merge' ? ' active': '';?>' href='<?php echo base_url (array ('output', 'index'));?>'>Merge excel</a>
</div>