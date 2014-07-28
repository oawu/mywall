<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

if (isset ($footer_list) && count ($footer_list)) { ?>
  <div id='footer'>
    <div class='dividing_line_area row'>
      <div class="col-md-5 dividing_line"></div>
      <div class="col-md-2 copy_right_title">
        Beigang Matsu © 2014
      </div>
      <div class="col-md-5 dividing_line"></div>
    </div>
    <div class='link_groups'>
<?php
    foreach ($footer_list as $title => $footers) { ?>
    <div class='link_group' style='width: <?php echo 1200 / count ($footer_list);?>px;'>
      <div class='links_title'>
        <?php echo $title; ?>
      </div>
      <div class='link_list'>
  <?php if (count ($footers)) {
          foreach ($footers as $footer) { ?>
            <div class='link_tag'><a href='<?php echo $footer['src']; ?>' target='_blank'><?php echo $footer['name']; ?></a></div>
    <?php }
        } ?>
      </div>
    </div>
<?php
    } ?>
    </div>

    <div class='dividing_line_area row'>
      <div class="col-md-3 dividing_line"></div>
      <div class="col-md-6 contact">如有 <u>相關問題</u> 或 <u>建議</u> 歡迎來信 <font color='#333'>comdan66@gmail.com</font> 或至 <a href='https://www.facebook.com/comdan66' target='_blank'>作者</a> 臉書留言。</div>
      <div class="col-md-3 dividing_line"></div>
    </div>
  </div>
<?php
}