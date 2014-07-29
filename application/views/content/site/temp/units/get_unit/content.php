<?php
  if (isset ($unit)) { ?>
    <div class='unit' data-id='<?php echo $unit->id; ?>' data-url='<?php echo base_url (array ('units', 'id', $unit->id)); ?>' data-latitude='<?php echo $unit->latitude; ?>' data-longitude='<?php echo $unit->longitude; ?>'>
      <div class='row'>
        <div class="col-md-3 picture_panel">
          <div class='picture'>
            <img src='<?php echo $unit->first_picture ('60x55C'); ?>' />
          </div>
        </div>
        <div class="col-md-9">
          <div class='name'><?php echo $unit->name; ?></div>
          <div class='address'><?php echo $unit->address; ?></div>
          <div class='score' data-score='1'>
      <?php if (count ($stars = $unit->score_star (5))) {
              foreach ($stars as $star) { ?>
                <span class='icon-star<?php echo $star + 4;?>'></span>
      <?php   }
            } ?>
          </div>
        </div>
      </div>
    </div>
  <?php
} else { ?>
  <div class='no_unit'>目前沒有任何景點</div>
<?php
} ?>