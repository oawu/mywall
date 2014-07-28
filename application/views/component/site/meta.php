<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * @author      OA Wu <comdan66@gmail.com>
 * @copyright   Copyright (c) 2014 OA Wu Design
 */
if (verifyArray ($meta_list))
  foreach ($meta_list as $meta) 
    echo meta ($meta['name'], $meta['content'], $meta['type'], $meta['newline'] ? "\n": "");
