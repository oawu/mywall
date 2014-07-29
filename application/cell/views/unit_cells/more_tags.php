<?php
  if (count ($more_tags)) {
    $exclude_ids = array ($unit->id);
    $i = 0;
    foreach ($more_tags as $more_tag) {
      if ($i++ <= config ('unit_config', 'id', 'more_tags_max_length')) {
        if (count ($more_tag->units) && count ($more_tag_units = array_filter (array_map (function ($more_tag_unit) use ($unit, $exclude_ids) { return ($unit->id == $more_tag_unit->id) || in_array ($more_tag_unit->id, $exclude_ids) ? null : $more_tag_unit; }, $more_tag->units)))) { ?>
          <div class='units_list'>
            <div class='main_title'>
              <div class='row'>
                <div class="col-md-8 units_title">
                  <?php echo $more_tag->name; ?>
                </div>
                <div class="col-md-4 units_more">
                  <a href='<?php echo base_url (array ('units', 'tags', $more_tag->name));?>' target='_blank'>更多...</a>
                </div>
              </div>
            </div>
            <div class='unit_list'>
        <?php $j = 0;
              foreach ($more_tag_units as $more_unit) {
                if ($j++ <= config ('unit_config', 'id', 'more_tag_units_max_length')) {
                  array_push ($exclude_ids, $more_unit->id); ?>
                  <a href='<?php echo base_url (array ('units', 'id', $more_unit->id)); ?>'>
                    <div class='unit'>
                      <img src='<?php echo $more_unit->first_picture ('100x100C'); ?>' />
                      <div class='title'><?php echo $more_unit->name; ?></div>
                    </div>
                  </a>
          <?php }
              } ?>
            </div>
          </div>
  <?php }
      }
    }
  }