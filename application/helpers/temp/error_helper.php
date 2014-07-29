<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * @author      OA Wu <comdan66@gmail.com>
 * @copyright   Copyright (c) 2014 OA Wu Design
 */
if (!function_exists ('show_error')) {
  function show_error ($message) {
    echo '<meta http-equiv="Content-type" content="text/html; charset=utf-8" /><style type="text/css">fr { color: red;}</style><pre>';
    throw new Exception ('<fr>' . $message . '</fr>');
    echo '</pre>';
    exit ();
  }
}