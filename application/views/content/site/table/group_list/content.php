<?php
  echo render_cell ('menu_cells', 'index', 'group_list');
?>
<div id='tags' data-next_id='0'>
  <div class='title'>Merge List</div>
<?php
    if ($tags) { ?>
      <table>
        <thead>
          <tr>
             <th>主要 Tag</th>
             <th>包含 Tags</th>
          </tr>
        </thead>
        <tbody>
    <?php foreach ($tags as $tag) { ?>
          <tr>
             <td>
                <div class='main_tag'>
                  <div class='jqui_tooltip name' title='<?php echo $tag->name;?>'><?php echo $tag->name;?></div>
                  <div class='id'><?php echo $tag->db_id;?></div>
                </div>
             </td>
             <td>
        <?php foreach ($tag->group_tags () as $group_tag) { ?>
                <div class='tag'>
                  <div class='jqui_tooltip name' title='<?php echo $group_tag->name;?>'><?php echo $group_tag->name;?></div>
                  <div class='id'><?php echo $group_tag->db_id;?></div>
                </div>
        <?php } ?>
             </td>
          </tr>  
    <?php } ?>
        </tbody>
      </table>
<?php
    } else { ?>
      <div class='no-data'>沒有任何資料</div>
<?php
    } ?>
</div>