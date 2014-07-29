<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * @author      OA Wu <comdan66@gmail.com>
 * @copyright   Copyright (c) 2014 OA Wu Design
 */


  $header_list = $topbar_list && isset ($topbar_list['header']) ? $topbar_list['header'] : array ();
  $left_list = $topbar_list && isset ($topbar_list['left']) ? $topbar_list['left'] : array ();
  $right_list = $topbar_list && isset ($topbar_list['right']) ? $topbar_list['right'] : array ();

  function print_dropdowns ($navitem_list, $level = 0) {
    if (count ($navitem_list)) {
      foreach ($navitem_list as $navitem) {
        if ($navitem['name'] === null) { ?>
          <li class="divider"><?php echo !$level? '' : '';?></li>
  <?php } else if (count ($navitem['dropdowns'])) { ?>
          <li class="dropdown<?php echo $level ? '-submenu' : '';?>">
            <a class='dropdown-toggle' href="#" data-toggle="dropdown" title="<?php echo $navitem['title'];?>"><?php echo $navitem['name'];?> <?php echo !$level ? '' : '';?></a>
            <ul class="dropdown-menu">
              <?php print_dropdowns ($navitem['dropdowns'], $level + 1);?>
            </ul>
          </li>
  <?php } else if ($navitem['url'] === null) { ?>
          <li><a title="<?php echo $navitem['title'];?>"><?php echo $navitem['name'];?></a></li>
  <?php } else { ?>
          <li><a title="<?php echo $navitem['title'];?>" href="<?php echo $navitem['url'];?>"<?php echo ($navitem['target'] === null) ? '': (' target="' . $navitem['target'] . '"');?>><?php echo $navitem['name'];?></a></li>
  <?php }
      }
    }
  } ?>
  
  <nav class="navbar navbar-default">
    <div class="navbar-header">
  <?php if (count ($header_list)) {
          foreach ($header_list as $header) { ?>
            <a class="navbar-brand" href="<?php echo $header['url'];?>"><?php echo $header['name'];?></a>
    <?php }
        } ?>
    </div>

    <div class='my_collapse'>
<?php if (count ($left_list)) { ?>
        <ul class="nav navbar-nav">
          <?php print_dropdowns ($left_list); ?>
        </ul>
<?php } ?>

<?php if (count ($right_list)) { ?>
        <ul class="nav navbar-nav navbar-right">
          <?php print_dropdowns ($right_list); ?>
        </ul>
<?php } ?>

    </div>
  </nav>