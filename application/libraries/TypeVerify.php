<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class TypeVerify {
  
  public static function verifyBase ($obj) {
    return isset ($obj) && ($obj !== null);
  }

  public static function verifyBoolean ($obj) {
    return self::verifyBase ($obj) && is_bool ($obj);
  }

  public static function verifyObject ($obj) {
    return self::verifyBase ($obj) && is_object ($obj);
  }

  public static function verifyCreateObject ($obj) {
    return self::verifyObject ($obj) && $obj->is_valid ();
  }

  public static function verifyArray ($obj, $minCount = 1, $maxCount = null) {
    if (self::verifyNumber ($minCount) && self::verifyNumber ($maxCount) && ($maxCount < $minCount)) $minCount = $maxCount = null;
    return self::verifyBase ($obj) && is_array($obj) && (count($obj) >= $minCount) && ((self::verifyNumber ($maxCount) && (count($obj) <= $maxCount)) || !self::verifyNumber ($maxCount));
  }

  public static function verifyString ($obj, $exceptions = array ('')) {
    return self::verifyBase ($obj) && is_string ($obj) && ((self::verifyArray ($exceptions) && !in_array($obj, $exceptions)) || !self::verifyArray ($exceptions));
  }
  
  public static function verifyNumber ($obj, $min = null, $max = null) {
    if (self::verifyBase ($min) && is_numeric ($min) && self::verifyBase ($max) && is_numeric ($max) && ($max < $min)) $min = $max = null;
    return self::verifyBase ($obj) && is_numeric ($obj) && ((self::verifyNumber ($min) && ($obj >= $min)) || !self::verifyNumber ($min)) && ((self::verifyNumber ($max) && ($obj <= $max)) || !self::verifyNumber ($max));
  }
  
  public static function verifyArrayFormat ($obj = array (), $items = array ()) {
    $isTrue = true; $isTrue &= (self::verifyArray ($obj) && self::verifyArray ($items));
    if ($isTrue) foreach ($items as $item) $isTrue &= array_key_exists ($item, $obj);
    return $isTrue;
  }
  
  public static function verifyArrayHasElement ($obj = array (), $items = array ()) {
    $isTrue = true; $isTrue &= (self::verifyArray ($obj) && self::verifyArray ($items));
    if ($isTrue) foreach ($items as $item) $isTrue &= in_array ($item, $obj);
    return $isTrue;
  }
  
  public static function verifyItemInArray ($obj, $items = array ()) {
    return self::verifyBase ($obj) && self::verifyArray ($items) && in_array($obj, $items);
  }
  
  public static function utilitySameLevelPath ($obj) {
    return self::verifyString ($obj) ? preg_replace ('/\/(\.?\/)+/', '/', $obj) : '';
  }
  
  public static function utilityPath ($obj) {
    return trim (self::utilitySameLevelPath ($obj), '/');
  }
  
  public static function verifyExist ($filePath) {
    return self::verifyString ($filePath) && file_exists ($filePath);
  }
  
  public static function verifyFolderExist ($folderPath) {
    return self::verifyExist ($folderPath) && is_dir ($folderPath);
  }
  
  public static function verifyFolderWriteable ($folderPath) {
    return self::verifyFolderExist ($folderPath) && is_writeable ($folderPath);
  }
  
  public static function verifyFolderReadable ($folderPath) {
    return self::verifyFolderExist ($folderPath) && is_readable ($folderPath);
  }
  
  public static function ObjName2FileName ($folderPath) {
    $arr = array (); for ($i = 65; $i <= 90 ; $i++) $arr[chr ($i)] = "_" . chr ($i + 32);
    return preg_replace ('/^\_/', '', strtr ($folderPath, $arr));
  }
  
  public static function verifyFileExist ($folderPath) {
    return self::verifyExist ($folderPath) && is_file ($folderPath);
  }
  
  public static function verifyFileReadable ($folderPath) {
    return self::verifyFileExist ($folderPath) && is_readable ($folderPath);
  }
  
  public static function verifyFileWriteable ($folderPath) {
    return self::verifyFileExist ($folderPath) && is_writeable ($folderPath);
  }

  public function verifyDimension ($dimension) {
    return self::verifyArrayFormat ($dimension, array ('width', 'height')) && self::verifyNumber ($dimension['width'], 1) && self::verifyNumber ($dimension['height'], 1);
  }
  
  public static function showError ($message) {
    // exit ("<style type='text/css'>fr { color: red;}</style><pre>" . $message . "</pre>");
    throw new RuntimeException ("<style type='text/css'>fr { color: red;}</style><pre>" . $message . "</pre>");
  }
}