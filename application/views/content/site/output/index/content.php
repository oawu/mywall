<?php
  echo render_cell ('menu_cells', 'index', 'output_merge');
?>
<div id='tags' data-next_id='0'>
  <div class='title'>Excel Format List</div>
  <!-- <a id='copy' class='btn btn-primary btn-sm item'>Copy Table</a> -->
<?php
    if ($tags) { ?>
      <table id='excel_table'>
        <thead>
          <tr>
             <th colspan='2' style='background-color: rgba(255, 229, 153, 1.00);'>主要 Tag</th>
             <th colspan='2' style='background-color: rgba(255, 229, 153, 1.00);'>同性值得 Tag</th>
          </tr>
        <thead>
        <tbody>
          <tr>
             <td class='main1' style='background-color: rgba(255, 242, 204, 1.00);'>ID</td>
             <td class='main2' style='background-color: rgba(255, 242, 204, 1.00);'>名稱</td>
             <td class='ids' style='background-color: rgba(255, 242, 204, 1.00);'>ID</td>
             <td class='names' style='background-color: rgba(255, 242, 204, 1.00);'>名稱</td>
          </tr>
    <?php foreach ($tags as $tag) {
            if ($group_tags = $tag->group_tags ()) {?>
              <tr class='main_tr'>
                <td class='main1' rowspan='<?php echo count ($group_tags);?>'><?php echo $tag->id;?></td>
                <td class='main2' rowspan='<?php echo count ($group_tags);?>'><?php echo $tag->name;?></td>
                <td class='ids'><?php echo $group_tags[0]->id;?></td>
                <td class='names'><?php echo $group_tags[0]->name;?></td>
              </tr>
        <?php array_shift ($group_tags);
              if ($group_tags) {
                foreach ($group_tags as $group_tag) { ?>
                  <tr>
                    <td class='ids'><?php echo $group_tag->id;?></td>
                    <td class='names'><?php echo $group_tag->name;?></td>
                  </tr>
          <?php }
              }
            }
          } ?>

        </tbody>
      </table>
<?php
    } else { ?>
      <div class='no-data'>沒有任何資料</div>
<?php
    } ?>


<?php










    if ($tags) { /* ?>
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
<?php */
    } else { ?>
      <div class='no-data'>沒有任何資料</div>
<?php
    } ?>
</div>