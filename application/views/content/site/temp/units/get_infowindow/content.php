<?php
  if ($unit) { ?>
    <div class='infowindow_panel'>
      <div class='infowindow_picture'>
        <img src='<?php echo $unit->first_picture ('250x100C'); ?>' />
      </div>
      <div class='infowindow_info'>
        <div class='name'><?php echo $unit->name; ?></div>
        <div class='introduction'><?php echo  mb_strimwidth ('&nbsp;&nbsp;&nbsp;&nbsp;' . strip_tags ($unit->introduction), 0, 100, '', 'UTF-8'); ?>…<div class='more_panel'><span class="more">更多詳細介紹 >></span></div></div>
      </div>
    </div>
  <?php
} ?>