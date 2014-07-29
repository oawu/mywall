<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * @author      OA Wu <comdan66@gmail.com>
 * @copyright   Copyright (c) 2014 OA Wu Design
 */

// include_once ('type_helper.php');

if (!function_exists ('utilitySameLevelPath')) {
  function utilitySameLevelPath ($path) {
    return is_string ($path) && strlen ($path) ? preg_replace ("/(https?:\/)\/?/", "$1/", preg_replace ('/\/(\.?\/)+/', '/', $path)) : '';
  }
}

// if (!function_exists ('_get_config_recursive')) {
//   function _get_config_recursive ($item) {
//     if ($levels = array_filter (func_get_args ()))
//       array_shift ($levels);

//     // $levels = array (); for ($i = 1; ($i < func_num_args ()) && verifyString ($level = func_get_arg ($i)); $i++) array_push ($levels, $level);

//     if (is_array ($levels) && $) {
//       if (($index_name = array_shift ($levels)) && isset ($item[$index_name]) && (($item = $item[$index_name]) !== null)) {
//         if (is_array ($item)) {
//           array_unshift ($levels, $item);
//           return call_user_func_array ('_get_config_recursive', $levels);
//         } else {
//           return $item;
//         }
//       } else { return null; }
//     } else { return $item; }
//   }
// }

if (!function_exists ('config')) {
  function config () {
    $levels = array_filter (func_get_args ());

    if ($levels && ($config_name = array_shift ($levels)) && is_readable ($path = utilitySameLevelPath (FCPATH . APPPATH . 'config' . DIRECTORY_SEPARATOR . $config_name . EXT))) {
      $CI =& get_instance ();
      
      if (!isset ($CI->cache))
        $CI->load->driver ('cache', array ('adapter' => 'apc', 'backup' => 'file'));

      $sec = 60 * 60;
      $key = '_config_' . $config_name . '_|_' . implode ('_|_', $levels);//preg_replace ('/\/|:|\./i', '_|_', $path);
      $key = '_config_' . $config_name;//preg_replace ('/\/|:|\./i', '_|_', $path);

      if (!($data = $CI->cache->file->get ($key))) {
        include $path;

        if ($config_name = $$config_name) {
          echo '<meta http-equiv="Content-type" content="text/html; charset=utf-8" /><pre>';
          var_dump ($levels);
          exit ();
          array_unshift ($levels, $config_name);
          $data = call_user_func_array ('_get_config_recursive', $levels);
        } else {
          $data = null;
        }
        $res = $CI->cache->file->save ($key, $data, $sec);
      }
      return $data;
    } else { return null; }
  }
}



// if (!function_exists ('utilityPath')) {
//   function utilityPath ($obj) {
//     return trim (utilitySameLevelPath ($obj), '/');
//   }
// }

// if (!function_exists ('verifyExist')) {
//   function verifyExist ($filePath) {
//     return verifyString ($filePath) && file_exists ($filePath);
//   }
// }

// if (!function_exists ('verifyFolderExist')) {
//   function verifyFolderExist ($folderPath) {
//     return verifyExist ($folderPath) && is_dir ($folderPath);
//   }
// }
  
// if (!function_exists ('verifyFileExist')) {
//   function verifyFileExist ($folderPath) {
//     return verifyExist ($folderPath) && is_file ($folderPath);
//   }
// }

// if (!function_exists ('verifyFolderReadable')) {
//   function verifyFolderReadable ($folderPath) {
//     return verifyFolderExist ($folderPath) && is_readable ($folderPath);
//   }
// }

// if (!function_exists ('verifyFolderWriteable')) {
//   function verifyFolderWriteable ($folderPath) {
//     return verifyFolderExist ($folderPath) && is_writeable ($folderPath);
//   }
// }

// if (!function_exists ('verifyFileReadable')) {
//   function verifyFileReadable ($folderPath) {
//     return verifyFileExist ($folderPath) && is_readable ($folderPath);
//   }
// }

// if (!function_exists ('verifyFileWriteable')) {
//   function verifyFileWriteable ($folderPath) {
//     return verifyFileExist ($folderPath) && is_writeable ($folderPath);
//   }
// }

// if (!function_exists ('ObjName2FileName')) {
//   function ObjName2FileName ($ObjName) {
//     $arr = array (); for ($i = 65; $i <= 90; $i++) $arr[chr ($i)] = "_" . chr ($i + 32);
//     return preg_replace ('/^\_/', '', strtr ($ObjName, $arr));
//   }
// }

// if (!function_exists ('FileName2ObjName')) {
//   function FileName2ObjName ($FileName) {
//     $arr = array (); for ($i = 65 + 32; $i <= 90 + 32; $i++) $arr[chr ($i)] = "_" . chr ($i - 32);
//     return preg_replace ('/^\_/', '', strtr ($ObjName, $arr));
//   }
// }