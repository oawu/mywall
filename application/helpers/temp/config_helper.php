<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * @author      OA Wu <comdan66@gmail.com>
 * @copyright   Copyright (c) 2014 OA Wu Design
 */

include_once ('path_helper.php');

if (!function_exists ('_get_config_recursive')) {
  function _get_config_recursive ($item) {
    $levels = array (); for ($i = 1; ($i < func_num_args ()) && verifyString ($level = func_get_arg ($i)); $i++) array_push ($levels, $level);
    if (count ($levels)) {
      if (verifyString ($index_name = array_shift ($levels)) && isset ($item[$index_name]) && verifyNotNull ($item = $item[$index_name])) {
        if (verifyArray ($item)) { array_unshift ($levels, $item); return call_user_func_array ('_get_config_recursive', $levels); }
        else if ((verifyString ($item) || verifyNumber ($item) || verifyBoolean ($item)) && !count ($levels)) { return $item; }
        else { return null; }
      } else { return null; }
    } else { return $item; }
  }
}

if (!function_exists ('config')) {
  function config () {
    $levels = array_filter (func_get_args ());
    if (count ($levels) && verifyString ($config_name = array_shift ($levels)) && verifyFileReadable ($path = FCPATH . APPPATH . 'config' . DIRECTORY_SEPARATOR . $config_name . EXT)) {
      $CI =& get_instance ();
      if (!isset ($CI->cache)) $CI->load->driver ('cache', array ('adapter' => 'apc', 'backup' => 'file'));

      $sec = 60 * 60;
      $key = '_config_' . $config_name . '_|_' . implode ('_|_', $levels);//preg_replace ('/\/|:|\./i', '_|_', $path);

      if (!($data = $CI->cache->file->get ($key))) {
        include ($path);
        if (verifyArray ($config_name = $$config_name)) {
          array_unshift ($levels, $config_name);
          $data = call_user_func_array ('_get_config_recursive', $levels);
        } else { $data = null; }
        $res = $CI->cache->file->save ($key, $data, $sec);
      }
      return $data;
    } else { return null; }
  }
}
