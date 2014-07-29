<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * @author      OA Wu <comdan66@gmail.com>
 * @copyright   Copyright (c) 2014 OA Wu Design
 */
if (!function_exists ('utilitySameLevelPath')) {
  function utilitySameLevelPath ($path) {
    return is_string ($path) && strlen ($path) ? preg_replace ("/(https?:\/)\/?/", "$1/", preg_replace ('/\/(\.?\/)+/', '/', $path)) : '';
  }
}

if (!function_exists ('_config_recursive')) {
  function _config_recursive ($levels, $config) {
    return $levels ? isset ($config[$index = array_shift ($levels)]) ? _config_recursive ($levels, $config[$index]) : null : $config;
  }
}

if (!function_exists ('config')) {
  function config () {
    $data = null;
    if ($levels = array_filter (func_get_args ())) {
      $key = '_config_' . implode ('_|_', $levels);

      if ($CI =& get_instance () && !isset ($CI->cache))
        $CI->load->driver ('cache', array ('adapter' => 'apc', 'backup' => 'file'));

      if (!($data = $CI->cache->file->get ($key)) && ($config_name = array_shift ($levels)) && is_readable ($path = utilitySameLevelPath (FCPATH . APPPATH . 'config' . DIRECTORY_SEPARATOR . $config_name . EXT))) {
        include $path;
        $data = ($config_name = $$config_name) ? _config_recursive ($levels, $config_name) : null;
        $CI->cache->file->save ($key, $data, 60 * 60);
      }
    }
    return $data;
  }
}

if (!function_exists ('verifyDimension')) {
  function verifyDimension ($dimension) {
    return isset ($dimension['width']) && isset ($dimension['height']) && ($dimension['width'] > 0) && ($dimension['height'] > 0);
  }
}

if (!function_exists ('verifyCreateOrm')) {
  function verifyCreateOrm ($obj) {
    return is_object ($obj) && $obj->is_valid ();
  }
}

if (!function_exists ('web_file_exists')) {
  function web_file_exists ($url, $cainfo = null) {
    $options = array (CURLOPT_URL => $url, CURLOPT_NOBODY => 1, CURLOPT_FAILONERROR => 1, CURLOPT_RETURNTRANSFER => 1);

    if (is_readable ($cainfo))
      $options[CURLOPT_CAINFO] = $cainfo;

    $ch = curl_init ($url);
    curl_setopt_array ($ch, $options);
    return curl_exec ($ch) !== false;
  }
}

if (!function_exists ('download_web_file')) {
  function download_web_file ($url, $fileName, $is_use_reffer = false, $cainfo = null) {
    if (!web_file_exists ($url, $cainfo))
      return null;

    if (is_readable ($cainfo))
      $url = str_replace (' ', '%20', $url);

    $options = array (
      CURLOPT_URL => $url, CURLOPT_TIMEOUT => 120, CURLOPT_HEADER => false, CURLOPT_MAXREDIRS => 10,
      CURLOPT_AUTOREFERER => true, CURLOPT_CONNECTTIMEOUT => 30, CURLOPT_RETURNTRANSFER => true, CURLOPT_FOLLOWLOCATION => true,
      CURLOPT_USERAGENT => "Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/32.0.1700.76 Safari/537.36",
    );

    if (is_readable ($cainfo))
      $options[CURLOPT_CAINFO] = $cainfo;

    if ($is_use_reffer)
      $options[CURLOPT_REFERER] = $url;

    $ch = curl_init ($url);
    curl_setopt_array ($ch, $options);
    $data = curl_exec ($ch);
    curl_close ($ch);

    $write = fopen ($fileName, 'w');
    fwrite ($write, $data);
    fclose ($write);

    $oldmask = umask (0);
    @chmod ($fileName, 0777);
    umask ($oldmask);

    return filesize ($fileName) < 1 ? null : $fileName;
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