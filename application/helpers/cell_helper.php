<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * @author      OA Wu <comdan66@gmail.com>
 * @copyright   Copyright (c) 2014 OA Wu Design
 */

include_once ('path_helper.php');

if (!function_exists ('render_cell')) {
  function render_cell () {
    if (count ($params = func_get_args ()) > 1) {
      $class = array_shift ($params);
      $method = array_shift ($params);
      $CI =& get_instance ();
      if (!isset ($CI->cell)) $CI->load->library ('cell');
      return $CI->cell->render_cell ($class, $method, $params);  
    } else { showError ('The render_cell params error!'); }
  }
}
if (!function_exists ('clear_cell')) {
  function clear_cell ($class, $method, $key = null) {
    $CI =& get_instance ();
    if (!isset ($CI->cell)) $CI->load->library ('cell');
    return $CI->cell->clear_cell ($class, $method, $key);  
  }
}


if (!function_exists ('clean_cell')) {
  function clean_cell () {
    $CI =& get_instance ();
    if (!isset ($CI->cell)) $CI->load->library ('cell');
    return $CI->cell->clean_cell ();  
  }
}

