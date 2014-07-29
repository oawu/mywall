<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * @author      OA Wu <comdan66@gmail.com>
 * @copyright   Copyright (c) 2014 OA Wu Design
 */

include_once ('type_helper.php');

if (!function_exists ('utilitySameLevelPath')) {
  function utilitySameLevelPath ($obj) {
    return verifyString ($obj) ? preg_replace ("/(https?:\/)\/?/", "$1/", preg_replace ('/\/(\.?\/)+/', '/', $obj)) : '';
  }
}

if (!function_exists ('utilityPath')) {
  function utilityPath ($obj) {
    return trim (utilitySameLevelPath ($obj), '/');
  }
}

if (!function_exists ('verifyExist')) {
  function verifyExist ($filePath) {
    return verifyString ($filePath) && file_exists ($filePath);
  }
}

if (!function_exists ('verifyFolderExist')) {
  function verifyFolderExist ($folderPath) {
    return verifyExist ($folderPath) && is_dir ($folderPath);
  }
}
  
if (!function_exists ('verifyFileExist')) {
  function verifyFileExist ($folderPath) {
    return verifyExist ($folderPath) && is_file ($folderPath);
  }
}

if (!function_exists ('verifyFolderReadable')) {
  function verifyFolderReadable ($folderPath) {
    return verifyFolderExist ($folderPath) && is_readable ($folderPath);
  }
}

if (!function_exists ('verifyFolderWriteable')) {
  function verifyFolderWriteable ($folderPath) {
    return verifyFolderExist ($folderPath) && is_writeable ($folderPath);
  }
}

if (!function_exists ('verifyFileReadable')) {
  function verifyFileReadable ($folderPath) {
    return verifyFileExist ($folderPath) && is_readable ($folderPath);
  }
}

if (!function_exists ('verifyFileWriteable')) {
  function verifyFileWriteable ($folderPath) {
    return verifyFileExist ($folderPath) && is_writeable ($folderPath);
  }
}

if (!function_exists ('ObjName2FileName')) {
  function ObjName2FileName ($ObjName) {
    $arr = array (); for ($i = 65; $i <= 90; $i++) $arr[chr ($i)] = "_" . chr ($i + 32);
    return preg_replace ('/^\_/', '', strtr ($ObjName, $arr));
  }
}

if (!function_exists ('FileName2ObjName')) {
  function FileName2ObjName ($FileName) {
    $arr = array (); for ($i = 65 + 32; $i <= 90 + 32; $i++) $arr[chr ($i)] = "_" . chr ($i - 32);
    return preg_replace ('/^\_/', '', strtr ($ObjName, $arr));
  }
}