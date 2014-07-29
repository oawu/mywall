<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

if (isset ($sidebar_list) && count ($sidebar_list)) { ?>
  <div class="bs-sidebar">
<?php
    foreach ($sidebar_list as $title => $sidebars) { ?>
    <ul class="list-group">
<?php if (($title !== '') && ($title !== null)) { ?>
        <li class="list-group-item title"><?php echo $title; ?></li>
<?php } ?>
  <?php if (count ($sidebars)) {
          foreach ($sidebars as $sidebar) { ?>
            <li class="list-group-item<?php echo verifyNotNull ($sidebar['src']) ? ' pointer':'';?>" data-url='<?php echo verifyNotNull ($sidebar['src']) ? $sidebar['src']:'';?>'><?php echo $sidebar['name']; ?></li>
    <?php }
        } ?>
    </ul>
<?php
    } ?>
  </div>
<?php
}