<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * @author      OA Wu <comdan66@gmail.com>
 * @copyright   Copyright (c) 2014 OA Wu Design
 */

if (!function_exists ('verifyNotNull')) {
  function verifyNotNull ($obj) {
    return isset ($obj) && ($obj !== null);
  }
}

if (!function_exists ('verifyBoolean')) {
  function verifyBoolean ($obj, $compare = null) {
    return verifyNotNull ($obj) && is_bool ($obj) && ((!verifyBoolean ($compare)) || ($compare === $obj));
  }
}

if (!function_exists ('verifyObject')) {
  function verifyObject ($obj) {
    return verifyNotNull ($obj) && is_object ($obj);
  }
}

if (!function_exists ('verifyNumber')) {
  function verifyNumber ($obj, $min = null, $max = null) {
    if (verifyNotNull ($min) && is_numeric ($min) && verifyNotNull ($max) && is_numeric ($max) && ($max < $min)) $min = $max = null;
    return verifyNotNull ($obj) && is_numeric ($obj) && ((verifyNumber ($min) && ($obj >= $min)) || !verifyNumber ($min)) && ((verifyNumber ($max) && ($obj <= $max)) || !verifyNumber ($max));
  }
}

if (!function_exists ('verifyArray')) {
  function verifyArray ($obj, $minCount = 1, $maxCount = null) {
    if (verifyNumber ($minCount) && verifyNumber ($maxCount) && ($maxCount < $minCount)) $minCount = $maxCount = null;
    return verifyNotNull ($obj) && is_array ($obj) && (count ($obj) >= $minCount) && ((verifyNumber ($maxCount) && (count ($obj) <= $maxCount)) || !verifyNumber ($maxCount));
  }
}

if (!function_exists ('verifyString')) {
  function verifyString ($obj, $exceptions = array ('')) {
    return verifyNotNull ($obj) && is_string ($obj) && ((verifyArray ($exceptions) && !in_array ($obj, $exceptions)) || !verifyArray ($exceptions));
  }
}

if (!function_exists ('verifyJson')) {
  function verifyJsonString ($obj) {
    return verifyString ($obj) && json_decode ($obj);
  }
}

if (!function_exists ('verifyArrayFormat')) {
  function verifyArrayFormat ($obj = array (), $items = array ()) {
    return verifyArray ($items) && verifyArray ($obj) && verifyArray (array_filter (array_map (function ($item) use ($obj) { return array_key_exists ($item, $obj) ? true : null;}, $items)), count ($items), count ($items)) ? true : false;
  }
}

if (!function_exists ('verifyArrayHasElement')) {
  function verifyArrayHasElement ($obj = array (), $items = array (), $strict = true) {
    return verifyArray ($items) && verifyArray ($obj) && verifyBoolean ($strict) && verifyArray (array_filter (array_map (function ($item) use ($obj, $strict) { return in_array ($item, $obj, $strict) ? true : null;}, $items)), count ($items)) ? true : false;
  }
}

if (!function_exists ('verifyItemInArray')) {
  function verifyItemInArray ($obj, $items = array (), $strict = true) {
    return verifyNotNull ($obj) && verifyBoolean ($strict) && verifyArray ($items) && in_array ($obj, $items, $strict);
  }
}
