<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * @author      OA Wu <comdan66@gmail.com>
 * @copyright   Copyright (c) 2014 OA Wu Design
 */
if (verifyArray ($visit_menu_list))
  foreach ($visit_menu_list as $i => $visit_menu)
    if (array_key_exists ('separate', $visit_menu) && $visit_menu['separate']) echo "<span class='separate'></span>";
    else echo "<div class='visit_menu" . (verifyNotNull ($visit_menu['src']) ? ' has_url' : '') . (verifyNotNull ($visit_menu['class']) ? (' ' . $visit_menu['class']) : '') . "'" . (verifyNotNull ($visit_menu['src']) ? (" onClick='window.location.assign (\"" . $visit_menu['src']. "\")'") : "") . ">" . $visit_menu['name'] . "</div>" . ($i < (count ($visit_menu_list) - 1) ? "<span class='visit_menu_dot'>|</span>" : "");
