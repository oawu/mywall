<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * @author      OA Wu <comdan66@gmail.com>
 * @copyright   Copyright (c) 2014 OA Wu Design
 */

include_once ('type_helper.php');

if (!function_exists ('verifyDimension')) {
  function verifyDimension ($dimension) {
    return verifyArrayFormat ($dimension, array ('width', 'height')) && verifyNumber ($dimension['width'], 1) && verifyNumber ($dimension['height'], 1);
  }
}