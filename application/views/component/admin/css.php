<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * @author      OA Wu <comdan66@gmail.com>
 * @copyright   Copyright (c) 2014 OA Wu Design
 */
if (verifyArray ($css_list))
  foreach ($css_list as $css) 
    echo $css['exist'] ? (link_tag ($css['src']) . "\n") : ("<!-- not exist! " . link_tag ($css['src']) . " -->\n");