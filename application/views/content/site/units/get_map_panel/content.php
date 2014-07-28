<?php
  if (count ($unit_tags) || count ($special_tags)) { ?>
    <select class="form-control" id='unit'>
<?php if (count ($special_tags)) {
        foreach ($special_tags as $special_tag) { ?>
          <option value="<?php echo $special_tag->id; ?>"><?php echo $special_tag->name; ?> (<?php echo $special_tag->unit_count (); ?>)</option>
  <?php }
      } 
      if (count ($unit_tags)) {
        foreach ($unit_tags as $unit_tag) { ?>
          <option value="<?php echo $unit_tag->id; ?>"><?php echo $unit_tag->name; ?> (<?php echo $unit_tag->units_count; ?>)</option>
  <?php }
      } ?>
    </select>
<?php
  } ?>

  <div id='unit_list'></div>