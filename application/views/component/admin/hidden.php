<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * @author      OA Wu <comdan66@gmail.com>
 * @copyright   Copyright (c) 2014 OA Wu Design
 */
if (verifyArray ($hidden_list))
  foreach ($hidden_list as $hidden)
    echo form_hidden ($hidden['name'], $hidden['value'], $hidden['id']);