<?php
  if (count ($tags)) {
    foreach ($tags as $tag) {
      if (count ($tag->units)) { ?>
        <div class='title_area'>
          <div class='tag_name'><?php echo $tag->name; ?></div>
          <div class='units_count'>(<?php echo $tag->units_count; ?>)</div>
        </div>
        <div class='units'>
    <?php foreach ($tag->units as $unit) { ?>
            <a href='<?php echo base_url (array ('units', 'id', $unit->name));?>' target='_blank'>
              <div class='unit'>
                <div class='top name'><?php echo $unit->name; ?></div>
                <img class='main_picture' src='<?php echo $unit->first_picture ('190x190W'); ?>' />
                <div class='bottom row'>
                  <div class='col-md-7 score'>
              <?php if (count ($stars = $unit->score_star (5))) {
                      foreach ($stars as $star) { ?>
                        <span class='icon-star<?php echo $star + 4;?>'></span>
              <?php   }
                    } ?>
                  </div>
                  <div class='col-md-5 comments_count'>
                    <span class='icon-comments'></span>
                    <?php echo $unit->comments_count; ?>
                  </div>
                </div>
              </div>
            </a>
    <?php } ?>
        </div>
<?php }
    }
  }