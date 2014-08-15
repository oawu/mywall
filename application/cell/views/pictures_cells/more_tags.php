<?php
  if (count ($more_tags)) {
    $exclude_ids = array ($picture->id);
    $i = 0;
    foreach ($more_tags as $more_tag) {
      if (++$i <= config ('pictures_controller_config', 'more_tags_max_length')) {
        if (count ($more_tag->pictures) && count ($more_tag_pictures = array_filter (array_map (function ($more_tag_picture) use ($picture, $exclude_ids) { return ($picture->id == $more_tag_picture->id) || in_array ($more_tag_picture->id, $exclude_ids) ? null : $more_tag_picture; }, $more_tag->more_tag_pictures)))) { ?>
          <div class='pictures_list'>
            <div class='main_title'>
              <div class='row'>
                <div class="col-md-8 pictures_title">
                  <?php echo $more_tag->name; ?>
                </div>
                <div class="col-md-4 pictures_more">
                  <a href='<?php echo base_url (array ('tags', $more_tag->name));?>' target='_blank'>更多...</a>
                </div>
              </div>
            </div>
            <div class='picture_list'>
        <?php $j = 0;
              foreach ($more_tag_pictures as $more_picture) {
                if ($j++ < config ('pictures_controller_config', 'more_tag_pictures_max_length')) {
                  array_push ($exclude_ids, $more_picture->id); ?>
                  <a href='<?php echo base_url (array ('pictures', $more_picture->id)); ?>'>
                    <div class='picture'>
                      <img src='<?php echo $more_picture->file_name->url ('100xW'); ?>' />
                      <div class='title'><?php echo mb_strimwidth ($more_picture->text, 0, 50, '…', 'UTF-8'); ?></div>
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