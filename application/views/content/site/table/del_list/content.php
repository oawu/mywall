<?php
  echo render_cell ('menu_cells', 'index', 'output_del');
?>
<div id='tags' data-next_id='0'>
  <div class='title'>刪除 List</div>
<?php
    if ($tags) { ?>
      <table>
        <thead>
          <tr>
             <th>Tag ID</th>
             <th>Tag name</th>
          </tr>
        </thead>
        <tbody>
    <?php foreach ($tags as $tag) { ?>
          <tr>
             <td><?php echo $tag->db_id;?></td>
             <td><?php echo $tag->name;?></td>
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