<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * @author      OA Wu <comdan66@gmail.com>
 * @copyright   Copyright (c) 2014 OA Wu Design
 */
class PictureTag extends OaModel {

  static $table_name = 'picture_tags';

  static $has_many = array (
    array ('picture_mappings', 'class_name' => 'PictureTagMapping'),
    array ('pictures' , 'class_name' => 'Picture', 'through' => 'tag_mappings', 'order'=> 'pageview DESC'),
  );

  // static $has_one = array (
  //   array ('units_count_obj', 'class_name' => 'Unit', 'through' => 'tag_mappings', 'select' => 'COUNT(*) AS count', 'conditions' => array ('status = ?', 'certified')),
  // );  

  public function __construct ($attributes = array (), $guard_attributes = TRUE, $instantiating_via_find = FALSE, $new_record = TRUE) {
    parent::__construct ($attributes, $guard_attributes, $instantiating_via_find, $new_record);
  }

  // public function recycle () {
  //   array_map (function ($unit_mapping) { $unit_mapping->recycle (); }, $this->unit_mappings);
  //   return parent::recycle ();
  // }

  // public static function __callStatic ($method, $args) {
  //   switch (substr ($method, 11, 7)) {
  //     case 'all': return SpecialTag::all (); break;
  //     case 'find_by':
  //       switch (substr ($method, 19)) {
  //         case 'id': case 'name': return call_user_func_array ('SpecialTag::find', array_merge (array ('id'), $args)); break;
  //         default: showError ('Call to undefined attribute: ' . substr ($method, 19)); break;
  //       }
  //       break;
  //     default: return parent::__callStatic ($method, $args); break;
  //   }
  // }
}
