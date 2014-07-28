<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

if ( ! function_exists('get_objects_field_array')) {
  function objects_field_array ($objs, $key) {
    return array_filter (array_map (function ($obj) use ($key) { return isset ($obj->$key) ? $obj->$key : null; }, $objs));
  }
}

if ( ! function_exists('filter_objects_in_objects_by_value')) {
  function filter_objects_in_objects_by_value ($needle_value, $haystack_objs, $key) {
    return array_filter (array_map (function ($haystack_obj) use ($key, $needle_value) { return isset ($haystack_obj->$key) && ($haystack_obj->$key == $needle_value) ? $haystack_obj : null ;}, $haystack_objs));
  }
}

if ( ! function_exists('filter_object_in_objects_by_value')) {
  function filter_object_in_objects_by_value ($needle_value, $haystack_objs, $key) {
    return count ($objects = filter_objects_in_objects_by_value ($needle_value, $haystack_objs, $key)) ? array_shift ($objects) : null;
  }
}

if ( ! function_exists('value_in_objects')) {
  function in_objects_by_value ($needle_value, $haystack_objs, $key) {
    return filter_object_in_objects_by_value ($needle_value, $haystack_objs, $key) != null ? true : false;
  }
}

if ( ! function_exists('object_in_objects')) {
  function in_objects_by_object ($needle_obj, $haystack_objs, $key) {
    return $has_same = (isset ($needle_obj) && isset ($haystack_objs) && isset ($key) && is_object ($needle_obj) && (is_array ($haystack_objs) && count ($haystack_objs)) && is_string ($key) && ($key != '') && isset ($needle_obj->$key) && $needle_value = $needle_obj->$key) ? in_objects_by_value ($needle_value, $haystack_objs, $key) : false;
  }
}

if ( ! function_exists('same_object_in_objects')) {
  function same_object_in_objects ($key) {
    $objectss = array (); for ($i = 1; $i < func_num_args (); $i++) { array_push ($objectss, func_get_arg ($i)); }
    $keys = array ();

    array_map (function ($objects) use (&$keys, $key) {
      array_push ($keys, objects_field_array ($objects, $key));
    }, $objectss);

    $keys = call_user_func_array ('array_intersect', $keys);

    $array = array ();
    array_map (function ($objects) use (&$array, $keys, $key) { array_map (function ($k) use (&$array, $objects, $key) { if (!isset ($array[$k]) && ($object = filter_object_in_objects_by_value ($k, $objects, $key)) != null) { $array[$k] = $object; } }, $keys); }, $objectss);

    return array_filter ($array);    
  }
}