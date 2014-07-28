<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * @author      OA Wu <comdan66@gmail.com>
 * @copyright   Copyright (c) 2014 OA Wu Design
 */

include_once ('type_helper.php');

if (!function_exists ('objects_field_array')) {
  function objects_field_array ($objs, $key) {
    return verifyArray ($objs) && verifyString ($key) ? array_filter (array_map (function ($obj) use ($key) { return verifyNotNull ($obj->$key) ? $obj->$key : null; }, $objs)) : array ();
  }
}

if (!function_exists ('filter_objects_in_objects_by_value')) {
  function filter_objects_in_objects_by_value ($needle_value, $haystack_objs, $key) {
    return verifyNotNull ($needle_value) && verifyArray ($haystack_objs) && verifyString ($key) ? array_filter (array_map (function ($haystack_obj) use ($key, $needle_value) { return verifyNotNull ($haystack_obj->$key) && ($haystack_obj->$key == $needle_value) ? $haystack_obj : null ;}, $haystack_objs)) : array ();
  }
}

if (!function_exists ('filter_object_in_objects_by_value')) {
  function filter_object_in_objects_by_value ($needle_value, $haystack_objs, $key) {
    return verifyArray ($objects = filter_objects_in_objects_by_value ($needle_value, $haystack_objs, $key)) ? array_shift ($objects) : null;
  }
}

if (!function_exists ('in_objects_by_value')) {
  function in_objects_by_value ($needle_value, $haystack_objs, $key) {
    return verifyObject (filter_object_in_objects_by_value ($needle_value, $haystack_objs, $key)) ? true : false;
  }
}

if (!function_exists ('in_objects_by_object')) {
  function in_objects_by_object ($needle_obj, $haystack_objs, $key) {
    return verifyObject ($needle_obj) && verifyArray ($haystack_objs) && verifyString ($key) && verifyNotNull ($needle_obj->$key) && verifyNotNull ($needle_value = $needle_obj->$key) ? in_objects_by_value ($needle_value, $haystack_objs, $key) : false;
  }
}

if (!function_exists ('same_object_in_objects')) {
  function same_object_in_objects ($key) {
    $objectss = array (); for ($i = 1; $i < func_num_args (); $i++) { array_push ($objectss, func_get_arg ($i)); }
    $keys = array ();

    array_map (function ($objects) use (&$keys, $key) { array_push ($keys, objects_field_array ($objects, $key)); }, $objectss);

    $keys = call_user_func_array ('array_intersect', $keys);

    $array = array ();
    array_map (function ($objects) use (&$array, $keys, $key) { array_map (function ($k) use (&$array, $objects, $key) { if (!isset ($array[$k]) && ($object = filter_object_in_objects_by_value ($k, $objects, $key)) != null) { $array[$k] = $object; } }, $keys); }, $objectss);

    return array_filter ($array);    
  }
}

if (!function_exists ('verifyCreateObject')) {
  function verifyCreateObject ($obj) {
    return verifyObject ($obj) && $obj->is_valid ();
  }
}

if (!function_exists ('verifyUploadFormat')) {
  function verifyUploadFormat ($obj) {
    return verifyArrayFormat ($obj, array ('name', 'type', 'tmp_name', 'error', 'size'));
  }
}
  
if (!function_exists ('verifyUpdateUpload')) {
  function verifyUpdateUpload ($obj, $column) {
    return verifyUploadFormat ($obj) || verifyString ((string)$column);
  }
}

if (!function_exists ('append_condition')) {
  function append_condition (&$condition, $connection_symbol, $conditions) {
    if (!verifyArray ($condition)) $condition = array ('');

    $condition[0] .= (verifyString ($condition[0]) ? (' ' . $connection_symbol . ' ') : '') . $conditions;
    for ($i = 3; $i < func_num_args (); $i++) { array_push ($condition, func_get_arg ($i)); }
    return $condition;
  }
}

if (!function_exists ('append_sub_condition')) {
  function append_sub_condition (&$condition, $connection_symbol, $sub_condition) {
    if (!verifyArray ($condition)) $condition = array ('');
    if (!verifyArray ($sub_condition)) $sub_condition = array ('');

    if (verifyString ($sub_condition[0])) {
      $condition[0] .= (verifyString ($condition[0]) ? (' ' . $connection_symbol . ' ') : '') . ('(' . array_shift ($sub_condition) . ')');

      array_map (function ($sub) use (&$condition) { array_push ($condition, $sub); }, $sub_condition);
    }
    return $condition;
  }
}